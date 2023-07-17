<?php

namespace App\Policies;

use App\Enums\FriendsEnum;
use App\Models\Friends\Friends as FriendsModel;
use App\Models\User;

class Friends
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isRequested(User $user, $user2)
    {
        $friends = FriendsModel::where('user_1', $user->id)->where('user_2', $user2)->orWhere('user_1', $user2)->where('user_2', $user->id)->get();

        if ($friends->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    public function isAccepted(User $user, $user2)
    {
        $friends = FriendsModel::where('status', FriendsEnum::Friends)->where('user_1', $user->id)->where('user_2', $user2)
            ->orWhere('status', FriendsEnum::Friends)->where('user_1', $user2)->where('user_2', $user->id)->get();

        if ($friends->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }
}
