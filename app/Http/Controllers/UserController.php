<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user_data;

    public function __construct()
    {
        $email = getCookie('email');
        $this->user_data = User::where('email', $email)->first();
        if (!$this->user_data) {
            $this->middleware('auth');
        } elseif ($this->user_data->user_type == 1) {
            auth()->loginUsingId($this->user_data->id);
        } else {
            $this->middleware('auth');
        }
    }

    /**
     * return user's dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        /*$came_from_single = getCookie('came_from_single');
        if($came_from_single == 1) {
            unsetCookie('came_from_single', '/decipher');
            return redirect('/checkout');
        } elseif (session()->get('redirect_to') == 'create-event') {
            session()->forget('redirect_to');
            return redirect()->route('user-event-create');
        }*/
        return view('user.dashboard');
    }

    /**
     * checkout
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout()
    {
        return view('user.checkout');
    }

    /**
     * user profile view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myProfile()
    {
        return view('user.me.profile');
    }

    /**
     * user manage account view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageAccounts()
    {
        return view('user.account.list');
    }

    /**
     * user create event view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eventCreate()
    {
        return view('user.create-event');
    }

    /**
     * list of following organizers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function following()
    {
        return view('user.following.list');
    }

    /**
     * list of support tickets raised and create new support tickets
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function support()
    {
        return view('user.support.list');
    }
    /**
     * logout user, organizer, promoter, admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        unsetCookie('email', '/decipher');
        unsetCookie('token', '/decipher');
        return redirect('/');
    }

}
