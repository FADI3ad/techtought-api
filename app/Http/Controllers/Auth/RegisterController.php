<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\WelcomeMail;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {

        $user = User::create($request->validated());

        $student = Student::create([
            "user_id" => $user->id
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user));


        $token = $user->createToken('mobile-app-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'image' => $user->image,
                ],
                'token' => $token
            ]
        ], 201);
    }
}
