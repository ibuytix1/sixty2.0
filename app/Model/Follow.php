<?php

/**
 * UserModel Class
 *
 * @package Model
 * @author Rishikesh singh
 * @version 1.0
 * @Description User
 */

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Follow extends Model
{

    /*    use SoftDeletes;*/

    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $created_at = '';

    /*
     * @Class:           <UserModel>
     * @Function:        <__construct>
     * @Author:          Rishikesh 
     * @Created On:      <1-03-2019>
     * @Last Modified:   <1-03-2019>
     * @Description:     <>
     */

    public function __construct()
    {
        $this->table = config('tables.follow');
    }

    public function organizer()
    {
        return $this->hasOne(User::class, 'id', 'followed_user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'follower_user_id');
    }
}
