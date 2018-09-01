<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\Users\User;

class HomepageController extends Controller
{
    public function index()
    {
    	return view('homepage')
    		->with('days', $this->getDays())
    		->with('months', $this->getMonths())
    		->with('years', $this->getYears());
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
    }

    public function login(UserLoginRequest $request)
    {
        $request->validated();
        Auth::attempt([
            'email' => $request->input('email_login'),
            'password' => $request->input('password_login')
        ]);
        return redirect()->route('homepage.index');
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
