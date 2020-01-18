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

use App\Model\organizer\Coupon_Model;
use App\Model\organizer\Event_Model;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class TicketModel extends Model {

    /*use SoftDeletes;*/

    protected $table = 'event_ticket';
    protected $primaryKey = 'id';
    protected $fillable = [];

    /*----------------- relations --------------------------------*/
    public function users(){
        return $this->belongsToMany(User::class, 'orders', 'ticket_id');
    }

    public function event(){
        return $this->belongsTo(Event_Model::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon_Model::class);
    }

}
