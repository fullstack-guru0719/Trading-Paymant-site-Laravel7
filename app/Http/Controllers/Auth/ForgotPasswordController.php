<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showLinkRequestForm()
    {
        $page_title = "Forgot Password";
        return view(activeTemplate() . 'user.auth.passwords.email', compact('page_title'));
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notify[] = ['error', 'User not found.'];
            return back()->withNotify($notify);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        PasswordReset::create([
            'email' => $user->email,
            'token' => $code,
            'created_at' => \Carbon\Carbon::now(),
        ]);

        $userAgent = getIpInfo();
        send_email($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userAgent['os_platform'],
            'browser' => @$userAgent['browser'],
            'ip' => @$userAgent['ip'],
            'time' => @$userAgent['time']
        ]);

        $page_title = 'Account Recovery';
        $email = $user->email;
        $notify[] = ['success', 'Password reset email sent successfully'];
        return view(activeTemplate() . 'user.auth.passwords.code_verify', compact('page_title', 'email'))->withNotify($notify);
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code.*' => 'required', 'email' => 'required']);
        $code =  str_replace(',','',implode(',',$request->code));

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return redirect()->route('user.password.request')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return redirect()->route('user.password.reset', $code)->withNotify($notify);
    }

}
