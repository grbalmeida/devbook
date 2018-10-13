<?php

namespace App\Services;

use App\Models\Users\UserPostPhoto;
use App\Models\Users\UserPost;

class PhotoService
{
	public function getPhotosUserVisited($userId)
	{
		$photos = UserPostPhoto::whereIn('post_id', $this->getPostsByUserId($userId))
			->select('image')
			->get();
		return $photos;
	}

	public function getPostsByUserId($userId)
	{
		$postsId = UserPost::where('user_id', $userId)
			->select('id')
			->limit(8)
			->get()
			->toArray();
		return $postsId;
	}
}