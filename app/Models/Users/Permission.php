<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

	public $timestamps = false;

    protected $fillable = [
    	'user_id',
    	'friendship_request',
    	'friends_list',
    	'posts'
    ];
}
