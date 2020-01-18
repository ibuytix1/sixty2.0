<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectToCreateEvent extends Controller
{
    public function eventCreate()
    {
        if(auth()->user()){
            if (auth()->user()->user_type == 1) {
                return redirect()->route('user-event-create');
            } elseif (auth()->user()->user_type == 2) {
                return redirect()->route('org-event-create');
            } elseif (auth()->user()->user_type == 3){
                return redirect()->route('promoter-event-create');
            } else {
                return redirect('/login');
            }
        }
        else {
            session()->put('redirect_to', 'create-event');
            return redirect('/login');
        }
    }
}
