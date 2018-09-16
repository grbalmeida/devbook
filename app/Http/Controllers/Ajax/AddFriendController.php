<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\FriendshipRequest;
use Illuminate\Support\Facades\Auth;

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
}
