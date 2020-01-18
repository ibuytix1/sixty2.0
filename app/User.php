<?php

namespace App;

use App\Model\admin\TicketModel;
use App\Model\Helpdesk;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'last_name', 'email', 'password', 'user_type', 'email_confirm', 'email_confirm_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->belongsToMany(TicketModel::class, 'orders', 'customer_id');
    }

    public function helpdesk()
    {
        return $this->belongsTo(Helpdesk::class);
    }
}
