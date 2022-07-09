<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSetting;
use Illuminate\Http\Request;

class TimeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Manage Time Settings";
        $team = TimeSetting::orderBy('id')->get();
        return view('admin.time_setting.index', compact('page_title', 'team'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'time' => 'required|numeric|min:0'
        ]);

        TimeSetting::create($request->all());
        $notify[] = ['success', 'Create Successfully'];
        return back()->withNotify($notify);

    }



    public function update(Request $request, TimeSetting $timeSetting, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'time' => 'required|numeric|min:0'
        ]);

        TimeSetting::whereId($id)->update($request->except(['_method', '_token']));

        $notify[] = ['success', 'Update Successfully'];
        return back()->withNotify($notify);
    }
}
