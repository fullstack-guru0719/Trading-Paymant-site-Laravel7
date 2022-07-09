<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
	public function submitProfile(Request $request){
		$validator = Validator::make($request->all(),[
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }

        $user = auth()->user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
        ]);
	}

	public function submitPassword(Request $request){
		$password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }
        
        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = 'Password changes successfully';
        } else {
            $notify[] = 'The password doesn\'t match!';
        }
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['error'=>$notify],
        ]);
	}

	public function withdrawMethods(){
		$withdrawMethod = WithdrawMethod::where('status',1)->get();
		$notify[] = 'Withdraw methods';
		return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
            'data'=>[
            	'methods'=>$withdrawMethod,
            	'image_path'=>imagePath()['withdraw']['method']['path']
            ],
        ]);
	}

	public function withdrawStore(Request $request){
		$validator = Validator::make($request->all(), [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->first();
        if (!$method) {
            $notify[] = 'Method not found.';
            return response()->json([
                'code'=>404,
                'status'=>'error',
                'message'=>['error'=>$notify],
            ]);
        }
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = 'Your requested amount is smaller than minimum amount.';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
	            'message'=>['error'=>$notify],
	        ]);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = 'Your requested amount is larger than maximum amount.';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
	            'message'=>['error'=>$notify],
	        ]);
        }

        if ($request->amount > $user->balance) {
            $notify[] = 'You do not have sufficient balance for withdraw.';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
	            'message'=>['error'=>$notify],
	        ]);
        }



        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();

        $notify[] = 'Withdraw request stored successfully';
        return response()->json([
            'code'=>202,
            'status'=>'created',
            'message'=>['success'=>$notify],
            'data'=>$withdraw
        ]);
	}

	public function withdrawConfirm(Request $request){

        $withdraw = Withdrawal::with('method','user')->where('trx', $request->transaction)->where('status', 0)->orderBy('id','desc')->first();

        if (!$withdraw) {
            $notify[] = 'Withdraw request not found';
            return response()->json([
                'code'=>404,
                'status'=>'error',
	            'message'=>['error'=>$notify],
	        ]);
        }



        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $rules['transaction'] = 'required';
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }
        
        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = 'Wrong verification code';
                return response()->json([
                    'code'=>200,
                    'status'=>'ok',
	                'message'=>['error'=>$notify],
	            ]);
            }   
        }


        if ($withdraw->amount > $user->balance) {
            $notify[] = 'Your request amount is larger then your current balance.';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$notify],
            ]);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = 'Could not upload your ' . $request[$inKey];
                                    return response()->json([
						                'message'=>['error'=>$notify],
						            ]);
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = getAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from '.$user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        $general = GeneralSetting::first();
        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = 'Withdraw request sent successfully';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
        ]);
	}

    public function withdrawLog(){
        $withdrawals = Withdrawal::where('user_id', auth()->user()->id)->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
            return response()->json([
            'code'=>200,
            'status'=>'ok',
            'data'=>[
                'withdrawals'=>$withdrawals,
                'verification_file_path'=>imagePath()['verify']['withdraw']['path'],
            ]
        ]);
    }

    public function depositHistory(){
        $deposits = Deposit::where('user_id', auth()->user()->id)->where('status', '!=', 0)->with('gateway')->orderBy('id','desc')->paginate(getPaginate());
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'data'=>[
                'deposit'=>$deposits,
                'verification_file_path'=>imagePath()['verify']['deposit']['path'],
            ]
        ]);
    }

    public function transactions(){
        $user = auth()->user();
        $transactions = $user->transactions()->paginate(getPaginate());
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'data'=>[
                'transactions'=>$transactions,
            ]
        ]);
    }
}