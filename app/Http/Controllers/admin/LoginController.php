<?php

namespace App\Http\Controllers\admin;

use App\Model\admin\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\Login_Model;
use DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Cookie;

class LoginController extends Controller
{

    /**
     * this function get login to user
     * @param Request $request
     * @return Response|int
     */
    public function get_login(Request $request)
    {
        $username = $request->input('email');
        $password = $request->input('password');
        $login = new Login_Model();
        $userdata = $login->check_login($username, $password);
        if (!empty($userdata)) {
            $sessionData = (array)$userdata; // user row
            Session::put('user_data', $sessionData);
            // password remember
            if ($request->has('remember')) {
                return $this->_manage_cookie($request, 14400); // set for 10 days
            } else {
                return $this->_manage_cookie($request, -5); // remove set password
            }
        } else if (!empty($userdata)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * this function change password
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword(Request $request)
    {
        $data = array();
        return view('admin.chnagePassword', $data);
    }

    /**
     * this function save change password
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveChangePassword(Request $request)
    {
        $login = new Login_Model();
        $this->_user_validation($request);
        $requestData = unsetData($request->all(), array('_token'));
        if ($requestData['new_password'] != $requestData['confirm_password']) {
            return redirect(config('constants.ADMIN_URL') . 'changePassword')
                ->with('status', 'Confirm password does not match with new password.');
        }
        $old_password = $requestData['old_password'];
        $email = Session::get('user_data')['email'];
        $user = Admin::where('email', $email)->first();
        if(!Hash::check($old_password, $user->password)) {
            return redirect(config('constants.ADMIN_URL') . 'changePassword')
                ->with('status', 'Old password does not matched');
        }
        $user->password = Hash::make($requestData['new_password']);
        if (!$user->save()) {
            return redirect(config('constants.ADMIN_URL') . 'changePassword')
                ->with('status', 'Something went wrong');
        }
        return redirect(config('constants.ADMIN_URL') . 'changePassword')
            ->with('status', 'Password changed successfully');
    }

    /**
     * @Author:          Rishikesh
     * @Last modified:   <21-02-2019>
     * @Project:        <Event Ticketing>
     * @Function:        <_user_validation>
     * @Description:     <this validate user input>
     * @Parameters:      <>
     * @Method:          <NO>
     * @Returns:         <Yes>
     * @Return Type:     <error>
     */
    private function _user_validation(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',

        ]);
        return;
    }

    /**
     * this function load check login
     * @param $username
     * @return mixed
     */
    public function email_exists($username)
    {
        $userdata = DB::table('hta_users')
            ->where('email', $username)
            ->count();
        return $userdata;
    }

    /**
     * this function load check login
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::flush(); // removes all session data
        Session::forget('user_data'); // Removes a specific variable
        return redirect(url(config('constants.ADMIN_URL')));
    }


    /**
     * this function manage cockie For remamber password and mail
     * @param $request
     * @param $minutes
     * @return Response
     */
    protected function _manage_cookie($request, $minutes)
    {
        $response = new Response('cookie');
        $response->withCookie(cookie('email', $request->input('email'), $minutes));
        $response->withCookie(cookie('password', $request->input('password'), $minutes));
        $response->withCookie(cookie('remember', $request->input('remember'), $minutes));
        return $response;
    }
}
