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

    Route::get('login','AdminAuthController@login');
    Route::post('login','AdminAuthController@doLogin');


    Route::group(['middleware'=>'admin:admin'],function(){
        //logout
        Route::any('logout','AdminAuthController@logout')->name('admin.logout');

    Route::get('home', function () {
        return view('admin.home');
    });
});
});
