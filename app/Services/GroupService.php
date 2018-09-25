<?php

namespace App\Services;

use App\Models\Groups\Group;
use App\Models\Groups\GroupMember;
use Illuminate\Support\Facades\Auth;

class GroupService {
	public function getGroups()
    {
        $groupsId = GroupMember::where('user_id', Auth::user()->id)
            ->select('group_id')
            ->limit(5)
            ->get()
            ->toArray();
        $groups = Group::whereIn('id', $groupsId)
            ->select('id', 'name')
            ->limit(5)
            ->get();
        return $groups;
    }
}