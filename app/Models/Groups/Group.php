<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
    	'admin_id',
    	'name',
    	'type',
    	'description',
    	'cover_photo'
    ];

}
