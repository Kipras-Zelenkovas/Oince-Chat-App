<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\ProvidersEnum;
use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiteAuthentication extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'provider'  => ProvidersEnum::Default,
                'role'      => RolesEnum::User
            ]);

            $user->save();

            return response()->json([
                'status'    => true,
                'message'   => 'User was successfuly created'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
