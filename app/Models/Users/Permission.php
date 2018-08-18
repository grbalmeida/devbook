<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
    	'friendship_request',
    	'friends_list',
    	'posts'
    ];
}
