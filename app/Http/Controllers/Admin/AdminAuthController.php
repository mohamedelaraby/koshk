<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        if(adminAuthGuard()->attempt($this->loginInputs(),$this->rememberme())){
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
    public function forgotPassword(){
       return view('admin.forgotpassword');
    }

    /**
     *  Display forgot password view
     */
    public function forgotPasswordPost(){

       $admin = Admin::where('email',request('email'))->first();

       // check for admin exists
        if(!empty($admin)){
            $token =


            // get the data
            $data =

            Mail::to($admin->email)->send(new AdminResetPassword(['data'=> $admin,'token'=>$data]));

            // session message
            session()->flash('success',trans('admin.link_reset_sent'));
            return back();
        }

            return back();
        }


    /*
    |--------------------------------------------------------------------------
    | Custom methods
    |--------------------------------------------------------------------------
    |*/

    /**
     * Check for  remeberme token
     */
    private function rememberme(){
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




    /**
     *  Find Admin email
     */
    private function ResetAdminEmail($email){
        return app('auth.password.broker')->createToken($admin);
    }

    /**
     *  Get token
     */
    private function ResetAdminToken($admin){
        return app('auth.password.broker')->createToken($admin);
    }

    /**
     *  Get Admin data
     */
    private function ResetAdminData($admin,$token){
        return DB::table('password_resets')->insert([
            'email' =>$admin->email,
            'token' =>$token,
            'created_at' =>Carbon::now(),
        ]);
    }
}
