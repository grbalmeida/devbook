<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $table = 'user_has_relationships';

    protected $fillable = [
    	'user_id',
    	'friend_id'
    ];

}
