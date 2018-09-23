<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users\UserPost;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{
	public function store($post)
	{
		$post = UserPost::create([
			'post' => $post,
			'user_id' => Auth::user()->id
		]);	
		if($post) {
			return response($this->getPostById($post->id), 200);
		}
		return response('', 200);
	}

	public function getPostById($id)
	{
		$post = UserPost::where('user_has_posts.id', $id)
			->select('user_has_posts.id', 'user_has_posts.post', 'users.first_name', 'users.last_name', 'settings.cover_photo')
			->join('users', 'users.id', '=', 'user_has_posts.user_id')
			->join('settings', 'settings.user_id', '=', 'users.id')
			->first()
			->toJson();
		return $post;
	}

}
