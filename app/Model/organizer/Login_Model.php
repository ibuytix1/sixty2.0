<?php

namespace App\Model\organizer;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Helper;

class Login_Model extends Model
{

    /**
     * @Author:          Rishikesh
     * @Last modified:   <21-02-2019>
     * @Project:         <adsd>
     * @Function:        <check_login>
     * @Description:     <this function load check login>
     * @Parameters:      <email and password>
     * @Method:          <NO>
     * @Returns:         <Yes>
     * @Return Type:     <array>
     */
    public function check_login($username, $password)
    {
        $userdata = DB::table('orgnisars')
            ->where('email', $username)
            ->where('password', $password)
            ->first();
        return $userdata;
    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <21-02-2019>
     * @Project:         <adsd>
     * @Function:        <check_login>
     * @Description:     <this function load check login>
     * @Parameters:      <email and password>
     * @Method:          <NO>
     * @Returns:         <Yes>
     * @Return Type:     <array>
     */
    public function get_userDetail($username)
    {
        $userdata = DB::table('orgnisars')
            ->select('full_name', 'email', 'first_name', 'last_name')
            ->where('email', $username)
            ->first();
        if (!empty($userdata)) {
            return $userdata;
        } else {
            return null;
        }

    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <23-02-2019>
     * @Project:         <Event ticketing>
     * @Function:        <check_password>
     * @Description:     <this function load check login>
     * @Parameters:      <email and password>
     * @Method:          <NO>
     * @Returns:         <Yes>
     * @Return Type:     <array>
     */
    public function check_password($username, $password)
    {
        $userdata = DB::table('admin')
            ->select('username', 'password')
            ->where('username', $username)
            ->where('password', $password)
            ->first();
        return $userdata;
    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <23-02-2019>
     * @Project:         <Event ticketing>
     * @Function:        <change_password>
     * @Description:     <this function chnage password>
     * @Parameters:      <email and password>
     * @Method:          <NO>
     * @Returns:         <Yes>
     * @Return Type:     <array>
     */
    public function changePassword($username, $password)
    {
        $userdata = DB::table('admin')
            ->where('username', $username)
            ->update(['password' => $password]);
//        pr($userdata);
//        die();
        return $userdata;
    }
}
