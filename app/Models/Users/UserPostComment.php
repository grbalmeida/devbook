<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostComment extends Model
{
    protected $table = 'user_posts_has_comments';

    protected $fillable = [
    	'post_id',
    	'user_id',
    	'parent_id'
    ];

}
