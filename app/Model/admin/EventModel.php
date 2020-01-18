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

class EventModel extends Model
{

    use SoftDeletes;

    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [];

    /**
     * relation for event category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function REL_Event_Category()
    {
        return $this->hasOne('App\Model\admin\CategoryModel', 'id', 'category_id')
            ->select('category_name', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function REL_Event_Organizer()
    {
        return $this->hasOne('App\User', 'id', 'organizer_id')
            ->select('first_name', 'last_name', 'id', 'email');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function REL_Event_Image()
    {
        return $this->hasMany('App\Model\admin\EventImageModel', 'event_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function REL_event_ticket()
    {
        return $this->hasMany('App\Model\admin\TicketModel', 'event_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function REL_event_subcategory()
    {
        return $this->hasOne('App\Model\admin\SubCategoryModel', 'id', 'subcategory_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organizer()
    {
        return $this->hasOne('App\User', 'id', 'organizer_id');
    }


    /**
     * @param $lat
     * @param $lng
     * @param $distance
     * @return mixed
     */
    public static function getByDistance($lat, $lng, $distance)
    {
        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( cityLat ) ) * cos( radians( cityLng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(cityLat) ) ) ) AS distance FROM events HAVING distance < ' . $distance . ' ORDER BY distance'));
        return $results;
    }

    /**
     * tags that belong to the events.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(TagsModel::class, 'tag_event', 'event_id', 'tag_id');
    }
}
