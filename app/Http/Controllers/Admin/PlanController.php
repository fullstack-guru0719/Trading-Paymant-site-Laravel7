<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\TimeSetting;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Manage Plan";
        $plan = Plan::latest()->paginate(getPaginate());
        return view('admin.plan.index', compact('page_title', 'plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Create New Plan";
        $time = TimeSetting::all();
        return view('admin.plan.create', compact('page_title','time'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation['name'] = 'required';
        $validation['times'] = 'numeric|min:0';
        $validation['interest'] = 'numeric|min:0';

        if ($request->amount_type == 'on') {
            $fixed_amount = $request->amount;
            $minimum = $request->amount;
            $maximum = $request->amount;
            $validation['amount'] = 'required|numeric|gt:0';
        }else{
            $fixed_amount = 0;
            $minimum = $request->minimum;
            $maximum= $request->maximum;
            $validation['minimum'] = 'required|numeric|gt:0';
            $validation['maximum'] = 'required|numeric|gt:minimum';
        }

        $interrest_status =  ($request->interest_status == '%') ? 1 : 0;

        if ($request->lifetime_status == 'on'){
            $lifetime_status = 0;
            $repeat_time = $request->repeat_time;
            $validation['repeat_time'] = 'required|integer|gt:0';
        }else{
            $lifetime_status = 1;
            $repeat_time = 0;
        }
        $this->validate($request,$validation);

        if ($request->capital_back_status == 'on'){
            $capital_back_status = ($lifetime_status == 1) ? 0 : 1;
        }else{
            $capital_back_status = 0;
        }

        if ($minimum < 0 or $maximum < 0 or $fixed_amount < 0){
            $notify[] = ['error', 'Invest Amount cannot lower than 0'];
            return back()->withNotify($notify);
        }

        if ($request->interest < 0){
            $notify[] = ['error', 'Interest cannot lower than 0'];
            return back()->withNotify($notify);
        }

        if ($repeat_time < 0){
            $notify[] = ['error', 'Return Time cannot lower than 0'];
            return back()->withNotify($notify);
        }

        Plan::create([
            'name' => $request->name,
            'minimum' => $minimum,
            'maximum' => $maximum,
            'fixed_amount' => $fixed_amount,
            'interest' => $request->interest,
            'interest_status' => $interrest_status,
            'times' => $request->times,
            'capital_back_status' => $capital_back_status,
            'lifetime_status' => $lifetime_status,
            'repeat_time' => $repeat_time,
            'status' => ($request->status == 'on') ? 1 : 0,
            'featured' => ($request->featured == 'on') ? 1 : 0
        ]);

        $notify[] = ['success', 'Create Successfully'];
        return back()->withNotify($notify);

    }


    public function edit($id)
    {
        $page_title = "Update Plan";
        $time = TimeSetting::all();
        $plan = Plan::whereId($id)->first();
        return view('admin.plan.edit', compact('page_title', 'plan','time'));
    }


    public function update(Request $request, $id)
    {
        $validation['name'] = 'required';
        $validation['times'] = 'numeric|min:0';
        $validation['interest'] = 'numeric|min:0';

        if ($request->amount_type == 'on') {
            $fixed_amount = $request->amount;
            $minimum = $request->amount;
            $maximum = $request->amount;
            $validation['amount'] = 'required|numeric|gt:0';
        }else{
            $fixed_amount = 0;
            $minimum = $request->minimum;
            $maximum= $request->maximum;
            $validation['minimum'] = 'required|numeric|gt:0';
            $validation['maximum'] = 'required|numeric|gt:minimum';
        }

        $interrest_status = ($request->interest_status == '%') ? 1 : 0;

        if ($request->lifetime_status == 'on'){
            $lifetime_status = 0;
            $repeat_time = $request->repeat_time;
            $validation['repeat_time'] = 'required|integer|gt:0';
        }else{
            $lifetime_status = 1;
            $repeat_time = 0;
        }
        $this->validate($request,$validation);

        if ($request->capital_back_status == 'on'){
            $capital_back_status =  ($lifetime_status == 1) ? 0 : 1;
        }else{
            $capital_back_status = 0;
        }


        if ($minimum < 0 or $maximum < 0 or $fixed_amount < 0){
            $notify[] = ['error', 'Invest Amount cannot lower than 0'];
            return back()->withNotify($notify);
        }

        if ($request->interest < 0){
            $notify[] = ['error', 'Interest cannot lower than 0'];
            return back()->withNotify($notify);
        }

        if ($repeat_time < 0){
            $notify[] = ['error', 'Return Time cannot lower than 0'];
            return back()->withNotify($notify);
        }

        Plan::whereId($id)->update([
            'name' => $request->name,
            'minimum' => $minimum,
            'maximum' => $maximum,
            'fixed_amount' => $fixed_amount,
            'interest' => $request->interest,
            'interest_status' => $interrest_status,
            'times' => $request->times,
            'capital_back_status' => $capital_back_status,
            'lifetime_status' => $lifetime_status,
            'repeat_time' => $repeat_time,
            'status' => ($request->status == 'on') ? 1 : 0,
            'featured' => ($request->featured == 'on') ? 1 : 0
        ]);

        $notify[] = ['success', 'Update Successfully'];
        return back()->withNotify($notify);
    }
}
