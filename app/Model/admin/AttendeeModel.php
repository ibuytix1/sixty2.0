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

use App\Model\organizer\Event_Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AttendeeModel extends Model {

    use SoftDeletes;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];

    /*
     * @Class:           <UserModel>
     * @Function:        <__construct>
     * @Author:          Rishikesh 
     * @Created On:      <1-03-2019>
     * @Last Modified:   <1-03-2019>
     * @Description:     <>
     */

    public function __construct() {
        $this->table = config('tables.attendee'); 
    }

    public function event() {
        return $this->belongsTo(Event_Model::class);
    }
}
