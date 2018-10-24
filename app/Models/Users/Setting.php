<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

	public $timestamps = false;

    protected $fillable = [
    	'user_id',
    	'profile_picture',
    	'cover_photo',
    	'biography',
    	'hometown',
    	'actual_city',
    	'occupation',
        'relationship_status',
        'company',
        'course',
        'educational_institution'	
    ];
}
