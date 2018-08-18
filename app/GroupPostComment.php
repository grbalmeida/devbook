<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPostComment extends Model
{
    
	protected $table = 'group_posts_has_comments';

	protected $fillable = [
		'post_id',
		'user_id',
		'comment'
	];

}
