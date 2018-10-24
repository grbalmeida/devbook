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
use App\Models\Users\Setting;
use Illuminate\Support\Facades\Auth;

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
        $retorno = $this->ifUserExistsReturnView($slug);
        if(!$retorno) {
            return redirect()->route('homepage.index');
        }
        return view('profile.index')
            ->with($this->getArrayComponentVariables($slug, $retorno));
    }

    public function getAbout($slug)
    {
        $retorno = $this->ifUserExistsReturnView($slug);
        if(!$retorno) {
            return redirect()->route('homepage.index');
        }
        return view('profile.about')
            ->with($this->getArrayComponentVariables($slug, $retorno));
    }

    public function getFriends($slug)
    {
        $retorno = $this->ifUserExistsReturnView($slug);
        if(!$retorno) {
            return redirect()->route('homepage.index');
        }
        return view('profile.friends')
            ->with($this->getArrayComponentVariables($slug, $retorno));
    }

    public function getPhotos($slug)
    {
        $retorno = $this->ifUserExistsReturnView($slug);
        if(!$retorno) {
            return redirect()->route('homepage.index');
        }
        return view('profile.photos')
            ->with($this->getArrayComponentVariables($slug, $retorno));
    }

    public function ifUserExistsReturnView($slug)
    {
        $userExists = $this->userService->getUserVisited($slug);
        if($userExists) {
            return $userExists;
        }
        return false;
    }

    public function getArrayComponentVariables($slug, $user)
    {
    	return [
            'slug' => $slug,
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
            'getRelationshipStatusUserVisited' => $this->userService->getRelationshipStatusUserVisited(),
            'getRelationshipStatus' => $this->userService->getRelationshipStatus()
    	];
    }

    public function changeBiography(Request $request)
    {
        Auth::user()->settings->update([
            'biography' => $request->input('biography')
        ]);
        return redirect()->route('profile.about', Auth::user()->slug)
            ->with('active', 'biography');
    }

    public function changeRelationshipStatus(Request $request)
    {
        Auth::user()->settings->update([
            'relationship_status' => $request->input('relationship_status')
        ]);
        return redirect()->route('profile.about', Auth::user()->slug)
            ->with('active', 'relationship');
    }

    public function changeCities(Request $request)
    {
        Auth::user()->settings->update([
            'actual_city' => $request->input('actual_city'),
            'hometown' => $request->input('hometown')
        ]);
        return redirect()->route('profile.about', Auth::user()->slug)
            ->with('active', 'relationship');
    }

    public function changeWorkAndEducation(Request $request)
    {
        Auth::user()->settings->update([
            'occupation' => $request->input('occupation'),
            'company' => $request->input('company'),
            'course'=> $request->input('course'),
            'educational_institution' => $request->input('educational_institution')
        ]);
        return redirect()->route('profile.about', Auth::user()->slug)
            ->with('active', 'work-education');
    }    
}
