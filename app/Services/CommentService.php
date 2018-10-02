<?php

namespace App\Services;

use App\Models\Users\UserPostComment;

class CommentService 
{
	public function getCommentsByPostId() {
        return function($postId) {
            $comments = UserPostComment::where('post_id', $postId)
            ->select('user_posts_has_comments.id', 'user_posts_has_comments.post_id',
            'user_posts_has_comments.user_id', 'user_posts_has_comments.comment',
            'user_posts_has_comments.created_at', 'users.first_name', 'users.last_name',
            'users.slug', 'settings.profile_picture')
            ->join('users', 'users.id', '=', 'user_posts_has_comments.user_id')
            ->join('settings', 'settings.user_id', '=', 'users.id')
            ->whereNull('user_posts_has_comments.parent_id')
            ->limit(2)
            ->get();
            return $comments;
        };
    }
}