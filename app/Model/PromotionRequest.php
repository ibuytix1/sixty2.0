<?php

namespace App\Model;

use App\Model\organizer\Event_Model;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PromotionRequest extends Model
{
	protected $table = 'promotion_request';
    protected $guarded = [];
    protected $softDelete = true;

    /*------------------------ relations ------------------------*/
    /**
     * event details which is presented in the column
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event(){
        return $this->hasOne(Event_Model::class,'id','event_id')->with('REL_event_ticket');
    }

    /**
     * organizer details
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organizer(){
        return $this->hasOne(User::class, 'id', 'organizer_id');
    }

    public function promoter(){
        return $this->hasOne(User::class, 'id', 'promoter_id');
    }
    /*------------------------ mutators ------------------------*/
}
