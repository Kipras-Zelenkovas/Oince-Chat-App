<?php

namespace App\Http\Controllers\Group;

use App\Enums\GroupRoles;
use App\Enums\GroupUsersEnum;
use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use App\Models\Groups\Group_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Users extends Controller
{

    public function members(Request $request)
    {
        try {
            $members = Group_users::where('group_id', $request->group_id)->where('status', GroupUsersEnum::MEMBER)->get();

            return response()->json([
                'status'    => true,
                'message'   => "Group members successfully retrieved",
                'data'      => $members
            ], 200);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }

    public function requesters(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) || Gate::allows('groupAdmin', [$group])) {
                $requesters = Group_users::where('group_id', $group->id)->where('status', GroupUsersEnum::REQUEST)->get();

                return response()->json([
                    'status'    => true,
                    'message'   => "Group requesters successfully retrieved",
                    'data'      => $requesters
                ], 200);
            } else {
                return response()->json("You don't have permission for this action", 401);
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }

    public function banned(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) || Gate::allows('groupAdmin', [$group])) {
                $banned = Group_users::where('group_id', $group->id)->where('status', GroupUsersEnum::BANNED)->get();

                return response()->json([
                    'status'    => true,
                    'message'   => "Groups banned users successfully retrieved",
                    'data'      => $banned
                ], 200);
            } else {
                return response()->json("You don't have permission for this action", 401);
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }

    public function ban(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) || Gate::allows('groupAdmin', [$group])) {
                Group_users::where('group_id', $group->id)->where('user_id', $request->user_id)->update(['status' => GroupUsersEnum::BANNED]);

                return response()->json([
                    'status'    => true,
                    'message'   => "Group member is successfully banned"
                ], 201);
            } else {
                return response()->json("You don't have permission for this action", 401);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function unban(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) || Gate::allows('groupAdmin', [$group])) {
                Group_users::where('group_id', $group->id)->where('user_id', $request->user_id)->update(['status' => GroupUsersEnum::MEMBER]);

                return response()->json([
                    'status'    => true,
                    'message'   => "Group member is successfully unbanned"
                ], 201);
            } else {
                return response()->json("You don't have permission for this action", 401);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function makeAdmin(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) || Gate::allows('groupAdmin', [$group])) {
                Group_users::where('group_id', $group->id)->where('user_id', $request->user_id)->update(['role' => GroupRoles::Admin]);

                return response()->json([
                    'status'    => true,
                    'message'   => "Group member is successfully promoted to admin"
                ], 201);
            } else {
                return response()->json("You don't have permission for this action", 402);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function makeMember(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) || Gate::allows('groupAdmin', [$group])) {
                Group_users::where('group_id', $group->id)->where('user_id', $request->user_id)->update(['role' => GroupRoles::Member]);

                return response()->json([
                    'status'    => true,
                    'message'   => "Group member is successfully demoted to member"
                ], 201);
            } else {
                return response()->json("You don't have permission for this action", 402);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
