<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersRepository
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
        $user = User::get();
        return $user->services();
    }

    /**
     * Get Record By id
     *
     * @param $id
     */
    public function findById($id){
        $user = User::find($id);
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
     * Store new  Record
     */

    public function create($userdata){
        return User::create($userdata);
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
     * Check for password
     *
     * @param $id
     */
    public function isPassword($user, $request){
        return $request->password ? bcrypt($request->password) : $user->password;
    }

    /**
     * Get user data
     *
     * @param mixed  $request
     *@return string
    */
    private function UserData($user,$request){


        return [
            'name' =>$request->name,
            'user_name' =>$request->user_name,
            'email' => $request->email,
            'password' => $this->isPassword($user,$request),
            'phone' => $request->phone,
            'img' => $this->uploadUserImage($user,$request),
            'code' => $this->codeHash($request),
            'notes' => $request->notes,
            'created_by' =>currentUser()->name,
        ];
    }


/**
 * Hash user code
 *
 * @param mixed  $request
 *@return string
 */
private function codeHash($request){
    if($request->code){
        return $request->code;
    } else {
        return Str::random(10);
    }
}

/**
 * Upload user image
 *
 * @param mixed  $request
 *@return string
 */
private function uploadUserImage($user,$request){

    if(request()->has('img')){
        return uploadImage('users_photos',$request->img);
    } else if($user->img){
        return $user->img;
    }
}



}
