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

use Illuminate\Database\Eloquent\Model;

class TagsModel extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $created_at = '';

    /**
     * events that belong to the tags.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(EventModel::class, 'tag_event', 'tag_id', 'event_id');
    }
}
