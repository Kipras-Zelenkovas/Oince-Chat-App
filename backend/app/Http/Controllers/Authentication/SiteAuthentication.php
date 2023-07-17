<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\ProvidersEnum;
use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'message'   => 'Successful register'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid credentials'
                ]);
            }

            $token = $user->createToken($validated['device_name'] . rand(1569, 945214))->plainTextToken;

            return response()->json([
                'status'    => true,
                'API_token' => $token,
                'message'   => 'Successful login'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {

            $user = User::where('email', $request->email)->first();

            $user->tokens()->delete();

            return response()->json([
                'status'    => true,
                'message'   => 'Successful logout'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
