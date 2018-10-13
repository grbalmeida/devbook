<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Models\Users\Setting;

class UserService 
{
	public function getUser() {
        $user = Auth::user()
            ->select('first_name', 'last_name', 'slug', 'profile_picture', 'gender', 'birthday')
            ->join('settings', 'users.id', '=', 'settings.user_id')
            ->where('users.id', Auth::user()->id)
            ->first();
        return $user;
    }

    public function getUserVisited($slug)
    {
    	$user = User::where('slug', $slug)
    		->select('id', 'first_name', 'last_name')
    		->first();
    	if($user) {
    		return $user;
    	}
    	return false;
    }

    public function getInformationsAboutUserVisited($user)
    {
        $informations = Setting::where('user_id', $user)
            ->select('hometown', 'actual_city', 'occupation'
            , 'relationship_status', 'company', 'course'
            , 'educational_institution')
            ->first();
        return $informations;
    }

    public function getRelationshipStatusUserVisited()
    { 
        return function($status) {
            $relationshipStatus = [
                '1' => 'Solteiro',
                '2' => 'Em um relacionamento sério',
                '3' => 'Noivo',
                '4' => 'Casado',
                '5' => 'Em uma união estável',
                '6' => 'Morando junto',
                '7' => 'Separado',
                '8' => 'Divorciado',
                '9' => 'Viúvo'
            ];
            return $relationshipStatus[$status];
        };
    }
}