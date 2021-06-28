<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){

    Config::set('auth.define', 'admin');

    /*
    |--------------------------------------------------------------------------
    | Authntications Routes
    |--------------------------------------------------------------------------
    |*/

    Route::get('login','AdminAuthController@login')->name('admin.login');
    Route::post('login','AdminAuthController@doLogin');
    Route::get('forgotpassword','AdminAuthController@forgotPassword')->name('admin.forgotpassword-get');
    Route::post('forgotpassword','AdminAuthController@forgotPasswordPost')->name('admin.forgotpassword-post');
    Route::get('resetpassword/{token}','AdminAuthController@resetPassword')->name('admin.resetpassoword');


    Route::group(['middleware'=>'admin:admin'],function(){
        //logout
        Route::any('logout','AdminAuthController@logout')->name('admin.logout');

    Route::get('home','AdminController@dashboard')->name('admin.dashboard');
});
});
