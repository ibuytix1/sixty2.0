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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ContactModel extends Model {

    use SoftDeletes;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded  = [''];

     /*
     * @Class:           <City_Model>
     * @Function:        <__construct>
     * @Author:          Rishikesh 
     * @Created On:      <22-Feb-2019>
     * @Last Modified:   <22-Feb-2019>
     * @Description:     <>
     */

   public function __construct() {
        $this->table = config('tables.contact');
    }
   

}
