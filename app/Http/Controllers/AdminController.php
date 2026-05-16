<?php

namespace App\Http\Controllers;

use App\Models\InstructorAccountRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\InstructorApprovedMail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function approve($id)
    {
        $request = InstructorAccountRequest::findOrFail($id);

        if ($request->status === 'approved') {
            return response()->json([
                'status' => 'error',
                'message' => 'Request already approved'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $generatedPassword = Str::random(10);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'image' => null,
                'role' => 'instructor',
                'password' => Hash::make($generatedPassword),
                'email_verified_at' => now(),
            ]);

            $request->update([
                'status' => 'approved'
            ]);

            // Send Email to Instructor
            Mail::to($user->email)->send(new InstructorApprovedMail($user->name, $user->email, $generatedPassword));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Instructor approved and user created successfully',
                'data' => [
                    'user' => $user,
                    'generated_password' => $generatedPassword
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
