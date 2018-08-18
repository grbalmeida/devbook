<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCommentLike extends Model
{
    protected $table = 'user_comments_has_likes';

    protected $fillable = [
    	'comment_id',
    	'user_id'
    ];

}
