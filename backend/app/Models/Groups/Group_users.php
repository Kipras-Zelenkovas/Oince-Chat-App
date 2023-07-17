<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_users extends Model
{
    use HasFactory;

    protected $table = "group_users";
    protected $fillable = ["group_id", "user_id", "role_id", "status", "ban_reason"];
}
