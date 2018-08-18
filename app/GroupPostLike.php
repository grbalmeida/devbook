<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPostLike extends Model
{
    protected $table = 'group_posts_has_likes';

    protected $fillable = [
    	'post_id',
    	'user_id'
    ];

}
