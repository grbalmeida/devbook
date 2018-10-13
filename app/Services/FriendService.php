<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Models\Users\Relationship;

class FriendService 
{
	public function getFriendsId()
    {
        $friendsId = Auth::user()
            ->friends()
            ->limit(8)
            ->select('friend_id')
            ->get()
            ->toArray();
        return $friendsId;
    }

    public function getAllFriendsId()
    {
        $friendsId = Auth::user()
            ->friends()
            ->select('friend_id')
            ->get()
            ->toArray();
        return $friendsId;
    }

    public function getFriends() 
    {
        $friends = User::whereIn('users.id', $this->getFriendsId())
            ->select('first_name', 'last_name', 'slug', 'profile_picture')
            ->join('settings', 'settings.user_id', '=', 'users.id')
            ->get();
        return $friends;
    }

    public function getFriendsUserVisited($userId)
    {   
        $friends = User::whereIn('users.id', $this->getFriendsIdUserVisited($userId))
            ->select('first_name', 'last_name', 'slug', 'profile_picture')
            ->join('settings', 'settings.user_id', '=', 'users.id')
            ->get();
        return $friends;
    }

    public function getFriendsIdUserVisited($userId)
    {
        $friendsId = Relationship::where('user_id', $userId)
            ->select('friend_id')
            ->limit(8)
            ->get()
            ->toArray();
        return $friendsId;
    }
}