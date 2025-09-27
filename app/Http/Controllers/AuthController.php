<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\register_user;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(register_user $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $permissions = $user ? $user->permissions() : collect();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token, 'permissions' => $permissions], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
