<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Services\FriendService;

class FriendshipService 
{

    public function __construct(FriendService $friendService) {
        $this->friendService = $friendService;
    }

	public function getIdWhoAskedForRequest()
    {
        $idWhoAskedForRequest = Auth::user()
            ->friendshipRequesteds()
            ->select('request_user_id')
            ->get()
            ->toArray();
        return $idWhoAskedForRequest;
    }

    public function getFriendshipRequests()
    {
        $friendshipRequests = Auth::user()
            ->friendshipRequests()
            ->select('requested_user_id')
            ->get()
            ->toArray();
        return $friendshipRequests;
    }

    public function getFriendshipSuggestions($limit = 3)
    {
        $friendshipSuggestions = User::whereNotIn('users.id', $this->friendService->getAllFriendsId())
            ->select('first_name', 'last_name', 'slug', 'users.id', 'profile_picture')
            ->where('users.id', '!=', Auth::user()->id)
            ->whereNotIn('users.id', $this->getFriendshipRequests())
            ->whereNotIn('users.id', $this->getIdWhoAskedForRequest())
            ->join('settings', 'users.id', '=','settings.user_id')
            ->limit($limit)
            ->get();
        return $friendshipSuggestions;
    }

    public function getFriendshipRequesteds()
    {
        $friendshipRequesteds = $this->getIdWhoAskedForRequest();
        $friendshipRequesteds = User::whereIn('users.id', $friendshipRequesteds)
            ->select('users.id', 'first_name', 'last_name', 'slug', 'profile_picture')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->limit(3)
            ->get();
        return $friendshipRequesteds;
    }

    public function getCountFriendshipRequest()
    {
        $count = Auth::user()
            ->friendshipRequesteds()
            ->select('id')
            ->count();
        return $count;
    }
}