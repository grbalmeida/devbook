<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = 'group_has_members';

    protected $fillable = [
    	'user_id',
    	'group_id'
    ];

}
