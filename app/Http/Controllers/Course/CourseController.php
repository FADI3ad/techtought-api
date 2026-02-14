<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $courses
        ], 200);

    }

    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();


        $course = Course::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }


    public function show($id)
    {
        $course = Course::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $course
        ], 200);
    }


    public function update(UpdateCourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);

        if ($course->instructor_id != Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validated();



        $course->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Course updated successfully',
            'data' => $course
        ], 200);
    }


    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if ($course->instructor_id != Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($course->image) {
            Storage::delete("public/courses/$course->image");
        }

        $course->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Course deleted successfully'
        ], 200);
    }

    public function myCourses()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->with('category', 'sections')
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $courses
        ], 200);
    }
}
