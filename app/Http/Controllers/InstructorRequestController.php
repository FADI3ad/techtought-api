<?php

namespace App\Http\Controllers;

use App\Models\InstructorRequest;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use Illuminate\Support\Facades\Storage;

class InstructorRequestController extends Controller
{


    public function index()
    {
        $requests = InstructorRequest::select([
            'id',
            'full_name',
            'email',
            'status',
            'slug'
        ])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor requests retrieved successfully',
            'data' => [
                'instructor_requests' => $requests
            ],
            'meta' => [
                'total' => $requests->count()
            ]
        ], 200);
    }


    public function store(StoreInstructorRequest $request)
    {
        $cvPath = $request->file('cv')
            ->store('instructor_requests/cv', 'public');

        $frontPath = $request->file('national_id_front')
            ->store('instructor_requests/id_front', 'public');

        $backPath = $request->file('national_id_back')
            ->store('instructor_requests/id_back', 'public');

        $instructorRequest = InstructorRequest::create([
            ...$request->validated(),
            'cv' => $cvPath,
            'national_id_front' => $frontPath,
            'national_id_back' => $backPath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request submitted successfully',
            'data' => [
                'instructor_request' => [
                    'id' => $instructorRequest->id,
                    'fullname' => $instructorRequest->fullname,
                    'email' => $instructorRequest->email,
                    'status' => $instructorRequest->status,
                    'slug' => $instructorRequest->slug
                ]
            ]
        ], 201);
    }


    public function show(InstructorRequest $instructorRequest)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request retrieved successfully',
            'data' => [
                'instructor_request' => [
                    'id' => $instructorRequest->id,
                    'fullname' => $instructorRequest->fullname,
                    'email' => $instructorRequest->email,
                    'country' => $instructorRequest->country,
                    'subject' => $instructorRequest->subject,
                    'age' => $instructorRequest->age,
                    'phone' => $instructorRequest->phone,
                    'experience_years' => $instructorRequest->experience_years,
                    'status' => $instructorRequest->status,
                    'slug' => $instructorRequest->slug
                ]
            ]
        ], 200);
    }


    public function update( InstructorRequest $instructorRequest,UpdateInstructorRequest $request
    )
    {
        $data = $request->validated();

        if ($request->hasFile('cv')) {
            Storage::disk('public')->delete($instructorRequest->cv);
            $data['cv'] = $request->file('cv')
                ->store('instructor_requests/cv', 'public');
        }

        if ($request->hasFile('national_id_front')) {
            Storage::disk('public')->delete($instructorRequest->national_id_front);
            $data['national_id_front'] = $request->file('national_id_front')
                ->store('instructor_requests/id_front', 'public');
        }

        if ($request->hasFile('national_id_back')) {
            Storage::disk('public')->delete($instructorRequest->national_id_back);
            $data['national_id_back'] = $request->file('national_id_back')
                ->store('instructor_requests/id_back', 'public');
        }

        $instructorRequest->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request updated successfully',
            'data' => [
                'instructor_request' => [
                    'id' => $instructorRequest->id,
                    'fullname' => $instructorRequest->fullname,
                    'email' => $instructorRequest->email,
                    'status' => $instructorRequest->status,
                    'slug' => $instructorRequest->slug
                ]
            ]
        ], 200);
    }



    public function destroy(InstructorRequest $instructorRequest)
    {
        Storage::disk('public')->delete([
            $instructorRequest->cv,
            $instructorRequest->national_id_front,
            $instructorRequest->national_id_back
        ]);

        $instructorRequest->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request deleted successfully'
        ], 200);
    }
}