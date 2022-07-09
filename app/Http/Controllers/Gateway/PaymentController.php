<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Holiday;
use App\Models\Invest;
use App\Models\Plan;
use App\Models\TimeSetting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function deposit()
    {
        $amount = session()->get('amount');
        $token = session()->get('token');

        $data['buttonText'] = "Deposit Now";
        $data['totalPayment'] = 0;
        $data['page_title'] = 'Deposit Methods';

        if ($token != null) {
            $plan = Plan::where('id', decrypt($token))->where('status', 1)->first();
            if (!$plan) {
                session()->forget('token');
                session()->forget('amount');
            }
            $data['plan'] = $plan;
            $data['totalPayment'] = decrypt($amount);
            $data['buttonText'] = "Pay Now";
            $data['page_title'] = 'Check Out';
        } else {
            session()->forget('amount');
            session()->forget('token');
        }


        $data['gatewayCurrency'] = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return view($this->activeTemplate . 'user.payment.deposit', $data);
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method_code' => 'required',
            'currency' => 'required',
        ]);
        $user = auth()->user();
        $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();


        if (!$gate) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }


        $token = session()->get('token');
        if ($token != null) {
            $amount = session()->get('amount');
            $requestAmount = decrypt($amount);
            $plan = Plan::where('id', decrypt($token))->where('status', 1)->first();
            $depo['plan_id'] = $plan->id;
        } else {
            $requestAmount = $request->amount;
        }


        if ($gate->min_amount > $requestAmount || $gate->max_amount < $requestAmount) {
            $notify[] = ['error', 'Please Follow Payment Limit'];
            return back()->withNotify($notify);
        }

        $charge = getAmount($gate->fixed_charge + ($requestAmount * $gate->percent_charge / 100));
        $payable = getAmount($requestAmount + $charge);
        $final_amo = getAmount($payable * $gate->rate);

        $depo['user_id'] = $user->id;
        $depo['method_code'] = $gate->method_code;
        $depo['amount'] = $request->amount;
        $depo['method_currency'] = strtoupper($gate->currency);
        $depo['charge'] = $charge;
        $depo['rate'] = $gate->rate;
        $depo['final_amo'] = getAmount($final_amo);
        $depo['btc_amo'] = 0;
        $depo['btc_wallet'] = "";
        $depo['trx'] = getTrx();
        $depo['try'] = 0;
        $depo['status'] = 0;
        $data = Deposit::create($depo);
        Session::put('Track', $data['trx']);
        return redirect()->route('user.deposit.preview');
    }


    public function depositPreview()
    {

        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->firstOrFail();
        if (is_null($data)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }
        if ($data->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }
        $page_title = 'Payment Preview';
        return view($this->activeTemplate . 'user.payment.preview', compact('data', 'page_title'));
    }


    public function depositConfirm()
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->with('gateway')->first();
        if (is_null($deposit)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }
        if ($deposit->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route('user.deposit')->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }
        $page_title = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'page_title', 'deposit'));
    }


    public static function userDataUpdate($trx)
    {
        $gnl = GeneralSetting::first();
        $data = Deposit::where('trx', $trx)->first();
        if ($data->status == 0) {
            $data['status'] = 1;
            $data->update();


            $gateway = $data->gateway;

            $user = User::find($data->user_id);
            $user->deposit_wallet += $data->amount;
            $user->save();

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'Deposit successful via '.$data->gateway_currency()->name;
            $adminNotification->click_url = urlPath('admin.deposit.successful');
            $adminNotification->save();

            $transaction = new Transaction();
            $transaction->user_id = $data->user_id;
            $transaction->amount = $data->amount;
            $transaction->post_balance = getAmount($user->deposit_wallet);
            $transaction->charge = getAmount($data->charge);
            $transaction->trx_type = '+';
            $transaction->details = 'Payment Via ' . $gateway->name;
            $transaction->trx = $data->trx;
            $transaction->wallet_type = 'deposit_wallet';
            $transaction->save();

            if ($gnl->deposit_commission == 1) {
                $commissionType = 'deposit';
                levelCommission($user->id, $data->amount, $commissionType);
            }

            if($data->plan_id){
                $plan = Plan::find($data->plan_id);


                $now = Carbon::now();
                $offDay = (array)$gnl->off_day;
                while(0==0){
                    $nextPossible = Carbon::parse($now)->addHours($plan->times)->toDateTimeString();
                    $dayName = strtolower(date('D',strtotime($nextPossible)));
                    $holiday = Holiday::where('date',date('Y-m-d',strtotime($nextPossible)))->count();
                    if(!array_key_exists($dayName, $offDay)){
                         if($holiday == 0){
                             $next = $nextPossible;
                             break;
                         }
                    }
                    $now = $nextPossible;
                }


                $time_name = TimeSetting::where('time', $plan->times)->first();
                $now = Carbon::now();

                $new_balance = getAmount($user->deposit_wallet - $data->amount);
                $user->deposit_wallet = $new_balance;
                $user->save();

                $baseCurrency =  currency()['fiat'];

                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = getAmount($data->amount);
                $transaction->charge = 0;
                $transaction->trx_type = '-';
                $transaction->trx = getTrx();
                $transaction->wallet_type = 'deposit_wallet';
                $transaction->details = 'Invested On ' . $plan->name;
                $transaction->post_balance = getAmount($user->deposit_wallet);
                $transaction->save();


                //start
                if ($plan->interest_status == 1) {
                    $interest_amount = ($data->amount * $plan->interest) / 100;
                } else {
                    $interest_amount = $plan->interest;
                }
                $period = ($plan->lifetime_status == 1) ? '-1' : $plan->repeat_time;
                //end

                if ($plan->fixed_amount == 0) {

                    if ($plan->minimum <= $data->amount && $plan->maximum >= $data->amount) {

                        $invest = new Invest();
                        $invest->user_id = $user->id;
                        $invest->plan_id = $plan->id;
                        $invest->amount = $data->amount;
                        $invest->interest = $interest_amount;
                        $invest->period = $period;
                        $invest->time_name = $time_name->name;
                        $invest->hours = $plan->times;
                        $invest->next_time = $next;
                        $invest->status = 1;
                        $invest->capital_status = $plan->capital_back_status;
                        $invest->trx = getTrx();
                        $invest->save();


                        if ($gnl->invest_commission == 1) {
                            $commissionType = 'invest';
                            levelCommission($user->id, $data->amount, $commissionType);
                        }

                        $adminNotification = new AdminNotification();
                        $adminNotification->user_id = $user->id;
                        $adminNotification->title = $gnl->cur_sym.$data->amount.' invested to '.$plan->name;
                        $adminNotification->click_url = urlPath('admin.users.invests',$user->id);
                        $adminNotification->save();

                        notify($user, $type = 'INVESTMENT_PURCHASE', [
                            'trx' => $invest->trx,
                            'amount' => getAmount($data->amount),
                            'currency' => $gnl->cur_text,
                            'interest_amount' => $interest_amount,
                        ]);
                    }

                } else {
                    if ($plan->fixed_amount == $data->amount) {

                        $invest = new Invest();
                        $invest->user_id = $user->id;
                        $invest->plan_id = $plan->id;
                        $invest->amount = $data->amount;
                        $invest->interest = $interest_amount;
                        $invest->period = $period;
                        $invest->time_name = $time_name->name;
                        $invest->hours = $plan->times;
                        $invest->next_time = $next;
                        $invest->status = 1;
                        $invest->capital_status = $plan->capital_back_status;
                        $invest->trx = getTrx();
                        $invest->save();

                        if ($gnl->invest_commission == 1) {
                            $commissionType = 'invest';
                            levelCommission($user->id, $data->amount, $commissionType);
                        }

                        $adminNotification = new AdminNotification();
                        $adminNotification->user_id = $user->id;
                        $adminNotification->title = $gnl->cur_sym.$data->amount.' invested to '.$plan->name;
                        $adminNotification->click_url = urlPath('admin.users.invests',$user->id);
                        $adminNotification->save();

                        notify($user, $type = 'INVESTMENT_PURCHASE', [
                            'trx' => $invest->trx,
                            'amount' => getAmount($data->amount),
                            'currency' => $gnl->cur_text,
                            'interest_amount' => $interest_amount,
                        ]);
                        $user->save();
                    }
                }

                session()->forget('amount');
                session()->forget('token');
            }
            notify($user, 'DEPOSIT_COMPLETE', [
                'method_name' => $data->gateway_currency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => getAmount($data->final_amo),
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $gnl->cur_text,
                'rate' => getAmount($data->rate),
                'trx' => $data->trx,
                'post_balance' => getAmount($user->deposit_wallet)
            ]);

        }


    }

    public function manualDepositConfirm()
    {
        $track = Session::get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route('user.deposit');
        }
        if ($data->status != 0) {
            return redirect()->route('user.deposit');
        }
        if ($data->method_code > 999) {
            $page_title = 'Deposit Confirm';
            $method = $data->gateway_currency();
            return view($this->activeTemplate . 'user.manual_payment.manual_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route('user.deposit');
        }
        if ($data->status != 0) {
            return redirect()->route('user.deposit');
        }

        $params = json_decode($data->gateway_currency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
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


        $this->validate($request, $rules);


        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['deposit']['path'] . '/' . $directory;


        $collection = collect($request);

        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {

                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {

                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
                                    return back()->withNotify($notify)->withInput();
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
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }
        $data->status = 2; // pending
        $data->update();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Deposit request from '.$data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
        $adminNotification->save();


        $gnl = GeneralSetting::first();
        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gateway_currency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => getAmount($data->final_amo),
            'amount' => getAmount($data->amount),
            'charge' => getAmount($data->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($data->rate),
            'trx' => $data->trx
        ]);
        $notify[] = ['success', 'You have deposit request has been taken.'];
        return redirect()->route('user.deposit.history')->withNotify($notify);
    }


}
