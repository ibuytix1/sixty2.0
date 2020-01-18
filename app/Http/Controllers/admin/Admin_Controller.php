<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

//use App\Model\Event_Model;
use App\Model\User_Model;


class Admin_Controller extends Controller
{

    private $userModel;
    protected $table = 'admin';

    public function __construct()
    {
        $this->userModel = new User_Model();
    }
}