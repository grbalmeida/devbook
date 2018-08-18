<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    	'profile_picture',
    	'cover_photo',
    	'biography',
    	'hometown',
    	'actual_city',
    	'occupation'	
    ];
}
