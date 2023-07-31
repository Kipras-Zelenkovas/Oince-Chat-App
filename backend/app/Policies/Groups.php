<?php

namespace App\Policies;

use App\Models\Groups\Group;
use App\Models\User;

class Groups
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function isOwner(User $user, Group $group)
    {
        return $user->id === $group->owner;
    }

    public function isDeleted(User $user, Group $group)
    {
        return $group->status === 'deleted';
    }
}
