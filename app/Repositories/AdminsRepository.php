<?php

namespace App\Repositories;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminsRepository
{
    /**
     * Get all reocrds
     *
     * @param array
     */
    public function all(){
        return DB::table('users')->get();
    }

    /**
     * Get all reocrds
     *
     * @param array
     */
    public function findItem(){

    }

    /**
     * Get Record By id
     *
     * @param $id
     */
    public function findById($id){
        $user = Admin::find($id);
        return $user;
    }


    /**
     * Get Record By Name
     *
     * @param $id
     */
    public function findByName($id){

    }

    /**
     * Get Record By Email
     *
     * @param $email
     */
    public function findByEmail($email){
        return Admin::where('email',$email)->first();

    }

    /**
     * Store new  Record
     * @param $userdata
     * @return
     */

    public function create(){
      return;
    }

    /**
     * Update existing Record
     * @param $user
     * @param $request
     * @return
     */
    public function update($user,$request){
        return  $this->findById($user->id)->update($this->UserData($user,$request));
    }

    /**
     * Delete Record By ID
     *
     * @param $id
     * @return
     */
    public function delete($id){
        return $this->findById($id)->delete();
    }


    /**
     * Get admin reset password data
     *
     * @param $admin
     * @param $token
     * @return bool
     */
   public function ResetAdminDataGet($admin,$token): bool
   {
    return DB::table('password_resets')->insert([
        'email' =>$admin->email,
        'token' =>$token,
        'created_at' =>Carbon::now(),
    ]);
   }

    /**
     * Check admin reset password token
     *
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
   public function ResetAdminTokenValidation($token){
    return DB::table('password_resets')
                ->where('token',$token)
                ->where('created_at','>',Carbon::now()->subHour(2))
                ->first();
   }


    /**
     * @param $adminData
     * @param $email
     * @return int
     */
    public function AdminPasswordUpdate($adminData, $email){
       return DB::table('password_resets')
            ->where('email',$email)
           ->update($adminData);
}

/**
     *  Delete other password reset tries
     * @param $email
     * @return int
     */
    public function AdminPasswordResetDelete($email)
    {
       return DB::table('password_resets')
            ->where('email',$email)
           ->delete();
}


}
