<?php

namespace App\Services;

use App\Models\Users\Permission;
use Illuminate\Support\Facades\Auth;

class SettingService 
{
	public function getPermissionsList()
	{
		return [
			'1' => 'Público',
			'2' => 'Amigos',
			'3' => 'Amigos de amigos'
		];
	}

	public function getWhoCanRequestFriendship()
	{
		return [
			'0' => 'Público',
			'1' => 'Amigos de amigos'
		];
	}

	public function getPrivacyOptions()
	{
		return Permission::where('user_id', Auth::user()->id)
			->select('friendship_request', 'friends_list', 'posts')
			->first();
	}
}