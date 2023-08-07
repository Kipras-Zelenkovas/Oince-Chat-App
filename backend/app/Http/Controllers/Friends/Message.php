<?php

namespace App\Http\Controllers\Friends;

use App\Events\FriendMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Message extends Controller
{

    public function message(Request $request)
    {
        try {
            event(new FriendMessage($request->user(), $request->message, $request->to));

            return response([
                'data'  => [
                    $request->message,
                    $request->to
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
