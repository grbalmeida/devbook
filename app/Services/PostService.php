<?php

namespace App\Services;

use App\Models\Users\UserPost;
use App\Services\FriendService;
use Illuminate\Support\Facades\DB;

class PostService 
{

	public function __construct(FriendService $friendService) {
		$this->friendService = $friendService;
	}

    public function getFriendsPosts()
    {
        $friendsPosts = UserPost::whereIn('user_has_posts.user_id', $this->friendService->getAllFriendsId())
            ->select('user_has_posts.id', 'users.first_name', 'users.last_name', 'users.slug', DB::raw('user_has_posts.user_id as user_has_posts_user_id'), 'user_has_posts.post', 'user_has_posts.created_at', 
                DB::raw('COUNT(DISTINCT user_posts_has_likes.id) as count_likes'), 
                DB::raw('COUNT(DISTINCT user_posts_has_comments.id) as count_comments'),
                'settings.profile_picture'
            )
            ->join('users', 'users.id', '=', 'user_has_posts.user_id')
            ->leftJoin('user_posts_has_likes', 'user_posts_has_likes.post_id', 'user_has_posts.id')
            ->leftJoin('user_posts_has_comments', 'user_posts_has_comments.post_id', 'user_has_posts.id')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->orderBy('user_has_posts.created_at', 'desc')
            ->limit(5)
            ->groupBy('user_has_posts.id')
            ->get();

        return $friendsPosts;
    }
}