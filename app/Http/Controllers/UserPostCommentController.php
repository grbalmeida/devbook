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
        $response = $this->getLastCommentInserted($postId);
        $response['count'] = $this->getCountCommentsById($postId);
    	return response(json_encode($response), 200);
    }

    public function getLastCommentInserted($postId) {
    	$data = [
    		'user_posts_has_comments.user_id' => Auth::user()->id,
    		'post_id' => $postId
 		];
    	return UserPostComment::where($data)
    		->select('user_posts_has_comments.id', 'user_posts_has_comments.comment', 
    				'users.id', 'users.slug', 'users.first_name', 
                    'users.last_name', 'settings.profile_picture')
    		->join('users', 'user_posts_has_comments.user_id', '=', 'users.id')
            ->join('settings', 'settings.user_id', '=', 'users.id')
    		->orderBy('user_posts_has_comments.created_at', 'desc')
    		->first()
    		->toArray();
    }

    public function getCountCommentsById($postId) {
        return UserPostComment::where('post_id', $postId)
            ->count();
    }

}
