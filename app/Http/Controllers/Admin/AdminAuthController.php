<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    /**
     *  Display login view
     */
    public function login(){
        return view('admin.login');
    }

    /**
     * Handle login process
     *
     * @return response
     */
    public function doLogin(){

        // Check for login inputs
        if(adminAuthGuard()->attempt($this->loginInputs(),$this->rememerme())){
            return redirect(admin_url('home'));
        } else {
            return redirect(admin_url('login'));
        }

    }

    /**
     *  Logout admin
     */
    public function logout(){
        adminAuthGuard()->logout();
        return redirect(admin_url('login'));
    }
    
    /**
     *  Display forgot password view
     */
    public function forgotpasword(){
       return view('admin.forgotpassword')
    }


    /*
    |--------------------------------------------------------------------------
    | Custom methods
    |--------------------------------------------------------------------------
    |*/

    /**
     * Check for  remeberme token
     */
    private function rememerme(){
        return request('rememberme') == 1 ? true: false;
    }

    /**
     * Login inputs
     */
    private function loginInputs(){
        return [
            'email'=> request('email'),
            'password'=> request('password'),
        ];
    }

}
