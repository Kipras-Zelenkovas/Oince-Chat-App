<?php

namespace App\Http\Controllers\Group;

use App\Enums\GroupRoles;
use App\Enums\GroupUsersEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\Create_Update;
use App\Models\Groups\Group;
use App\Models\Groups\Group_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CRUD extends Controller
{

    public function create(Create_Update $request)
    {
        try {
            $user = $request->user();
            $request->validated();

            $newGroup = Group::create([
                'owner'     => $user->id,
                'name'      => $request->name,
                'image'     => $request->img ? $request->img : null,
                'status'    => $request->status,
                'tags'      => $request->tags
            ]);

            $newGroup->save();

            $owner = Group_users::create([
                'group_id'      => $newGroup->id,
                'user_id'       => $user->id,
                'role'          => GroupRoles::Admin,
                'status'        => GroupUsersEnum::MEMBER,
            ]);

            $owner->save();

            return response()->json([
                'status'    => true,
                'message'   => 'You successfully created a group'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function update(Create_Update $request)
    {
        try {
            $validated = $request->safe()->except('id');
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group]) && !Gate::allows('groupDeleted', [$group])) {
                Group::where('id', $request->group_id)->update($validated);

                return response()->json([
                    'status'    => true,
                    'message'   => 'Groups parameters are successfully updated'
                ], 201);
            } else {
                return response()->json('This function is not available for you', 401);
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $group = Group::find($request->group_id);

            if (Gate::allows('groupOwner', [$group])) {
                Group::where('id', $request->group_id)->update(['status' => 'deleted']);

                return response()->json([
                    'status'    => true,
                    'message'   => 'Group is successfully deleted'
                ], 201);
            } else {
                return response()->json('This function is not available for you', 401);
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }
}
