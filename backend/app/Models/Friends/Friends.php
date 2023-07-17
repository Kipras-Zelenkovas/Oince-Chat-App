<?php

namespace App\Models\Friends;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory, Uuids;

    protected $table = "friends";
    protected $fillable = ["user_1", "user_2", "status"];
}
