<?php

namespace App\Enums;

enum FriendsEnum: string
{
    case Request = 'request';
    case Friends = 'friends';
    case Blocked = 'blocked';
}
