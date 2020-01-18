<?php

/**
 * Category_Model Class
 *
 * @package Model
 * @author Rishikesh singh
 * @version 1.0
 * @Description Category
 */

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class OrganizerModel extends Model {
    protected $table = 'users';
    protected $fillable = [];
}
