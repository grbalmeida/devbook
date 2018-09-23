<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\FriendshipRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\Relationship;

class AddFriendController extends Controller
{
	public function store($requestedUserId)
	{
		$user = User::find($requestedUserId);
		if($user) {
			FriendshipRequest::insert([
				'requested_user_id' => $requestedUserId,
				'request_user_id' => Auth::user()->id
			]);
			return response('true', 200);
		}
		return response('', 200);
	}   

	public function destroy($requestUserId)
	{
		$relationship = FriendshipRequest::where('request_user_id', $requestUserId)
			->where('requested_user_id', Auth::user()->id)->delete();
		return response($this->getFriendshipRequestedsRemaining($requestUserId), 200);
	}

	public function addFriend($requestUserId)
	{
		$relationship = FriendshipRequest::where('request_user_id', $requestUserId)
			->where('requested_user_id', Auth::user()->id)->delete();
		$requestUserAddFriend = Relationship::insert([
			'user_id' => $requestUserId,
			'friend_id' => Auth::user()->id
		]);
		$requestedUserAddFriend = Relationship::insert([
			'user_id' => Auth::user()->id,
			'friend_id' => $requestUserId
		]);

		return response($this->getFriendshipRequestedsRemaining($requestUserId), 200);
	}

	public function getFriendshipRequestedsRemaining($requestUserId) {
		$friendshipRequesteds = session('friendshipRequesteds');
		foreach($friendshipRequesteds as $id => $friendshipRequested) {
			if($friendshipRequested['id'] == $requestUserId) {
				unset($friendshipRequesteds[$id]);
			}
		}
		return $this->getAnotherFriendshipRequesteds($friendshipRequesteds);
	}

	public function getAnotherFriendshipRequesteds($friendshipRequesteds) {
		$friendshipRequested = [];
		foreach($friendshipRequesteds as $id => $friendship) {
			array_push($friendshipRequested, $friendship['id']);
		}
		$anotherFriendshipRequesteds = FriendshipRequest::whereNotIn('request_user_id', $friendshipRequested)
			->where('requested_user_id', Auth::user()->id)
			->select('users.id', 'users.first_name', 'users.last_name',
					'users.slug', 'settings.cover_photo')
			->join('users', 'users.id', '=', 'friendship_request.request_user_id')
			->join('settings', 'users.id', '=', 'settings.user_id')
			->limit(1)
			->first();
		session()->push('friendshipRequesteds', $anotherFriendshipRequesteds);
		return json_encode($anotherFriendshipRequesteds);
	}

}
