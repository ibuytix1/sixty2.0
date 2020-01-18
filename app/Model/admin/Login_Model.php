<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Login_Model extends Model
{

    /**
     * this function load check login
     * @param $username
     * @param $password
     * @return bool
     */
    public function check_login($username, $password)
    {
        $admin = DB::table('user')
            ->where('email', $username)
            ->first();
        if (!$admin) {
            return false;
        }
        if (!Hash::check($password, $admin->password)) {
            return false;
        }
        return $admin;
    }

    /**
     * this function load check login
     * @param $username
     * @param $password
     * @return mixed
     */
    public function check_password($username, $password)
    {
        $userdata = DB::table('user')
            ->select('username', 'password')
            ->where('username', $username)
            ->where('password', $password)
            ->first();
        return $userdata;
    }

    /**
     * this function change password
     * @param $username
     * @param $password
     * @return mixed
     */
    public function changePassword($username, $password)
    {
        $userdata = DB::table('user')
            ->where('email', $username)
            ->update(['password' => $password]);
        return $userdata;
    }
}
