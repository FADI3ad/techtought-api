<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Student;
use App\Models\User;


class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create($validatedData);

        $student = Student::create([
            "user_id"=>$user->id
        ]);

        $token = $user->createToken('mobile-app-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful',
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
        ], 201);

    }

}
