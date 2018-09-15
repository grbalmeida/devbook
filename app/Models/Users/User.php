<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Groups\GroupMember;
use Permission;
use Setting;
use App\Models\Users\FriendshipRequest;
use App\Models\Users\Relationship;
use UserPost;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'birthday',
        'gender',
        'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permissions()
    {
        return $this->hasOne(Permission::class, 'user_id');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class, 'user_id');
    }

    public function friendshipRequests()
    {
        return $this->hasMany(FriendshipRequest::class, 'requested_user_id');
    }

    public function friends()
    {
        return $this->hasMany(Relationship::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(UserPost::class, 'user_id');
    }

    public function groups()
    {
        return $this->belongsToMany(GroupMember::class);
    }

}
