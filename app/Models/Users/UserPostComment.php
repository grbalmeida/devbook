<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use UserPostComment;
use UserCommentLike;

class UserPostComment extends Model
{
    protected $table = 'user_posts_has_comments';

    protected $fillable = [
    	'post_id',
    	'user_id',
    	'parent_id'
    ];

    public function comments()
    {
    	return $this->hasMany(UserPostComment::class, 'parent_id');
    }

    public function likes()
    {
    	return $this->hasMany(UserCommentLike::class, 'comment_id');
    }

}
