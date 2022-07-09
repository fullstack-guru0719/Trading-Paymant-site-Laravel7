<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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


    public function sendResetCodeEmail(Request $request)
    {
        $validationRule = [
            'email'=>'required|email'
        ];
        $validator = Validator::make($request->all(),$validationRule);
        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            $notify[] = 'User not found.';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$notify],
            ]);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userAgent = getIpInfo();
        send_email($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userAgent['os_platform'],
            'browser' => @$userAgent['browser'],
            'ip' => @$userAgent['ip'],
            'time' => @$userAgent['time']
        ]);

        $email = $user->email;
        $notify[] = 'Password reset email sent successfully';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
            'data'=>['email'=>$email]
        ]);
    }


    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()]
            ]);
        }

        $code =  $request->code;

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = 'Invalid token';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$notify],
            ]);
        }

        $notify[] = 'You can change your password';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
            'data'=>[
                'token'=>$code,
                'email'=>$request->email,
            ]
        ]);
    }

}
