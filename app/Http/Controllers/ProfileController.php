<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\FriendshipService;
use App\Services\FriendService;
use App\Services\PostService;
use App\Services\DateService;
use App\Services\LikeService;
use App\Services\CommentService;
use App\Services\PhotoService;

class ProfileController extends Controller
{
    public function __construct(UserService $userService,
    FriendshipService $friendshipService, FriendService $friendService,
    PostService $postService, DateService $dateService,
    LikeService $likeService, CommentService $commentService,
    PhotoService $photoService) 
    {
    	$this->middleware('login');
    	$this->userService = $userService;
    	$this->friendshipService = $friendshipService;
        $this->friendService = $friendService;
        $this->postService = $postService;
        $this->dateService = $dateService;
        $this->likeService = $likeService;
        $this->commentService = $commentService;
        $this->photoService = $photoService;
    }

    public function index($slug)
    {
        $userExists = $this->userService->getUserVisited($slug);
        if($userExists) {
            return view('profile.index')
            ->with($this->getArrayComponentVariables($userExists));
        }
    	return redirect()->route('homepage.index');
    }

    public function getArrayComponentVariables($user)
    {
    	return [
    		'user' => $this->userService->getUser(),
    		'count' => $this->friendshipService->getCountFriendshipRequest(),
    		'friendshipRequesteds' => $this->friendshipService->getFriendshipRequesteds(),
            'friends' => $this->friendService->getFriendsUserVisited($user->id),
            'userPosts' => $this->postService->getUserPosts($user->id),
            'elapsedTime' => $this->dateService->getElapsedTime(),
            'userHasLikedPost' => $this->likeService->userHasLikedPost(),
            'comments' => $this->commentService->getCommentsByPostId(),
            'photos' => $this->photoService->getPhotosUserVisited($user->id),
            'informations' => $this->userService->getInformationsAboutUserVisited($user->id),
            'getRelationshipStatus' => $this->userService->getRelationshipStatusUserVisited()
    	];
    }
}
