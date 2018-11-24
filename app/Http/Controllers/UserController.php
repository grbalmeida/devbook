<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

    public function getUsersByName($name) 
    {
    	return $this->userService->getUsersByName($name);
    }
}
