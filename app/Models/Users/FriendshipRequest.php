<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendshipRequest extends Model
{
    protected $table = 'friendship_request';

    protected $fillable = [
    	'requested_user_id',
    	'request_user_id'
    ];

}
