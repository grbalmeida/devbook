<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostLike extends Model
{
    protected $table = 'user_posts_has_likes';

    protected $fillable = [
    	'post_id',
    	'user_id'
    ];

}
