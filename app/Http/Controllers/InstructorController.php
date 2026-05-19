<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $coursesCount = Course::where('instructor_id', $user->id)->count();
        $totalStudents = 0; // Future implementation: count unique enrollments
        $averageRating = Course::where('instructor_id', $user->id)->withAvg('reviews', 'rating')->get()->avg('reviews_avg_rating') ?: 0;
        
        $recentComments = Comment::whereHas('course', function($query) use ($user) {
            $query->where('instructor_id', $user->id);
        })->with(['user', 'course'])->latest()->take(5)->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'stats' => [
                    'courses_count' => $coursesCount,
                    'students_count' => $totalStudents,
                    'average_rating' => round($averageRating, 1)
                ],
                'recent_comments' => $recentComments
            ]
        ]);
    }

    public function courses()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->withCount(['sections', 'comments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'courses' => $courses
            ]
        ]);
    }

    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('instructor_id', Auth::id())
            ->with(['sections.lessons', 'comments.user', 'reviews.user'])
            ->withAvg('reviews', 'rating')
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => [
                'course' => $course
            ]
        ]);
    }

    public function reviews()
    {
        $user = Auth::user();

        $reviews = Review::whereHas('course', function($query) use ($user) {
            $query->where('instructor_id', $user->id);
        })->with(['user', 'course'])->latest()->get();

        $comments = Comment::whereHas('course', function($query) use ($user) {
            $query->where('instructor_id', $user->id);
        })->with(['user', 'course'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'reviews' => $reviews,
                'comments' => $comments
            ]
        ]);
    }
}
