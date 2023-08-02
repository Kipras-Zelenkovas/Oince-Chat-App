<?php

namespace App\Http\Controllers\Group;

use App\Enums\GroupsEnum;
use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use Illuminate\Http\Request;

class Get extends Controller
{

    public function get(Request $request)
    {
        try {
            $request->validate([
                'tag'   => 'string',
                'page'  => 'string'
            ]);

            $tag = $request->tag ? $request->tag : false;
            $pagination_per_page = 18;

            if ($tag) {
                $groups = Group::where('tags', $tag)->where('status', '!=', GroupsEnum::DELETED)->paginate($pagination_per_page);

                return response()->json([
                    'status'    => true,
                    'message'   => 'Successful retrievement of groups',
                    'data'      => $groups
                ], 200);
            } else {
                $groups = Group::where('status', '!=', GroupsEnum::DELETED)->paginate($pagination_per_page);

                return response()->json([
                    'status'    => true,
                    'message'   => 'Successful retrievement of groups',
                    'data'      => $groups
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }

    public function find(Request $request)
    {
        try {
            $request->validate([
                'group_id'    => "required|uuid"
            ]);

            $group = Group::find($request->group_id);

            return response()->json([
                'status'    => true,
                'message'   => 'Successful retrievement of group',
                'data'      => $group
            ], 200);
        } catch (\Throwable $th) {
            return response()->json("Something went wrong", 500);
        }
    }
}
