<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'status' => 'success',
            'data' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'country'    => $user->country,
                'image'      => $user->image ? asset('storage/' . $user->image) : null,
                'role'       => $user->role,
                'created_at' => $user->created_at,
                'enrolled_courses_count' => $user->enrolledCourses()->count(),
            ]
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'    => 'sometimes|required|string|max:255',
            'phone'   => 'nullable|string|max:30',
            'country' => 'nullable|string|max:100',
            'email'   => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile updated successfully',
            'data'    => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => $user->phone,
                'country' => $user->country,
                'image'   => $user->image ? asset('storage/' . $user->image) : null,
                'role'    => $user->role,
            ]
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $user->update(['password' => $request->new_password]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Password changed successfully.',
        ]);
    }
}
