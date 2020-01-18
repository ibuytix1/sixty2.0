<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HelpdeskCategory extends Model
{
    protected $table = 'helpdesk_category';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helpdesk(){
        return $this->hasMany(Helpdesk::class, 'category_id');
    }
}
