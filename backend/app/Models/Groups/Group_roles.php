<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_roles extends Model
{
    use HasFactory;

    protected $table = "group_roles";
    protected $fillable = ["group_id", "name"];
}
