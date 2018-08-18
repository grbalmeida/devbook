<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
	protected $table = 'user_has_posts';

	protected $fillable = [
		'post',
		'user_id'
	];

}
