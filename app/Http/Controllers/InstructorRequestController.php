<?php

namespace App\Http\Controllers;

use App\Models\InstructorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
    'id' => 'required|integer|unique:instructor_requests,id', 
    'fullname' => 'required|string|max:255',
    'email' => 'required|email|unique:instructor_requests,email',
    'country' => 'required|string|max:100',
    'subject' => 'required|string|max:150',
    'age' => 'required|integer|min:18',
    'phone' => 'required|string|max:20',
    'experience_years' => 'required|integer|min:0',
    'cv_link' => 'required|mimes:pdf|max:2048',
    'national_id_front' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    'national_id_back' => 'required|image|mimes:jpg,jpeg,png|max:2048',
]);
    
        $cvPath = $request->file('cv')->store('instructor_requests/cv', 'public');

        $frontPath = $request->file('national_id_front')
                             ->store('instructor_requests/id_front', 'public');

        $backPath = $request->file('national_id_back')
                            ->store('instructor_requests/id_back', 'public');

       
       InstructorRequest::create([
    'fullname' => $request->fullname,
    'email' => $request->email,
    'country' => $request->country,
    'subject' => $request->subject,
    'age' => $request->age,
    'phone' => $request->phone,
    'experience_years' => $request->experience_years,
    'cv' => $cvPath,
    'national_id_front' => $frontPath,
    'national_id_back' => $backPath,
]);

        return response()->json([
            'status' => 'success',
            'message' => 'Your request has been submitted successfully'
        ], 201);
    }
}