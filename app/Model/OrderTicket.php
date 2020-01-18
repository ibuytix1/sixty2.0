<?php

namespace App\Model;

use App\Model\admin\TicketModel;
use Illuminate\Database\Eloquent\Model;

class OrderTicket extends Model
{
    protected $table = 'order_tickets';
    protected $fillable;
    /*------------------- Relations -----------------------*/
    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    public function ticket(){
        return $this->hasOne(TicketModel::class, 'id', 'ticket_id');
    }
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    /*------------------- mutators -----------------------*/
    public function setAttendeesAttribute($value){
        $this->attributes['attendees'] = json_encode($value);
    }
    public function getAttendeesAttribute($value){
        return json_decode($value);
    }
}
