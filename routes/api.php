<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('Api')->name('api.')->group(function(){
	Route::get('general-setting','BasicController@generalSetting');
	Route::get('unauthenticate','BasicController@unauthenticate')->name('unauthenticate');
	Route::get('languages','BasicController@languages');
	Route::get('language-data/{code}','BasicController@languageData');

	Route::namespace('Auth')->group(function(){
		Route::post('login', 'LoginController@login');
		Route::post('register', 'RegisterController@register');
		
	    Route::post('password/email', 'ForgotPasswordController@sendResetCodeEmail');
	    Route::post('password/verify-code', 'ForgotPasswordController@verifyCode');
	    
	    Route::post('password/reset', 'ResetPasswordController@reset');
	});


	Route::middleware('auth.api:sanctum')->name('user.')->prefix('user')->group(function(){
		Route::get('logout', 'Auth\LoginController@logout');
		Route::get('authorization', 'AuthorizationController@authorization')->name('authorization');
	    Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
	    Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
	    Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
	    Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

	    Route::middleware(['checkStatusApi'])->group(function(){
	    	Route::get('dashboard',function(){
	    		return auth()->user();
	    	});
	    	
	    });
	});
});