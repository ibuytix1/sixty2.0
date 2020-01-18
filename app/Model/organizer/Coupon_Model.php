<?php

/**
 * Category_Model Class
 *
 * @package Model
 * @author Rishikesh singh
 * @version 1.0
 * @Description Category
 */

namespace App\Model\organizer;

use App\Model\admin\TicketModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Coupon_Model extends Model
{

    use SoftDeletes;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [''];

    /**
    * @Class:           <City_Model>
    * @Function:        <__construct>
    * @Author:          Rishikesh
    * @Created On:      <22-Feb-2019>
    * @Last Modified:   <22-Feb-2019>
    * @Description:     <>
    */

    public function __construct()
    {
        $this->table = config('tables.coupon');
    }

    public function event()
    {
        return $this->hasOne('App\Model\admin\EventModel', 'id', 'redeem_on')->select('id', 'event_title');
    }

/*    public function ticket(){
        return $this->hasOne(TicketModel::class, 'id', 'redeem_on');
    }*/
}
