<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PromoterModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $created_at = '';
}

