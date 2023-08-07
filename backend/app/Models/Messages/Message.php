<?php

namespace App\Models\Messages;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, Uuids;

    protected $table = "message";
    protected $fillable = ["user_from", "user_to", "text"];
}
