<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    protected $table = 'helpdesk';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(HelpdeskImages::class, 'helpdesk_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(HelpdeskCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organizer()
    {
        return $this->hasOne(User::class, 'id', 'organizer_id');
    }
}
