<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $page_title = 'Pending Withdrawals';
        $withdrawals = Withdrawal::where('status', 2)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }

    public function approved()
    {
        $page_title = 'Approved Withdrawals';
        $withdrawals = Withdrawal::where('status', 1)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::where('status', 3)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }

    public function log()
    {
        $page_title = 'Withdrawals Log';
        $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $withdrawals = Withdrawal::with(['user', 'method'])->where('status', '!=', 0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
        });

        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Withdrawal Search';
                $withdrawals = $withdrawals->where('status', 3);
                break;
            case 'log':
                $page_title .= 'Withdrawal History Search';
                break;
        }

        $withdrawals = $withdrawals->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'search', 'scope', 'withdrawals'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdrawal::where('id', $id)->where('status', '!=', 0)->with(['user', 'method'])->firstOrFail();
        $page_title = $withdrawal->user->username . ' Withdraw Requested ' . getAmount($withdrawal->amount) . ' ' . $general->cur_text;
        $details = ($withdrawal->withdraw_information != null) ? json_encode($withdrawal->withdraw_information) : null;
        $methodImage = getImage(imagePath()['withdraw']['method']['path'] . '/' . $withdrawal->method->image,'800x800');
        return view('admin.withdraw.detail', compact('page_title', 'withdrawal', 'details', 'methodImage'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', 2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $general = GeneralSetting::first();
        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal Marked as Approved.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', 2)->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = User::find($withdraw->user_id);
        $user->interest_wallet += $withdraw->amount;
        $user->save();


        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = getAmount($user->interest_wallet);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = getAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from Withdrawal Rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->wallet_type = 'interest_wallet';
        $transaction->save();


        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->interest_wallet),
            'admin_details' => $request->details
        ]);
        $notify[] = ['success', 'Withdrawal has been rejected.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

}
