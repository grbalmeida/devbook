<?php

namespace App\Services;

use App\Models\Users\UserPostLike;

class LikeService {
	public function userHasLikedPost()
    {
        return function($userId, $postId) {
            $userLikedPost = UserPostLike::where([
                'user_id' => $userId,
                'post_id' => $postId
            ])->count();
            return $userLikedPost;
        };
    }
}