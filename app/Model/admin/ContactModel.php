<?php

namespace App\Model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ContactModel extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [''];

    /**
     * relation event
     * this will return event details related to the contact.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event(){
        return $this->hasOne(EventModel::class, 'id', 'event_id');
    }
}
