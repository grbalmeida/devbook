<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\Users\User;
use App\Models\Groups\GroupMember;
use App\Models\Groups\Group;
use App\Models\Users\UserPost;
use App\Models\Users\UserPostLike;
use App\Models\Users\Setting;
use App\Models\Users\Permission;

class HomepageController extends Controller
{
    public function index()
    {
        if(Auth::user() == null) {
        	return view('homepage')
        		->with('days', $this->getDays())
        		->with('months', $this->getMonths())
        		->with('years', $this->getYears())
                ->with('user', Auth::user());
        } else {
            session(['friendshipRequesteds' => $this->getFriendshipRequesteds()]);
            session(['friendshipSuggestions' => $this->getFriendshipSuggestions()]);
            return view('homepage')
                ->with('user', $this->getUser())
                ->with('friends', $this->getFriends())
                ->with('groups', $this->getGroups())
                ->with('count', $this->getCountFriendshipRequest())
                ->with('friendshipSuggestions', $this->getFriendshipSuggestions())
                ->with('friendshipRequesteds', $this->getFriendshipRequesteds())
                ->with('friendsPosts', $this->getFriendsPosts())
                ->with('elapsedTime', $this->getElapsedTime())
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
            ->select('first_name', 'last_name', 'slug', 'cover_photo')
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
            ->select('first_name', 'last_name', 'slug', 'users.id', 'cover_photo')
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
            ->select('users.id', 'first_name', 'last_name', 'slug', 'cover_photo')
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

    public function getGroups()
    {
        $groupsId = GroupMember::where('user_id', Auth::user()->id)
            ->select('group_id')
            ->limit(5)
            ->get()
            ->toArray();
        $groups = Group::whereIn('id', $groupsId)
            ->select('id', 'name', 'cover_photo')
            ->limit(5)
            ->get();
        return $groups;
    }

    public function getFriendsPosts()
    {
        $friendsPosts = UserPost::whereIn('user_has_posts.user_id', $this->getAllFriendsId())
            ->select('user_has_posts.id', 'users.first_name', 'users.last_name', 'users.slug', DB::raw('user_has_posts.user_id as user_has_posts_user_id'), 'user_has_posts.post', 'user_has_posts.created_at', 
                DB::raw('COUNT(DISTINCT user_posts_has_likes.id) as count_likes'), 
                DB::raw('COUNT(DISTINCT user_posts_has_comments.id) as count_comments'),
                'settings.cover_photo'
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
            ->select('first_name', 'last_name', 'slug', 'cover_photo')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->where('users.id', Auth::user()->id)
            ->first();
        return $user;
    }

    public function getDays() 
    {
    	$days = [];
    	for($counter = 1; $counter <= 31; $counter++) 
    	{
    		array_push($days, $counter);
    	}
    	return $days;
    }

    public static function getElapsedTime() 
    {
        return function($time) {
            $now = strtotime(date('m/d/Y H:i:s'));
            $time = strtotime($time);
            $diff = $now - $time;

            $seconds = $diff;
            $minutes = round($diff / 60);
            $hours = round($diff / 3600);
            $days = round($diff / 86400);
            $months = round($diff / 2419200);
            $years = round($diff / 29030400);

            if ($seconds <= 60) return '1 min atrás';
            else if ($minutes <= 60) return $minutes==1 ?'1 min atrás':$minutes.' min atrás';
            else if ($hours <= 24) return $hours==1 ?'1 hrs atrás':$hours.' hrs atrás';
            else if ($days <= 7) return $days==1 ?'1 dia atras':$days.' dias atrás';
            else if ($months <= 12) return $months == 1 ?'1 mês atrás':$months.' meses atrás';
            else return $years == 1 ? 'um ano atrás':$years.' anos atrás';
        };
    }

    public function getMonths()
    {
    	$months = [
    		'Jan', 'Fev', 'Mar',
    		'Abr', 'Maio', 'Jun',
    		'Jul', 'Ago', 'Set',
 			'Out', 'Nov', 'Dez'
    	];
    	return $months;
    }

    public function getYears()
    {
    	$years = [];
    	for($counter = intval(date('Y')); $counter > 1900; $counter--) 
        {
    		array_push($years, $counter);
    	}
    	return $years;
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
