<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomAuthController extends Controller
{
    /**
     * return second registration form to complete user registration
     * @param $token
     * @param $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function completeRegisterForm($token, $email)
    {
        if (empty($token) && empty($email)){
            return redirect('/login');
        }
        $user = User::select('first_name', 'last_name', 'email')
                ->where('email', $email)
                ->where('email_confirm_code', $token)->first();
        if (!$user) {
            return redirect('login');
        }
        $name = $user->first_name . ' ' . $user->last_name;
        return view('auth.complete-register')->with('token', $token)
            ->with('name', $name)->with('email', $email);
    }



    /**
     * forget password view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function forgotPassword()
//    {
//        return view('auth.passwords.email');
//    }

    public function resetPassword($token)
    {
        if(empty($token)){
            return redirect('/login');
        }
        $reset_pass = DB::table('password_resets')->where('token', $token)->first();
        if(!$reset_pass){
            session()->flash('error', 'Reset password request not found');
            return redirect('/login');
        }
        $email = $reset_pass->email;
        $user = User::where('email', $email)->first();
        if(!$user){
            session()->flash('error', 'User not found');
            return redirect('/login');
        }
        $name = $user->first_name . ' ' . $user->last_name;
        return view('auth.passwords.reset')->with('token', $token)->with('email', $email)->with('name', $name);
    }
}
