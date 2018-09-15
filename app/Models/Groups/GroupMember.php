<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class GroupMember extends Model
{
    protected $table = 'group_has_members';

    protected $fillable = [
    	'user_id',
    	'group_id'
    ];

    public function users()
    {
    	return $this->hasMany(User::class);
    }

}
