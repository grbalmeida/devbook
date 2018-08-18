<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPostPhoto extends Model
{
    
	protected $table = 'group_posts_has_photos';

	protected $fillable = [
		'post_id',
		'image'
	];

}
