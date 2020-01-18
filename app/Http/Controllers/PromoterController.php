<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PromoterController extends Controller
{
    private $user_data;

    /**
     * check if promoter logged in view api
     * if true - login promoter in the web
     * PromoterController constructor.
     */
    public function __construct()
    {
        $email = getCookie('email');
        $this->user_data = User::where('email', $email)->first();
        if (!$this->user_data) {
            $this->middleware('auth');
        } elseif ($this->user_data->user_type == 3) {
            auth()->loginUsingId($this->user_data->id);
        } else {
            $this->middleware('auth');
            $this->middleware('promoter');
        }
    }

    /**
     * return promoters's dashboard
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
            return redirect()->route('promoter-event-create');
        }*/
        return view('promoter.dashboard');
    }

    /**
     * promoter profile view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myProfile()
    {
        return view('promoter.me.profile');
    }

    /**
     * promoter following list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function following()
    {
        return view('promoter.following.list');
    }

    /**
     * support tickets view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function support(){
        return view('promoter.support.list');
    }

    /**
     * promoter manage account view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageAccounts(){
        return view('promoter.account.list');
    }

    /**
     * promoter create event view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eventCreate(){
        return view('promoter.create-event');
    }
}
