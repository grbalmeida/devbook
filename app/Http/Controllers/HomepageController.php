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
use App\Services\FriendService;
use App\Services\FriendshipService;
use App\Services\UserService;
use App\Services\CommentService;

class HomepageController extends Controller
{

    public function __construct(DateService $dateService, GroupService $groupService, 
        FriendService $friendService, FriendshipService $friendshipService, 
        UserService $userService, CommentService $commentService)
    {
        $this->dateService = $dateService;
        $this->groupService = $groupService;
        $this->friendService = $friendService;
        $this->friendshipService = $friendshipService;
        $this->userService = $userService;
        $this->commentService = $commentService;
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
            session(['friendshipRequesteds' => $this->friendshipService->getFriendshipRequesteds()]);
            session(['friendshipSuggestions' => $this->friendshipService->getFriendshipSuggestions()]);
            return view('homepage')
                ->with('user', $this->userService->getUser())
                ->with('friends', $this->friendService->getFriends())
                ->with('groups', $this->groupService->getGroups())
                ->with('count', $this->friendshipService->getCountFriendshipRequest())
                ->with('friendshipSuggestions', $this->friendshipService->getFriendshipSuggestions())
                ->with('friendshipRequesteds', $this->friendshipService->getFriendshipRequesteds())
                ->with('friendsPosts', $this->getFriendsPosts())
                ->with('elapsedTime', $this->dateService->getElapsedTime())
                ->with('comments', $this->commentService->getCommentsByPostId())
                ->with('userHasLikedPost', $this->userHasLikedPost());
        }
    }

    public function store(UserRegistrationRequest $request) {
    	$request->validated();

        if(!$this->dateService->isValidDate($request->input('month'), $request->input('day'), $request->input('year'))) {
            return redirect()->route('homepage.index')
                ->with('date_error', 'Informe uma data válida');
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
            'birthday' => $this->dateService->formatDate($request->input('day'), $request->input('month'), $request->input('year')),
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
