<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use App\Repositories\AdminsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{


       /** @param $serviceRepository */
       private $adminsRepository;


       public function __construct(AdminsRepository $adminsRepository)
       {
           $this->adminsRepository = $adminsRepository;
       }

    /**
     *  Display login view
     */
    public function login(){
        return view('admin.login');
    }

    /**
     * Handle login process
     *
     * @return
     */
    public function doLogin()
    {

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

        // Find sdmin by email
       $admin = $this->adminsRepository->findByEmail(request('email'));

       // check for admin exists

        if(!empty($admin)){


            // Send mail
            Mail::to($admin->email)->send(new AdminResetPassword([
                'data'=> $admin,
                'token'=>$this->ResetAdminData($admin,$this->ResetAdminToken($admin))
            ]));

            // session message
            session()->flash('success',trans('admin.link_reset_sent'));
            return back();
        }

            return back();
    }

    /**
     *  Display forgot password view
     */
    public function recoverPasswordPost($token){

        //validation for new password
        $this->resetNewPasswordValidation();

        // Check for the token validation
        $checkToken = $this->adminsRepository->ResetAdminTokenValidation($token);

        // Check for the token
        if(!empty($checkToken)){
            // Update admin password
            // check for token admin email
            //update admin password
            $adminData = [
                'email' => $checkToken->email,
                'password' => bcrypt(request('password'))
            ];
            $this->adminsRepository->AdminPasswordUpdate($adminData,$checkToken->email);

            // Delete previous reset password processes
            $this->adminsRepository->AdminPasswordResetDelete(request('email'));

            // attempt the new password
            $this->doLogin();
        } else {
            redirect(admin_url('forgot_password'));
        }

    }


    public function recoverPassword($token): void
    {

        // Check for the token validation
        $checkToken = $this->adminsRepository->ResetAdminTokenValidation($token);

        // Check for the token
        $this->ResetAdminTokenCheck($checkToken);
    }





    /*
    |--------------------------------------------------------------------------
    | Custom methods
    |--------------------------------------------------------------------------
    |*/

    /**
     * Check for the token
     * @param $checkToken
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function ResetAdminTokenCheck($checkToken){
        if(!empty($checkToken)){
            return view('admin.recoverpassword',['data'=>$checkToken]);
        } else {
            return redirect(admin_url('forgotpassword'));
        }
    }


    /**
     * Check for  remeberme token
     */
    private function rememberme(): bool
    {
        return request('rememberme') === 1 ? true: false;
    }

    /**
     * Login inputs
     */
    private function loginInputs(): array
    {
        return [
            'email'=> request('email'),
            'password'=> request('password'),
        ];
    }

    /**
     *  Get token
     * @param $admin
     * @return string
     */
    private function ResetAdminToken($admin): string
    {
        return app('auth.password.broker')->createToken($admin);
    }

    /**
     *  Get Admin data
     */
    private function ResetAdminData($admin,$token){
        return $this->adminsRepository->ResetAdminDataGet($admin,$token);
    }

    /*
     *  Validation rules for new admin password
     * */

    private function resetNewPasswordValidation()
    {
        // Data
        $data = [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];

        // Messages
        $messages = [
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
        ];
        try {
            return $this->validate(request(), $data, [], $messages);
        } catch (ValidationException $e) {
            return $e;
        }
    }
}
