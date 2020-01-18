<?php

/**
 * UserModel Class
 *
 * @package Model
 * @author Rishikesh singh
 * @version 1.0
 * @Description User
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class CartItem extends Model {

//    use SoftDeletes;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = ['ticket_id','quantity','price','ticket_type','user_id'];
    public $timestamps = true;

    /*
     * @Class:           <UserModel>
     * @Function:        <__construct>
     * @Author:          Rishikesh 
     * @Created On:      <1-03-2019>
     * @Last Modified:   <1-03-2019>
     * @Description:     <>
     */

    public function __construct() {
        $this->table = config('tables.cartitem'); 
    }
}
