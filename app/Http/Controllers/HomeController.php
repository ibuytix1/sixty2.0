<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = auth()->user()->user_type;
        switch($type){
            case 1:
                return redirect('user/dashboard');
                break;
            case 2:
                return redirect('organizer/dashboard');
                break;
            case 3:
                return redirect('promoter/dashboard');
                break;
            default:
                return redirect('login');
                break;
        }
    }
}
