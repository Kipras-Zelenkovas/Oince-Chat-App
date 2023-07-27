<?php

namespace App\Http\Controllers\Friends;

use App\Http\Controllers\Controller;
use App\Models\Friends\Friends as FriendsModel;
use Illuminate\Http\Request;
use App\Enums\FriendsEnum;
use Illuminate\Support\Facades\Gate;

class Friends extends Controller
{

    public function friend_list(Request $request)
    {
        try {
            $user = $request->user();

            $friends_list = FriendsModel::where('status', FriendsEnum::Friends)->where('user_1', $user->id)
                ->orWhere('status', FriendsEnum::Friends)->where('user_2', $user->id)->get();

            return response()->json($friends_list);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function friend_requests(Request $request)
    {
        try {
            $user = $request->user();

            $friends_requests = FriendsModel::where('status', FriendsEnum::Request)->where('user_1', $user->id)
                ->orWhere('status', FriendsEnum::Request)->where('user_2', $user->id)->get();

            return response()->json($friends_requests);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function blocked_list(Request $request)
    {
        try {
            $user = $request->user();

            $blocked_list = FriendsModel::where('status', FriendsEnum::Blocked)->where('user_banned', $user->id)->get();

            return response()->json($blocked_list);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function send_request(Request $request)
    {
        try {
            if (Gate::allows('isRequested', [$request->user_to])) {
                $user = $request->user();

                $friend_req = FriendsModel::create([
                    'user_1'    => $user->id,
                    'user_2'    => $request->user_to,
                    'status'    => FriendsEnum::Request
                ]);

                $friend_req->save();

                return response()->json([
                    'status'    => true,
                    'message'   => 'Friends request sent'
                ], 200);
            } else {
                return response()->json("Friend request is already sent or you are already friends");
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function accept_request(Request $request)
    {
        try {
            if (Gate::allows('isAccepted', [$request->user_to])) {
                $user = $request->user();

                $friend_accept = FriendsModel::where('status', FriendsEnum::Request)->where('user_1', $user->id)
                    ->where('user_2', $request->user_to)->orWhere('status', FriendsEnum::Request)->where('user_1', $request->user_to)
                    ->where('user_2', $user->id)->first();

                $friend_accept->status = FriendsEnum::Friends;

                $friend_accept->save();

                return response()->json([
                    'status'    => true,
                    'message'   => 'Friends request accepted'
                ], 200);
            } else {
                return response()->json("You are already friends");
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function block(Request $request)
    {
        try {
            if (Gate::allows('isBlocked', [$request->user_to])) {
                $user = $request->user();

                $friend_block = FriendsModel::where('status', FriendsEnum::Friends)->where('user_1', $user->id)
                    ->where('user_2', $request->user_to)->orWhere('status', FriendsEnum::Friends)->where('user_1', $request->user_to)
                    ->where('user_2', $user->id)->first();

                $friend_block->status = FriendsEnum::Blocked;
                $friend_block->user_banned = $user->id;

                $friend_block->save();

                return response()->json([
                    'stauts'    => true,
                    'message'   => 'User successfuly blocked'
                ], 200);
            } else {
                return response()->json("You already blocked user");
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function cancle_request(Request $request)
    {
        try {
            $user = $request->user();

            $cancle_request = FriendsModel::where('status', FriendsEnum::Request)->where('user_1', $user->id)->where('user_2', $request->user_2)
                ->orWhere('status', FriendsEnum::Request)->where('user_1', $request->user_2)->where('user_2', $user->id)->first();

            $cancle_request->delete();

            return response()->json([
                'status'    => true,
                'message'   => 'Request successfully deleted'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function cancle_friendship(Request $request)
    {
        try {
            $user = $request->user();

            $cancle_friendship = FriendsModel::where('status', FriendsEnum::Friends)->where('user_1', $user->id)->where('user_2', $request->user_2)
                ->orWhere('status', FriendsEnum::Friends)->where('user_1', $request->user_2)->where('user_2', $user->id)->first();

            $cancle_friendship->delete();

            return response()->json([
                'status'    => true,
                'message'   => 'Friendship successfully deleted'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong");
        }
    }

    public function unblock(Request $request)
    {
        try {
            $user = $request->user();

            $unblock_user = FriendsModel::where('status', FriendsEnum::Blocked)->where('user_1', $user->id)->where('user_2', $request->user_2)
                ->where('user_banned', $user->id)->orWhere('status', FriendsEnum::Blocked)->where('user_1', $request->user_2)->where('user_2', $user->id)
                ->where('user_banned', $user->id)->first();

            $unblock_user->status = FriendsEnum::Friends;
            $unblock_user->user_banned = "";

            $unblock_user->save();

            return response()->json([
                'status'    => true,
                'message'   => 'User successfuly unblocked'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }




    public function test(Request $request)
    {
        if (Gate::allows('isAccepted', [$request->to])) {
            return response("ne");
        } else {
            return response("jau");
        }
    }
}
