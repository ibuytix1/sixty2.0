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

class PaymentModel extends Model {

    use SoftDeletes;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];

    /*
     * @Class:           <PaymentModel>
     * @Function:        <__construct>
     * @Author:          Rishikesh Singh
     * @Created On:      <28-Feb-2019>
     * @Last Modified:   <28-Feb-2019>
     * @Description:     <>
     */

    public function __construct() {
        $this->table = config('tables.orders');
    }


      /*
     * @Class:           <Technician_Model>
     * @Function:        <REL_Category> 
     * @Author:           Rishikesh Singh
     * @Created On:      <28-Feb-2018>
     * @Last Modified By:Ramayan Prasad
     * @Last Modified:   <>
     * @Description:     <>
     */
    public function REL__Category() {
        return $this->hasOne('App\Model\Admin\EventModel','id','category_id');
    }

      /*
     * @Class:           <Technician_Model>
     * @Function:        <REL_Organizer> 
     * @Author:          Ramayan Prasad
     * @Created On:      <28-Feb-2018>
     * @Last Modified By:Rishikesh singh
     * @Last Modified:   <>
     * @Description:     <>
     */
    public function REL_Event_Organizer() {
        return $this->hasOne('App\Model\Admin\OrganizerModel','id','organizer_id');
    }
}
