<?php

namespace App\Enums;

enum GroupsEnum: string
{
    case OPEN = 'open';
    case PRIVATE = 'private';
    case DELETED = 'deleted';
}
