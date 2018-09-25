<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;

class FriendService {
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
}