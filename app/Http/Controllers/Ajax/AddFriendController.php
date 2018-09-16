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
		if($relationship) {
			return response('true', 200);
		}
		return response('', 200);
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
		if($relationship && $requestUserAddFriend && $requestedUserAddFriend) {
			return response('true', 200);
		}
		return response('', 200);
	}

}
