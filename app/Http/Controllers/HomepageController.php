<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegistrationRequest;

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
    	for($counter = intval(date('Y')); $counter > 1900; $counter--) {
    		array_push($years, $counter);
    	}
    	return $years;
    }

}
