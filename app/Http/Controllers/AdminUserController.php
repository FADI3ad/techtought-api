<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Get a list of all non-admin users (students and instructors).
     */
    public function index()
    {
        $users = User::whereIn('role', ['student', 'instructor'])->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'users' => $users
            ]
        ], 200);
    }

    /**
     * Toggle the block status of a user.
     */
    public function toggleBlock(User $user)
    {
        // Don't allow blocking another admin
        if ($user->role === 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot block an admin.'
            ], 403);
        }

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        if ($user->is_blocked) {
            // Revoke all tokens to immediately log them out
            $user->tokens()->delete();
            $message = 'User has been blocked successfully.';
        } else {
            $message = 'User has been unblocked successfully.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'user' => $user
            ]
        ], 200);
    }
}
