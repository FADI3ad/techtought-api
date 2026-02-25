<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorRequest;

class AdminController extends Controller
{

public function approveRequest($id)
{
    $request = InstructorRequest::findOrFail($id);

    if ($request->status !== 'pending') {
        return response()->json(['message'=>'Already processed'],400);
    }

    
    $instructorRequest = InstructorRequest::create([
        'fullname' => $request->fullname,
        'email' => $request->email,
        'country' => $request->country,
        'subject' => $request->subject,
        'age' => $request->age,
        'phone' => $request->phone,
        'experience_years' => $request->experience_years,
        'slug' => $request->slug,
        'password' => bcrypt('ChangeMe123') 
    ]);

    $request->status = 'approved';
    $request->save();

    return response()->json([
        'message' => 'Instructor approved successfully'
    ]);
}

}
