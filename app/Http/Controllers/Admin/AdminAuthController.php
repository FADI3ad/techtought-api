<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class AdminAuthController extends Controller
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

   
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|min:6|confirmed'
        ]);

        $admin = $request->user();

        if(!Hash::check($request->old_password,$admin->password)){
            return response()->json(['message'=>'Old password incorrect'],403);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json(['message'=>'Password updated']);
    }
}