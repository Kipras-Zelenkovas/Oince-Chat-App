<?php

namespace App\Models\Friends;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    protected $table = "friends";
    protected $fillable = ["user_1", "user_2", "status"];
}
