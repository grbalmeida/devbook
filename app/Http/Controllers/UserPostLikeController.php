<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users\UserPostLike;
use Illuminate\Support\Facades\Auth;

class UserPostLikeController extends Controller
{
    public function addRemoveLike($postId)
    {
    	$count = UserPostLike::where([
    		'post_id' => $postId,
    		'user_id' => Auth::user()->id
    	])->count();

    	if($count == 1) {
    		$this->destroy($postId);
    	} else {
    		$this->store($postId);
    	}

    	$response = [
    		'count' => $count,
    		'countAllLikes' => $this->getCountLikesById($postId)
    	];

    	return response(json_encode($response), 200);
    }

    public function store($postId)
    {
    	return UserPostLike::insert([
    		'post_id' => $postId,
    		'user_id' => Auth::user()->id
    	]);
    }

    public function destroy($postId)
    {
    	return UserPostLike::where([
    		'post_id' => $postId,
    		'user_id' => Auth::user()->id
    	])->delete();
    }

    public function getCountLikesById($postId)
    {
    	return UserPostLike::where('post_id', $postId)
    		->count();
    }

}
