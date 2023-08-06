<?php

namespace App\Models\Groups;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_users extends Model
{
    use HasFactory, Uuids;

    protected $table = "group_users";
    protected $fillable = ["group_id", "user_id", "role", "status", "ban_reason"];
}
