<?php

namespace App\Enums;

enum GroupUsersEnum: string
{
    case REQUEST = 'request';
    case MEMBER = 'member';
    case BANNED = 'banned';
}
