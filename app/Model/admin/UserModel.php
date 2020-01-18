<?php

/**
 * UserModel Class
 *
 * @package Model
 * @author Rishikesh singh
 * @version 1.0
 * @Description User
 */

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $created_at='';
}
