<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\admin\EventModel;
use App\Model\admin\PaymentModel;
use DB;
use Session;
use Cookie;

class DashboardControler extends Controller
{
    /**
     * this function load models and authenticate user Request
     * DashboardControler constructor.
     */
    public function __construct()
    {
        $this->middleware('CheckAdminLogin');
    }

    /**
     * This function  use for admin Dashboard this methode gives count detail of users ,promoters , events , organizer
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request)
    {
        $data = array();
        $data['events'] = EventModel::get()->count();
        $data['users'] = User::where('user_type', 1)->count();
        $data['organizer'] = User::where('user_type', 2)->count();
        $data['promoter'] = User::where('user_type', 3)->count();
        $data['payment'] = PaymentModel::get()->count();
        return view('admin.dashboard', compact('data'));
    }

}
