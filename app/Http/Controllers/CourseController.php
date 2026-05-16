<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withAvg('reviews', 'rating')->latest()->paginate(12);

        return response()->json([
            'status' => 'success',
            'data' => [
                'courses' => $courses
            ]
        ]);
    }

    public function topRated()
    {
        $courses = Course::withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->paginate(8);

        return response()->json([
            'status' => 'success',
            'data' => [
                'courses' => $courses
            ]
        ]);
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();

        if ($data['is_free']) {
            $data['price'] = 0;
        }

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('courses', 'public');
            $data['image_path'] = $path;
        }

        $data['instructor_id'] = auth()->id();

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Course created successfully',
            'data' => [
                'course' => [
                    'id' => $course->id,
                    'slug' => $course->slug,
                    'title' => $course->title,
                    'description' => $course->description,
                    'image_path' => $course->image_path
                        ? asset('storage/' . $course->image_path)
                        : null,
                    'requirements' => $course->requirements,
                    'language' => $course->lang,
                    'is_free' => $course->is_free,
                    'price' => $course->price,
                    'category_id' => $course->category_id,
                    'sub_category_id' => $course->sub_category_id,
                ]
            ]
        ], 201);
    }

    public function show(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Course retrieved successfully',
            'data' => [
                'course' => [
                    'id' => $course->id,
                    'slug' => $course->slug,
                    'title' => $course->title,
                    'category' => $course->category->name,
                    'subcategory' => $course->subCategory->name,
                    'requirements' => $course->requirements,
                    'language' => $course->lang,
                    'description' => $course->description,
                    'image_path' => asset('storage/' . $course->image_path),
                    'is_free' => $course->is_free,
                    'price' => $course->price,
                    'created_at' => $course->created_at->toDateTimeString(),
                    'updated_at' => $course->updated_at->toDateTimeString(),
                ]
            ]
        ], 200);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        if ($course->instructor_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validated();

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('courses', 'public');
            $data['image_path'] = $path;
        }

        $course->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Course updated successfully',
            'data' => $course
        ], 200);
    }

    public function destroy(Course $course)
    {
        if ($course->instructor_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $course->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Course deleted successfully'
        ], 200);
    }

    public function showWithSectionsAndLessons(Course $course)
    {
        // Check if user is enrolled or is the instructor of the course
        $isInstructor = auth('sanctum')->check() && auth('sanctum')->id() === $course->instructor_id;
        $isEnrolled = auth('sanctum')->check() && auth('sanctum')->user()->enrolledCourses()->where('course_id', $course->id)->exists();

        if (!$isInstructor && !$isEnrolled) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must be enrolled in this course to view its content.'
            ], 403);
        }

        $course->load([
            'sections.lessons'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Course retrieved successfully',
            'data' => [
                'id' => $course->id,
                'slug' => $course->slug,
                'title' => $course->title,
                'description' => $course->description,
                'sections' => $course->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'name' => $section->name,
                        'lessons_count' => $section->lessons->count(),
                        'lessons' => $section->lessons->map(function ($lesson) {
                            return [
                                'id' => $lesson->id,
                                'title' => $lesson->title,
                                'video_url' => $lesson->video_path
                                    ? asset('storage/' . $lesson->video_path)
                                    : null,
                            ];
                        }),
                    ];
                }),
            ]
        ], 200);
    }
}
