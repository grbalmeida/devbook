<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use GroupPostComment;
use GroupCommentLike;

class GroupPostComment extends Model
{
    
	protected $table = 'group_posts_has_comments';

	protected $fillable = [
		'post_id',
		'user_id',
		'comment'
	];

	public function comments()
	{
		return $this->hasMany(GroupPostComment::class, 'parent_id');
	}

	public function likes()
	{
		return $this->hasMany(GroupCommentLike::class, 'comment_id');
	}

}
