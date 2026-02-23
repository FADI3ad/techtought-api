<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        $email = $request->input('email');

        $password = $request->input('password');

        $admin = Admin::where('email', '=', $email)->first();

        if (!$admin || !Hash::check($password, $admin->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $admin->createToken('admin-dashboard-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name
                ],
                'token' => $token
            ]
        ], 200);

    }

}
