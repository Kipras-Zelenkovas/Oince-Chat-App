<?php

namespace App\Http\Controllers\Group;

use App\Enums\GroupRoles;
use App\Enums\GroupUsersEnum;
use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use App\Models\Groups\Group_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Join extends Controller
{

    public function join(Request $request)
    {
        try {
            $user = $request->user();
            $group = Group::find($request->group_id);

            if (!Gate::allows('userInGroup', [$group])) {
                if (Gate::allows('groupOpen', [$group])) {
                    $member = Group_users::create([
                        'group_id'  => $request->group_id,
                        'user_id'   => $user->id,
                        'role'   => GroupRoles::Member,
                        'status'    => GroupUsersEnum::MEMBER,
                    ]);

                    $member->save();

                    return response()->json([
                        'status'    => true,
                        'message'   => 'You successfully join a group'
                    ], 201);
                } elseif (Gate::allows('groupPrivate', [$group])) {
                    $requester = Group_users::create([
                        'group_id'  => $request->group_id,
                        'user_id'   => $user->id,
                        'role'   => GroupRoles::Member,
                        'status'    => GroupUsersEnum::REQUEST,
                    ]);

                    $requester->save();

                    return response()->json([
                        'status'    => true,
                        'message'   => 'You successfully sent request to join a group'
                    ], 201);
                } else {
                    return response()->json([
                        'status'    => true,
                        'message'   => 'Group joining is temporary disabled'
                    ], 403);
                }
            } else {
                return response()->json("You can't send request to group");
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function accept(Request $request)
    {
        try {
            $user = $request->user();
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group])) {
                Group_users::where('group_id', $group->id)->where('user_id', $request->user_id)->update(['status' => GroupUsersEnum::MEMBER]);

                return response()->json([
                    'status'    => true,
                    'message'   => 'New group member successfully added'
                ], 200);
            } else {
                return response()->json('You don\'t have permission to add new member', 401);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
