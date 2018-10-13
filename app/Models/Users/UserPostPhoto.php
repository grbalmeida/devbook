<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserPostPhoto extends Model
{
	protected $table = 'user_posts_has_photos';

	protected $fillable = [
		'post_id',
		'image'
	];

}
