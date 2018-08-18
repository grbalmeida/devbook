<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupCommentLike extends Model
{
    protected $table = 'group_comments_has_likes';

    protected $fillable = [
    	'user_id',
    	'comment_id',
    	'user_id'
    ];

}
