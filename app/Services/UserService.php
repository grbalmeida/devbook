<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserService 
{
	public function getUser() {
        $user = Auth::user()
            ->select('first_name', 'last_name', 'slug', 'profile_picture', 'gender', 'birthday')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->where('users.id', Auth::user()->id)
            ->first();
        return $user;
    }
}