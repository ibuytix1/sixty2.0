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



class SubCategoryModel extends Model {



    use SoftDeletes;



    protected $table;

    protected $primaryKey = 'id';

    protected $fillable = [];



    /*

     * @Class:           <City_Model>

     * @Function:        <__construct>

     * @Author:          Rishikesh 

     * @Created On:      <22-Feb-2019>

     * @Last Modified:   <22-Feb-2019>

     * @Description:     <>

     */



    public function __construct() {

        $this->table = config('tables.SubCategory');

    }



    /*

     * @Class:           <Technician_Model>

     * @Function:        <REL_Category> 

     * @Author:          Ramayan Prasad

     * @Created On:      <04-09-2018>

     * @Last Modified By:Ramayan Prasad

     * @Last Modified:   <>

     * @Description:     <>

     */



    public function REL_Category_Subcategory() {

        return $this->hasOne('App\Model\admin\CategoryModel','id','category_id');

    }

}

