<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users\UserPostComment;
use Illuminate\Support\Facades\Auth;

class UserPostCommentController extends Controller
{
    public function store($postId, $comment) {
    	$comment = UserPostComment::create([
    		'post_id' => $postId,
    		'user_id' => Auth::user()->id,
    		'comment' => $comment
    	]);
    	return response($this->getLastCommentInserted($postId), 200);
    }

    public function getLastCommentInserted($postId) {
    	$data = [
    		'user_id' => Auth::user()->id,
    		'post_id' => $postId
 		];
    	return UserPostComment::where($data)
    		->select('user_posts_has_comments.id', 'user_posts_has_comments.comment', 
    				'users.id', 'users.slug',
    				'users.first_name', 'users.last_name')
    		->join('users', 'user_posts_has_comments.user_id', '=', 'users.id')
    		->orderBy('user_posts_has_comments.created_at', 'desc')
    		->first()
    		->toJson();
    }

}
