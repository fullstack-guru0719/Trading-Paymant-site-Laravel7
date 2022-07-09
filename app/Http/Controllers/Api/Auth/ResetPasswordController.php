<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(),$this->rules());
        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
                'data'=>null
            ]);
        }
        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = 'Invalid verification code';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$notify],
            ]);
        }

        $user = User::where('email', $reset->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();



        $userAgent = getIpInfo();
        send_email($user, 'PASS_RESET_DONE', [
            'operating_system' => @$userAgent['os_platform'],
            'browser' => @$userAgent['browser'],
            'ip' => @$userAgent['ip'],
            'time' => @$userAgent['time']
        ]);


        $notify[] = 'Password changed';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['error'=>$notify]
        ]);
    }



    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

}
