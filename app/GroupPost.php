<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model
{
    protected $table = 'group_has_posts';

    protected $fillable = [
    	'user_id',
    	'group_id',
    	'post'
    ];

}
