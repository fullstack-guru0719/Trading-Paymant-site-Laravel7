<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Holiday;
use App\Models\Invest;
use App\Models\Plan;
use App\Models\TimeSetting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function pending()
    {
        $page_title = 'Pending Deposits';
        $empty_message = 'No pending deposits.';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 2)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }


    public function approved()
    {
        $page_title = 'Approved Deposits';
        $empty_message = 'No approved deposits.';
        $deposits = Deposit::where('method_code','>=',1000)->where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function successful()
    {
        $page_title = 'Successful Deposits';
        $empty_message = 'No successful deposits.';
        $deposits = Deposit::where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Deposits';
        $empty_message = 'No rejected deposits.';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 3)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function deposit()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No deposit history available.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status','!=',0)->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        });
        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
                break;
            case 'list':
                $page_title .= 'Deposits History Search';
                break;
        }
        $deposits = $deposits->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.deposit.log', compact('page_title', 'search', 'scope', 'empty_message', 'deposits'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $page_title = $deposit->user->username.' requested ' . getAmount($deposit->amount) . ' '.$general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('page_title', 'deposit','details'));
    }




    public function approve(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $data = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $data->update(['status' => 1]);

        $user = User::find($data->user_id);
        $new_balance = getAmount($user->deposit_wallet + $data->amount);
        $user->deposit_wallet = $new_balance;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $data->user_id;
        $transaction->amount = getAmount($data->amount);
        $transaction->charge = getAmount($data->charge);
        $transaction->post_balance = getAmount($new_balance);
        $transaction->trx_type = '+';
        $transaction->trx =  $data->trx;
        $transaction->wallet_type =  'deposit_wallet';
        $transaction->details = 'Deposit Via ' . $data->gateway_currency()->name;
        $transaction->save();


        $gnl = GeneralSetting::first();
        if($gnl->deposit_commission == 1){
            $commissionType =  'deposit';
            levelCommission($data->user_id, $data->amount, $commissionType);
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
            $transaction->post_balance = getAmount($user->deposit_wallet, $baseCurrency);
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
                    $adminNotification->title = $gnl->cur_sym.getAmount($data->amount).' invested to '.$plan->name;
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


                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = $gnl->cur_sym.getAmount($data->amount).' invested to '.$plan->name;
                    $adminNotification->click_url = urlPath('admin.users.invests',$user->id);
                    $adminNotification->save();

                    if ($gnl->invest_commission == 1) {
                        $commissionType = 'invest';
                        levelCommission($user->id, $data->amount, $commissionType);
                    }
                    notify($user, $type = 'INVESTMENT_PURCHASE', [
                        'trx' => $invest->trx,
                        'amount' => getAmount($data->amount),
                        'currency' => $gnl->cur_text,
                        'interest_amount' => $interest_amount,
                    ]);
                    $user->save();
                }
            }
        }


        notify($user, 'DEPOSIT_APPROVE', [
            'method_name' => $data->gateway_currency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => getAmount($data->final_amo),
            'amount' => getAmount($data->amount),
            'charge' => getAmount($data->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($data->rate),
            'trx' => $data->trx,
            'post_balance' => $user->deposit_wallet
        ]);
        $notify[] = ['success', 'Deposit has been approved.'];
        return redirect()->route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|max:250'
        ]);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();


        $gnl = GeneralSetting::first();
        notify($deposit->user, 'DEPOSIT_REJECT', [
            'method_name' => $deposit->gateway_currency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => getAmount($deposit->final_amo),
            'amount' => getAmount($deposit->amount),
            'charge' => getAmount($deposit->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($deposit->rate),
            'trx' => $deposit->trx,
            'rejection_message' => $request->message
        ]);

        $notify[] = ['success', 'Deposit has been rejected.'];
        return  redirect()->route('admin.deposit.pending')->withNotify($notify);

    }
}
