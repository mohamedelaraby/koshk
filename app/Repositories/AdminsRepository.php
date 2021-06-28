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
     */

    public function create($userdata){
        return Admin::create($userdata);
    }

    /**
     * Update existing Record
     */
    public function update($user,$request){
        return  $this->findById($user->id)->update($this->UserData($user,$request));
    }

    /**
     * Delete Record By ID
     *
     * @param $id
     */
    public function delete($id){
        return $this->findById($id)->delete();
    }


    /**
     * Get admin reset password data
     *
     * @param $id
     */
   public function ResetAdminDataGet($admin,$token){
    return DB::table('password_resets')->insert([
        'email' =>$admin->email,
        'token' =>$token,
        'created_at' =>Carbon::now(),
    ]);
   }

    /**
     * Check admin reset password token
     *
     * @param $id
     */
   public function ResetAdminTokenValidation($token){
    return DB::table('password_resets')
                ->where('token',$token)
                ->where('created_at','>',Carbon::now()->subHour(2))
                ->first();
   }





}
