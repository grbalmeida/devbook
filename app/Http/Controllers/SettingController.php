<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FriendshipService;
use App\Services\UserService;
use App\Services\DateService;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\SettingService;
use App\Http\Requests\PrivacyRequest;
use App\Models\Users\Permission;

class SettingController extends Controller
{
	public function __construct(FriendshipService $friendshipService,
		UserService $userService, DateService $dateService,
        SettingService $settingService)
	{
    	$this->middleware('login');
    	$this->friendshipService = $friendshipService;
    	$this->userService = $userService;
        $this->dateService = $dateService;
	    $this->settingService = $settingService;           
    }

    public function index()
    {
        return view('settings.index')
            ->with($this->getArrayComponentVariables())
            ->with('days', $this->dateService->getDays())
            ->with('months', $this->dateService->getMonths())
            ->with('years', $this->dateService->getYears());
    }

    public function updatePersonalInformation(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required'
        ]);
        if(!$this->dateService->isValidDate($request->input('month'), $request->input('day'), $request->input('year'))) {
            return redirect()->route('settings.index')
                ->with('date_error', 'Informe uma data válida');
        }
        $userData = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birthday' => $request->input('year').'-'.$request->input('month').'-'.$request->input('day'),
            'gender' => $request->input('gender')[0]
        ];
        User::find(Auth::user()->id)->update($userData);
        return redirect()->route('settings.index')
            ->with('success', 'Informações pessoais alteradas com sucesso');
    }

    public function password()
    {
        return view('settings.password')
            ->with($this->getArrayComponentVariables());
    }

    public function updatePassword(PasswordRequest $request)
    {
        $request->validated();
        $userPassword = Hash::check($request->input('current'), Auth::user()->password);
        if($userPassword) {
            User::where('id', Auth::user()->id)
                ->update([
                    'password' => bcrypt($request->input('password'))
                ]);
            return redirect()->route('settings.password')
                ->with('success', 'Senha alterada com sucesso');
        }
        return redirect()->route('settings.password')
            ->with('error', 'Senha incorreta');
    }

    public function privacy()
    {
        return view('settings.privacy')
            ->with($this->getArrayComponentVariables())
            ->with('permissionsList', $this->settingService->getPermissionsList())
            ->with('requestList', $this->settingService->getWhoCanRequestFriendship())
            ->with('privacyOptions', $this->settingService->getPrivacyOptions());
    }

    public function updatePrivacy(PrivacyRequest $request)
    {
        $request->validated();
        Permission::where('user_id', Auth::user()->id)
            ->update([
                'friends_list' => $request->input('friends_list'),
                'friendship_request' => $request->input('friendship_request'),
                'posts' => $request->input('posts')
            ]);
        return redirect()->route('settings.privacy')
            ->with('success', 'Opções de privacidade alteradas com sucesso');
    }

    public function getArrayComponentVariables()
    {
    	return [
    		'user' => $this->userService->getUser(),
    		'count' => $this->friendshipService->getCountFriendshipRequest(),
    		'friendshipRequesteds' => $this->friendshipService->getFriendshipRequesteds()
    	];
    }
}
