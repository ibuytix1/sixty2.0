<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function singleEvent($id)
    {
        $id_arr = ['id' => $id];
        Validator::make($id_arr, [
            'id' => 'required'
        ])->validate();
        setcookie('single_event', $id, time() + (300), "/");
        return view('event');
    }
    public function search(){
        return view('search');
    }
}
