<?php

/**
 * ManageStaticPageModel Class
 *
 * @package Model
 * @author Rishikesh singh
 * @version 1.0
 */

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ManageStaticPageModel extends Model {

    use SoftDeletes;

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];

    /*
     * @Class:           <ManageStaticPageModel>
     * @Function:        <__construct>
     * @Author:          Rishikesh 
     * @Created On:      <14-03-2019>
     * @Last Modified:   <22-03-2019>
     * @Description:     <>
     */

    public function __construct() {
        $this->table = config('tables.cms_pages');
    }
}
