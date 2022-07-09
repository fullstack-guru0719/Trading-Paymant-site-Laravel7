<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use App\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawMethodController extends Controller
{
    public function methods()
    {
        $page_title = 'Withdraw Methods';
        $empty_message = 'Withdraw Methods not found.';
        $methods = WithdrawMethod::orderByDesc('status')->orderBy('id')->get();
        return view('admin.withdraw.index', compact('page_title', 'empty_message', 'methods'));
    }

    public function create()
    {
        $page_title = 'New Withdraw Method';
        return view('admin.withdraw.create', compact('page_title'));
    }

    public function store(Request $request)
    {
        $validation_rule = [
            'name' => 'required|max: 60',
            'image' => [
                'required',
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'rate' => 'required|gt:0',
            'delay' => 'required',
            'currency' => 'required',
            'min_limit' => 'required|gt:0',
            'max_limit' => 'required|gte:0',
            'fixed_charge' => 'required|gte:0',
            'percent_charge' => 'required|between:0,100',
            'instruction' => 'required|max:64000'
        ];
        $request->validate($validation_rule);
        $filename = '';
        $path = imagePath()['withdraw']['method']['path'];
        $size = imagePath()['withdraw']['method']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {

                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', preg_replace("/[^A-Za-z0-9 ]/", '', $request->field_name[$a])));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }
        $method = WithdrawMethod::create([
            'name' => $request->name,
            'image' => $filename,
            'rate' => $request->rate,
            'delay' => $request->delay,
            'min_limit' => $request->min_limit,
            'max_limit' => $request->max_limit,
            'fixed_charge' => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'currency' => $request->currency,
            'description' => $request->instruction,
            'user_data' => $input_form,
        ]);
        $notify[] = ['success', $method->name . ' has been added.'];
        return redirect()->route('admin.withdraw.method.index')->withNotify($notify);
    }


    public function edit($id)
    {
        $page_title = 'Update Withdraw Method';
        $method = WithdrawMethod::findOrFail($id);
        return view('admin.withdraw.edit', compact('page_title', 'method'));
    }

    public function update(Request $request, $id)
    {
        $validation_rule = [
            'name'           => 'required|max: 60',
            'image' => [
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'rate'           => 'required|gt:0',
            'delay'          => 'required',
            'min_limit'      => 'required|gt:0',
            'max_limit'      => 'required|gte:0',
            'fixed_charge'   => 'required|gte:0',
            'percent_charge' => 'required|between:0,100',
            'currency'       => 'required',
            'instruction'    => 'required|max:64000'
        ];

        $request->validate($validation_rule);

        $method = WithdrawMethod::findOrFail($id);
        $filename = $method->image;

        $path = imagePath()['withdraw']['method']['path'];
        $size = imagePath()['withdraw']['method']['size'];

        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image,$path, $size, $method->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }


        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();



                $arr['field_name'] = strtolower(str_replace(' ', '_', preg_replace("/[^A-Za-z0-9 ]/", '', $request->field_name[$a])));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }
        $method->update([
            'name'           => $request->name,
            'image'          => $filename,
            'rate'           => $request->rate,
            'delay'          => $request->delay,
            'min_limit'      => $request->min_limit,
            'max_limit'      => $request->max_limit,
            'fixed_charge'   => $request->fixed_charge,
            'percent_charge' => $request->percent_charge,
            'description'    => $request->instruction,
            'user_data'      => $input_form,
            'currency'      => $request->currency,
        ]);

        $notify[] = ['success', $method->name . ' has been updated.'];
        return back()->withNotify($notify);
    }



    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $method = WithdrawMethod::findOrFail($request->id);
        $method->update(['status' => 1]);
        $notify[] = ['success', $method->name . ' has been activated.'];
        return redirect()->route('admin.withdraw.method.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $method = WithdrawMethod::findOrFail($request->id);
        $method->update(['status' => 0]);
        $notify[] = ['success', $method->name . ' has been deactivated.'];
        return redirect()->route('admin.withdraw.method.index')->withNotify($notify);
    }

}
