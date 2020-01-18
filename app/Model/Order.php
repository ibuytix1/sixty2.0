<?php

namespace App\Model;

use App\Model\organizer\Coupon_Model;
use App\Model\organizer\Event_Model;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable;
    protected $hidden = ['ticket_details'];

    /*----------------- relationships ---------------------------*/
    public function order_tickets()
    {
        return $this->hasMany(OrderTicket::class, 'order_id', 'id');
    }

    public function event()
    {
        return $this->hasOne(Event_Model::class, 'id', 'event_id');
    }

    public function coupon()
    {
        return $this->hasOne(Coupon_Model::class, 'id', 'coupon_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    /*---------------- mutator ------------------------------*/
    /*-------------------------------------------------------*/
    /*-------------------------------------------------------*/
    /*-------------------------------------------------------*/
    /*-------------------------------------------------------*/
    /*---------------- custom functions ------------------------------*/
    /**
     * generating unique barcode number
     * @return int
     */
    public function generateBarcodeNumber()
    {
        $min = 100000000;
        $max = 999999999;
        $number = rand((int)$min, (int)$max);
        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
        // otherwise, it's valid and can be used
        return $number;
    }
    /*-------------------------------------------------------*/
    /**
     * check if bar code already exists in database
     * @param $number
     * @return mixed
     */
    public function barcodeNumberExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return Order::whereBarcode($number)->exists();
    }
}
