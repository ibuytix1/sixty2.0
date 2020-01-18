<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HelpdeskImages extends Model
{
    protected $table = 'helpdesk_images';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function helpdesk()
    {
        return $this->belongsTo(Helpdesk::class);
    }
}
