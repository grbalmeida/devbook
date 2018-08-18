<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use GroupPost;
use GroupMember;

class Group extends Model
{
    protected $fillable = [
    	'admin_id',
    	'name',
    	'type',
    	'description',
    	'cover_photo'
    ];

    public function members()
    {
    	return $this->hasMany(GroupMember::class, 'group_id');
    }

    public function posts()
    {
    	return $this->hasMany(GroupPost::class, 'group_id');
    }

}
