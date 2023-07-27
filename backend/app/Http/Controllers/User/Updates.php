<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Updates extends Controller
{

    public function update(Update $request)
    {
        try {
            $user = $request->user();
            $validated = $request->validated();

            User::where('id', $user->id)->update($validated);

            return response()->json([
                'status'    => true,
                'message'   => 'User successfuly updated'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json('Something went wrong');
        }
    }
}
