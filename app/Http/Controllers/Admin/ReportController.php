<?php

namespace App\Http\Controllers\Admin;

use App\Models\CommissionLog;
use App\Http\Controllers\Controller;
use App\Models\Invest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transactionDeposit()
    {
        $page_title = 'Deposit Wallet Transaction Logs';
        $transactions = Transaction::with('user')->latest()->where('wallet_type','deposit_wallet')->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function transactionInterest()
    {
        $page_title = 'Interest Wallet Transaction Logs';
        $transactions = Transaction::with('user')->latest()->where('wallet_type','interest_wallet')->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Transactions Search - ' . $search;
        $empty_message = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->paginate(getPaginate());

        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function plan()
    {
        $page_title = 'Invest Plan Logs';
        $logs = Invest::latest()->paginate(getPaginate());
        $empty_message = 'No Data Found!';
        return view('admin.reports.plan-log', compact('page_title', 'logs', 'empty_message'));
    }

    public function planSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Invest Plan Search - ' . $search;
        $empty_message = 'No Data Found!';

        $logs = Invest::with('user','plan')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->paginate(getPaginate());

        return view('admin.reports.plan-log', compact('page_title', 'logs', 'empty_message'));
    }

    public function commissionsDeposit()
    {
        $page_title = 'Deposit Commission Log';
        $logs = CommissionLog::where('type','deposit')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $empty_message = 'No log.';
        return view('admin.reports.commission-log', compact('page_title', 'logs', 'empty_message'));
    }

    public function commissionsInvest()
    {
        $page_title = 'Invest Commission Log';
        $logs = CommissionLog::where('type','invest')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $empty_message = 'No log.';
        return view('admin.reports.commission-log', compact('page_title', 'logs', 'empty_message'));
    }

    public function commissionsInterest()
    {
        $page_title = 'Interest Commission Log';
        $logs = CommissionLog::where('type','interest')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $empty_message = 'No log.';
        return view('admin.reports.commission-log', compact('page_title', 'logs', 'empty_message'));
    }

    public function commissionsSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Commission Log Search -'.$search;
        $logs = CommissionLog::whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like',"%$search%");
            })->orWhere('trx', $search)->with(['user','bywho'])->latest()->paginate(getPaginate());
        $empty_message = 'No log.';
        return view('admin.reports.commission-log', compact('page_title', 'logs', 'empty_message','search'));
    }

}
