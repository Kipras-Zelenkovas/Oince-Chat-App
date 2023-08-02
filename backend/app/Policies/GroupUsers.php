<?php

namespace App\Policies;

use App\Models\Groups\Group;
use App\Models\Groups\Group_users;
use App\Models\User;

class GroupUsers
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function inGroup(User $user, Group $group)
    {
        $inGroup = Group_users::where('user_id', $user->id)->where('group_id', $group->id)->first();

        if ($inGroup !== null) {
            return true;
        } else {
            return false;
        }
    }
}
