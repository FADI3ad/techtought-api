<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorAccountRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'image' => null,
                'role' => 'instructor',
                'password' => Hash::make(Str::random(10)),
                'email_verified_at' => now(),
            ]);


            $request->update([
                'status' => 'approved'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Instructor approved and user created successfully',
                'data' => [
                    'user' => $user
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
