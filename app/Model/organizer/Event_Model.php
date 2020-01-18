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

class Event_Model extends Model
{

    use SoftDeletes;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [];


    /*
   * @Class:           <Event Model>
   * @Function:        <REL_Category>
   * @Author:           Rishikesh Singh
   * @Created On:      <28-Feb-2018>
   * @Last Modified By:Ramayan Prasad
   * @Last Modified:   <>
   * @Description:     <>
   */
    public function REL_Event_Category()
    {
        return $this->hasOne('App\Model\admin\CategoryModel', 'id', 'category_id');
    }

    /*
   * @Class:           <Event Model>
   * @Function:        <REL_Organizer>
   * @Author:          Ramayan Prasad
   * @Created On:      <28-Feb-2018>
   * @Last Modified By:Rishikesh singh
   * @Last Modified:   <>
   * @Description:     <>
   */
    public function REL_Event_Organizer()
    {
        return $this->hasOne('App\User', 'id', 'organizer_id');
    }

    /*
   * @Class:           <Event Model>
   * @Function:        <REL_Organizer>
   * @Author:          Ramayan Prasad
   * @Created On:      <28-Feb-2018>
   * @Last Modified By:Rishikesh singh
   * @Last Modified:   <>
   * @Description:     <>
   */
    public function REL_Event_Image()
    {
        return $this->hasMany('App\Model\admin\EventImageModel', 'event_id', 'id');
    }

    /*
    * @Class:           <Event Model>
    * @Function:        <event Ticket>
    * @Author:          Ramayan Prasad
    * @Created On:      <28-Feb-2018>
    * @Last Modified By:Rishikesh singh
    * @Last Modified:   <>
    * @Description:     <>
    */
    public function REL_event_ticket()
    {
        return $this->hasMany('App\Model\admin\TicketModel', 'event_id', 'id');
    }

    private function getDraftEventListDatatableQuery($data)
    {

        //DB::connection()->enableQueryLog();

        $query = DB::table($this->table . ' AS C');
        //$query->select(DB::raw("E.name, from_unixtime(E.start_date, '%Y %D %M %h:%i:%s'), E.end_date"));

        $query->select(DB::raw('C.*, C.id AS DT_RowId, C.event_title'));
        if (!empty($data['q'])) {
            //$query->where('EA.user_id', $data['q']);
        }

        // filter by seach
        $generalSearch = (isset($data['query']['generalSearch']) ? $data['query']['generalSearch'] : '');
        if (!empty($generalSearch)) {

            $columnSearch = array(
                ''
            );

            $whereSql = '';
            foreach ($columnSearch as $item) {
                $whereSql .= $item . " LIKE '%" . $generalSearch . "%' OR ";
            }

            if (!empty($whereSql)) {
                $whereSql = '(' . rtrim($whereSql, ' OR ') . ')';
                $query->whereRaw($whereSql);
            }
        }
        // ORDER BY
        if (isset($data['sort']['field'])) {
            $query->orderBy($data['sort']['field'], $data['sort']['sort']);
        } else {
            $query->orderBy('C.id', 'ASC');
        }
        return $query;
    }


    public function getDraftEventListDatatable($data)
    {

        $page = !empty($data['pagination']['page']) ? $data['pagination']['page'] : 1;
        $perPage = !empty($data['pagination']['perpage']) ? $data['pagination']['perpage'] : 10;
        $start = (($page - 1) * $perPage);

        $query = $this->getDraftEventListDatatableQuery($data);

        $query->offset($start);
        $query->limit($perPage);
        $items = $query->get();

        $totalRecords = $this->getDreaftEventDatatableFilteredCount($data);
        $finalArray['meta'] = array(
            'page' => $page,
            'pages' => ceil($totalRecords / $perPage),
            'perpage' => (int)$perPage,
            'total' => (int)$totalRecords,
            //'sort' => 'desc',
            //'field' => 'health_tip_id'
        );
        $finalArray['data'] = $items;

        //pr(DB::getQueryLog());exit;
        //pr($items);exit;

        return $finalArray;
    }

    function getDreaftEventDatatableFilteredCount($data)
    {
        return $this->getDraftEventListDatatableQuery($data)->count();
    }

    // delete other records related to the event
    /*public static function boot() {
        parent::boot();
        static::deleting(function($event) {
            // before delete() method call this
            // $event->photos()->delete();
            // do the rest of the cleanup...
        });
    }*/


}
