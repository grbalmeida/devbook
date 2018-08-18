<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use UserPostLike;
use UserPostComment;
use UserPostPhoto;

class UserPost extends Model
{
	protected $table = 'user_has_posts';

	protected $fillable = [
		'post',
		'user_id'
	];

	public function likes()
	{
		return $this->hasMany(UserPostLike::class, 'post_id');
	}

	public function comments()
	{
		return $this->hasMany(UserPostComment::class, 'post_id');
	}

	public function photos()
	{
		return $this->hasMany(UserPostPhoto::class, 'post_id');
	}

}
