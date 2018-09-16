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
            return view('homepage')
                ->with('user', Auth::user())
                ->with('friends', $this->getFriends())
                ->with('groups', $this->getGroups())
                ->with('count', $this->getCountFriendshipRequest())
                ->with('friendshipSuggestions', $this->getFriendhipSuggestions())
                ->with('friendshipRequesteds', $this->getFriendhipRequesteds());
        }
    }

    public function store(UserRegistrationRequest $request) {
    	$request->validated();

        if(!checkdate($request->input('month'), $request->input('day'), $request->input('year'))) {
            return redirect()->route('homepage.index')
                ->with('date_error', 'Informe uma data válida');
        }

        User::insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
            'birthday' => date('Y-m-d', strtotime($request->input('day').'-'.$request->input('month').'-'.$request->input('year'))),
            'slug' => $this->generateSlug($request->input('first_name'), $request->input('last_name'))
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
            ->limit(5)
            ->select('friend_id')
            ->get()
            ->toArray();
        return $friendsId;
    }

    public function getFriends() 
    {
        $friends = User::whereIn('id', $this->getFriendsId())->get();
        return $friends;
    }

    public function getCountFriendshipRequest()
    {
        $count = Auth::user()->friendshipRequesteds()->count();
        return $count;
    }

    public function getFriendhipSuggestions()
    {
        $friendshipSugestions = User::whereNotIn('id', $this->getFriendsId())
            ->where('id', '!=', Auth::user()->id)
            ->whereNotIn('id', $this->getFriendhipRequests())
            ->whereNotIn('id', $this->getIdWhoAskedForRequest())
            ->limit(3)
            ->get();
        return $friendshipSugestions;
    }

    public function getFriendhipRequesteds()
    {
        $friendshipRequesteds = $this->getIdWhoAskedForRequest();
        $friendshipRequesteds = User::whereIn('id', $friendshipRequesteds)->get();
        return $friendshipRequesteds;
    }

    public function getFriendhipRequests()
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
        $groups = Group::whereIn('id', $groupsId)->limit(5)->get();
        return $groups;
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
