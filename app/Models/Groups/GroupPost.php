<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use GroupPostPhoto;
use GroupPostComment;
use GroupPostLike;

class GroupPost extends Model
{
    protected $table = 'group_has_posts';

    protected $fillable = [
    	'user_id',
    	'group_id',
    	'post'
    ];

    public function photos()
    {
    	return $this->hasMany(GroupPostPhoto::class, 'post_id');
    }

    public function comments()
    {
    	return $this->hasMany(GroupPostComment::class, 'post_id');
    }

    public function likes()
    {
    	return $this->hasMany(GroupPostLike::class, 'post_id');
    }

}
