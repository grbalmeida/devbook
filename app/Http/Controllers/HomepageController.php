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
    	return view('homepage')
    		->with('days', $this->getDays())
    		->with('months', $this->getMonths())
    		->with('years', $this->getYears())
            ->with('user', Auth::user())
            ->with('friends', $this->getFriends())
            ->with('groups', $this->getGroups());
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

    public function getFriends()
    {
        $friendsId = Auth::user()
            ->friends()
            ->limit(5)
            ->select('friend_id')
            ->get()
            ->toArray();
        $friends = User::whereIn('id', $friendsId)->get();
        return $friends;
    }

    public function getGroups()
    {
        $groupsId = GroupMember::where('user_id', Auth::user()->id)
            ->select('group_id')
            ->limit(5)
            ->get()
            ->toArray();
        $groups = Group::whereIn('id', $groupsId)->get();
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
