<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;






class LoginController
{

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');

        $password = $request->input('password');

        $user = User::where('email', '=', $email)->firstOrFail();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('mobile-app-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'country' => $user->country,
                    'image' => $user->image,
                ],
                'token' => $token
            ]
        ], 200);


    }
}
