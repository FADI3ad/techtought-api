<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\instructor\StoreInstructorRequest;
use App\Models\InstructorAccountRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorRequestController extends Controller
{

    public function index()
    {
        $requests = InstructorAccountRequest::paginate(10)->select(['id', 'slug', 'name', 'email', 'country', 'phone', 'age', 'experience_years', 'status']);

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor requests retrieved successfully',
            'data' => [
                "requests" => $requests
            ],
            'meta' => [
                'total' => $requests->count()
            ]
        ], 200);
    }

    // for instructor
    public function store(StoreInstructorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('national_id_front_image')) {
            $data['national_id_front_image'] = $request->file('national_id_front_image')->store('instructors', 'public');
        }

        if ($request->hasFile('national_id_back_image')) {
            $data['national_id_back_image'] = $request->file('national_id_back_image')->store('instructors', 'public');
        }

        if ($request->hasFile('cv_link')) {
            $data['cv_link'] = $request->file('cv_link')->store('instructors', 'public');
        }

        $instructorRequest = InstructorAccountRequest::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request created successfully',
            'data' => [
                "instructor request" => $instructorRequest
            ]
        ], 201);
    }

    // for admin: show single request
    public function show(InstructorAccountRequest $instructorAccountRequest)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request retrieved successfully',
            'data' => [
                "request" => $instructorAccountRequest
            ]
        ], 200);
    }


    // for admin: delete request
    public function destroy(InstructorAccountRequest $instructorAccountRequest)
    {
        if ($instructorAccountRequest->national_id_front_image) {
            Storage::disk('public')->delete($instructorAccountRequest->national_id_front_image);
        }

        if ($instructorAccountRequest->national_id_back_image) {
            Storage::disk('public')->delete($instructorAccountRequest->national_id_back_image);
        }

        $instructorAccountRequest->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Instructor request deleted successfully'
        ], 200);
    }



    public function changeStatus(InstructorAccountRequest $instructoraccountrequest , Request $request) {

        if ($request->input('status') === "approved") {
            //create in inst table 1
        }
        $instructoraccountrequest->status = $request->input('status');
        $instructoraccountrequest->update();
    }




    
}
