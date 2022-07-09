<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }
    public function checkValidCode($user, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$user->ver_code_send_at) return false;
        if ($user->ver_code_send_at->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->ver_code !== $code) return false;
        return true;
    }


    public function authorization()
    {
        $user = auth()->user();
        if (!$user->status) {

            auth()->user()->tokens()->delete();
            $notify[] = 'Your account has been deactivated';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify],
            ]);

        }elseif (!$user->ev) {
            if (!$this->checkValidCode($user, $user->ver_code)) {
                $user->ver_code = verificationCode(6);
                $user->ver_code_send_at = Carbon::now();
                $user->save();
                send_email($user, 'EVER_CODE', [
                        'code' => $user->ver_code
                    ]);
            }
            $notify[] = 'Email verification';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify],
                'data'=>[
                    'verification_url'=>route('api.user.verify.email'),
                    'verification_method'=>'POST',
                    'resend_url'=>route('api.user.send.verify.code').'?type=email',
                    'resend_method'=>'GET',
                    'verification_type'=>'email'
                ]
            ]);
        }elseif (!$user->sv) {
            if (!$this->checkValidCode($user, $user->ver_code)) {
                $user->ver_code = verificationCode(6);
                $user->ver_code_send_at = Carbon::now();
                $user->save();
                send_sms($user, 'SVER_CODE', [
                        'code' => $user->ver_code
                    ]);
            }
            $notify[] = 'SMS verification';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify],
                'data'=>[
                    'verification_url'=>route('api.user.verify.sms'),
                    'verification_method'=>'POST',
                    'resend_url'=>route('api.user.send.verify.code').'?type=phone',
                    'resend_method'=>'GET',
                    'verification_type'=>'sms'
                ]
            ]);
        }elseif (!$user->tv) {
            $notify[] = 'Google Authenticator';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify],
                'data'=>[
                    'verification_url'=>route('api.user.go2fa.verify'),
                    'verification_method'=>'POST',
                    'verification_type'=>'2fa'
                ]
            ]);
        }

    }

    public function sendVerifyCode(Request $request)
    {
        $user = Auth::user();


        if ($this->checkValidCode($user, $user->ver_code, 2)) {
            $target_time = $user->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            $notify[] = 'Please Try after ' . $delay . ' Seconds';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify]
            ]);
        }
        if (!$this->checkValidCode($user, $user->ver_code)) {
            $user->ver_code = verificationCode(6);
            $user->ver_code_send_at = Carbon::now();
            $user->save();
        } else {
            $user->ver_code = $user->ver_code;
            $user->ver_code_send_at = Carbon::now();
            $user->save();
        }



        if ($request->type === 'email') {
            send_email($user, 'EVER_CODE',[
                'code' => $user->ver_code
            ]);

            $notify[] = 'Email verification code sent successfully';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify]
            ]);
        } elseif ($request->type === 'phone') {
            send_sms($user, 'SVER_CODE', [
                'code' => $user->ver_code
            ]);
            $notify[] = 'SMS verification code sent successfully';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify]
            ]);
        } else {
            $notify[] = 'Sending Failed';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify]
            ]);
        }
    }

    public function emailVerification(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email_verified_code'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }


        $email_verified_code = $request->email_verified_code;
        $user = Auth::user();

        if ($this->checkValidCode($user, $email_verified_code)) {
            $user->ev = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            $notify[] = 'Email verified successfully';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify],
            ]);
        }
        $notify[] = 'Verification code didn\'t match!';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
        ]);
    }

    public function smsVerification(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'sms_verified_code'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }


        $sms_verified_code =  $request->sms_verified_code;

        $user = Auth::user();
        if ($this->checkValidCode($user, $sms_verified_code)) {
            $user->sv = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            $notify[] = 'SMS verified successfully';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['success'=>$notify],
            ]);
        }
        $notify[] = 'Verification code didn\'t match!';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
        ]);
    }
    public function g2faVerification(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'code'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }


        $code = $request->code;
        $response = verifyG2fa($user,$code);
        if ($response) {
            $notify[] = 'Verification successful';
        }else{
            $notify[] = 'Wrong verification code';
        }
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['error'=>$notify],
        ]);
    }
}
