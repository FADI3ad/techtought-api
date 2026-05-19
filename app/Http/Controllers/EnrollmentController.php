<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the user's enrolled courses.
     */
    public function index()
    {
        $user = Auth::user();
        $courses = $user->enrolledCourses()->withAvg('reviews', 'rating')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'courses' => $courses->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'slug' => $course->slug,
                        'title' => $course->title,
                        'image_path' => asset('storage/' . $course->image_path),
                        'is_free' => $course->is_free,
                        'price' => $course->price,
                        'avg_rating' => $course->reviews_avg_rating ?? 0,
                        'is_enrolled' => true,
                        'instructor' => [
                            'name' => $course->instructor?->name,
                        ],
                    ];
                })
            ]
        ]);
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);

        // Check if already enrolled
        if ($user->enrolledCourses()->where('course_id', $course->id)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already enrolled in this course.'
            ], 400);
        }

        // Check if course is free
        if (!$course->is_free) {
            return response()->json([
                'status' => 'error',
                'message' => 'This course is not free. Please complete the purchase process.'
            ], 400);
        }

        // Create enrollment
        $user->enrolledCourses()->attach($course->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully enrolled in the course.',
            'data' => [
                'course_slug' => $course->slug
            ]
        ], 201);
    }
}
