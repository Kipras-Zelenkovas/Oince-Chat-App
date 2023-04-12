<?php

namespace App\Enums;

enum RolesEnum: string
{
    case User       = 'default';
    case Premium    = 'premium';
    case Admin      = 'admin';
}
