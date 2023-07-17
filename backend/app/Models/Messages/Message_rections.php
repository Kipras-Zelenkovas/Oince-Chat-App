<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_rections extends Model
{
    use HasFactory;

    protected $table = "message_reactions";
    protected $fillable = ["message_id", "reaction_id"];
}
