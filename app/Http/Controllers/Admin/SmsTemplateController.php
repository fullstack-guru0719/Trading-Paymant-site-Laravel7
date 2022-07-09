<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\SendSms;
use App\Models\GeneralSetting;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    public function index()
    {
        $page_title = 'SMS Templates';
        $empty_message = 'No templates available';
        $sms_templates = SmsTemplate::get();
        return view('admin.sms_template.index', compact('page_title', 'empty_message', 'sms_templates'));
    }

    public function edit($id)
    {
        $sms_template = SmsTemplate::findOrFail($id);
        $page_title = $sms_template->name;
        $empty_message = 'No shortcode available';
        return view('admin.sms_template.edit', compact('page_title', 'sms_template','empty_message'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sms_body' => 'required',
        ]);

        $sms_template = SmsTemplate::findOrFail($id);

        $sms_template->sms_body = $request->sms_body;
        $sms_template->sms_status = $request->sms_status ? 1 : 0;
        $sms_template->save();

        $notify[] = ['success', $sms_template->name . ' template has been updated'];
        return back()->withNotify($notify);
    }


    public function smsTemplate()
    {
        $page_title = 'SMS API';
        return view('admin.sms_template.sms_template', compact('page_title'));
    }

    public function smsTemplateUpdate(Request $request)
    {
        $request->validate([
            'sms_api' => 'required',
        ]);
        $general = GeneralSetting::first();
        $general->sms_api = $request->sms_api;
        $general->save();

        $notify[] = ['success', 'SMS template has been updated'];
        return back()->withNotify($notify);
    }

    public function sendTestSMS(Request $request)
    {
        $request->validate(['mobile' => 'required']);
        $general = GeneralSetting::first(['sn', 'sms_config','sms_api','sitename']);
        if ($general->sn == 1) {
            $gateway = $general->sms_config->name;
            $sendSms = new SendSms;
            $message = shortCodeReplacer("{{name}}", 'Admin', $general->sms_api);
            $message = shortCodeReplacer("{{message}}", 'This is a test sms', $message);
            $sendSms->$gateway($request->mobile,$general->sitename,$message,$general->sms_config);
        }

        $notify[] = ['success', 'You sould receive a test sms at ' . $request->mobile . ' shortly.'];
        return back()->withNotify($notify);
    }

    public function smsSetting(){
        $page_title = 'SMS Setting';
        return view('admin.sms_template.sms_setting',compact('page_title'));
    }


    public function smsSettingUpdate(Request $request){
        $request->validate([
            'sms_method' => 'required|in:clickatell,infobip,messageBird,nexmo,smsBroadcast,twilio,textMagic',
            'clickatell_api_key' => 'required_if:sms_method,clickatell',
            'message_bird_api_key' => 'required_if:sms_method,messageBird',
            'nexmo_api_key' => 'required_if:sms_method,nexmo',
            'nexmo_api_secret' => 'required_if:sms_method,nexmo',
            'infobip_username' => 'required_if:sms_method,infobip',
            'infobip_password' => 'required_if:sms_method,infobip',
            'sms_broadcast_username' => 'required_if:sms_method,smsBroadcast',
            'sms_broadcast_password' => 'required_if:sms_method,smsBroadcast',
            'text_magic_username' => 'required_if:sms_method,textMagic',
            'apiv2_key' => 'required_if:sms_method,textMagic',
            'account_sid' => 'required_if:sms_method,twilio',
            'auth_token' => 'required_if:sms_method,twilio',
            'from' => 'required_if:sms_method,twilio',
        ]);


        $request->merge(['name'=>$request->sms_method]);
        $data = array_filter($request->except('_token','sms_method'));
        $general = GeneralSetting::first();
        $general->sms_config = $data;
        $general->save();
        $notify[] = ['success', 'Sms configuration has been updated.'];
        return back()->withNotify($notify);
    }
}
