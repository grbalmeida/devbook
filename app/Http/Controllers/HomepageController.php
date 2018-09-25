<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\Users\User;
use App\Models\Users\UserPost;
use App\Models\Users\UserPostLike;
use App\Models\Users\Setting;
use App\Models\Users\Permission;
use App\Models\Users\UserPostComment;
use App\Services\DateService;
use App\Services\GroupService;

class HomepageController extends Controller
{

    public function __construct(DateService $dateService, GroupService $groupService)
    {
        $this->dateService = $dateService;
        $this->groupService = $groupService;
    }

    public function index()
    {
        if(Auth::user() == null) {
        	return view('homepage')
        		->with('days', $this->dateService->getDays())
        		->with('months', $this->dateService->getMonths())
        		->with('years', $this->dateService->getYears())
                ->with('user', Auth::user());
        } else {
            session(['friendshipRequesteds' => $this->getFriendshipRequesteds()]);
            session(['friendshipSuggestions' => $this->getFriendshipSuggestions()]);
            return view('homepage')
                ->with('user', $this->getUser())
                ->with('friends', $this->getFriends())
                ->with('groups', $this->groupService->getGroups())
                ->with('count', $this->getCountFriendshipRequest())
                ->with('friendshipSuggestions', $this->getFriendshipSuggestions())
                ->with('friendshipRequesteds', $this->getFriendshipRequesteds())
                ->with('friendsPosts', $this->getFriendsPosts())
                ->with('elapsedTime', $this->dateService->getElapsedTime())
                ->with('comments', $this->getCommentsByPostId())
                ->with('userHasLikedPost', $this->userHasLikedPost());
        }
    }

    public function store(UserRegistrationRequest $request) {
    	$request->validated();

        if(!checkdate($request->input('month'), $request->input('day'), $request->input('year'))) {
            return redirect()->route('homepage.index')
                ->with('date_error', 'Informe uma data válida');
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
            'birthday' => date('Y-m-d', strtotime($request->input('day').'-'.$request->input('month').'-'.$request->input('year'))),
            'slug' => $this->generateSlug($request->input('first_name'), $request->input('last_name'))
        ]);
        $setting = Setting::create([
            'user_id' => $user->id,
        ]);
        $permission = Permission::create([
            'user_id' => $user->id
        ]);
        return $this->auth($request, 'email', 'password');
    }

    public function login(UserLoginRequest $request)
    {
        $request->validated();
        return $this->auth($request, 'email_login', 'password_login');
    }

    public function auth($request, $email, $password)
    {
        $auth = Auth::attempt([
            'email' => $request->input($email),
            'password' => $request->input($password)
        ]);
        return redirect()
            ->route('homepage.index')
            ->with('logged', $auth);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage.index');
    }

    public function getFriendsId()
    {
        $friendsId = Auth::user()
            ->friends()
            ->limit(8)
            ->select('friend_id')
            ->get()
            ->toArray();
        return $friendsId;
    }

    public function getAllFriendsId()
    {
        $friendsId = Auth::user()
            ->friends()
            ->select('friend_id')
            ->get()
            ->toArray();
        return $friendsId;
    }

    public function getFriends() 
    {
        $friends = User::whereIn('users.id', $this->getFriendsId())
            ->select('first_name', 'last_name', 'slug', 'profile_picture')
            ->join('settings', 'settings.user_id', '=', 'users.id')
            ->get();
        return $friends;
    }

    public function getCountFriendshipRequest()
    {
        $count = Auth::user()
            ->friendshipRequesteds()
            ->select('id')
            ->count();
        return $count;
    }

    public function getFriendshipSuggestions($limit = 3)
    {
        $friendshipSuggestions = User::whereNotIn('users.id', $this->getAllFriendsId())
            ->select('first_name', 'last_name', 'slug', 'users.id', 'profile_picture')
            ->where('users.id', '!=', Auth::user()->id)
            ->whereNotIn('users.id', $this->getFriendshipRequests())
            ->whereNotIn('users.id', $this->getIdWhoAskedForRequest())
            ->join('settings', 'users.id', '=','settings.user_id')
            ->limit($limit)
            ->get();
        return $friendshipSuggestions;
    }

    public function getFriendshipRequesteds()
    {
        $friendshipRequesteds = $this->getIdWhoAskedForRequest();
        $friendshipRequesteds = User::whereIn('users.id', $friendshipRequesteds)
            ->select('users.id', 'first_name', 'last_name', 'slug', 'profile_picture')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->limit(3)
            ->get();
        return $friendshipRequesteds;
    }

    public function getFriendshipRequests()
    {
        $friendshipRequests = Auth::user()
            ->friendshipRequests()
            ->select('requested_user_id')
            ->get()
            ->toArray();
        return $friendshipRequests;
    }

    public function getIdWhoAskedForRequest()
    {
        $idWhoAskedForRequest = Auth::user()
            ->friendshipRequesteds()
            ->select('request_user_id')
            ->get()
            ->toArray();
        return $idWhoAskedForRequest;
    }

    public function getFriendsPosts()
    {
        $friendsPosts = UserPost::whereIn('user_has_posts.user_id', $this->getAllFriendsId())
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

    public function getUser() {
        $user = Auth::user()
            ->select('first_name', 'last_name', 'slug', 'profile_picture')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->where('users.id', Auth::user()->id)
            ->first();
        return $user;
    }

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

    public function generateSlug($firstName, $lastName)
    {
        $slug = str_slug($firstName.' '.$lastName);
        $count = User::where('slug', 'like', $slug.'%')->count();
        if($count > 0) 
        {
            $slug.=($count + 1);
        }
        return $slug;
    }

}
