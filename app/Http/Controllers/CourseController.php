<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Course::withAvg('reviews', 'rating')
            ->with(['category', 'subCategory', 'instructor:id,name']);

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by subcategory
        if ($request->has('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        // Filter by free/paid
        if ($request->has('is_free')) {
            $query->where('is_free', $request->boolean('is_free'));
        }

        // Filter by rating
        if ($request->has('min_rating')) {
            $query->having('reviews_avg_rating', '>=', $request->min_rating);
        }

        $courses = $query->latest()->paginate($request->query('per_page', 12));

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
                    'is_enrolled' => $course->is_enrolled,
                    'is_favorite' => $course->is_favorite,
                    'avg_rating' => $course->avg_rating,
                    'reviews_count' => $course->reviews()->count(),
                    'created_at' => $course->created_at->toDateTimeString(),
                    'updated_at' => $course->updated_at->toDateTimeString(),
                    'instructor' => [
                        'id' => $course->instructor_id,
                        'name' => $course->instructor?->name,
                    ],
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
        } else {
            unset($data['image_path']);
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
        // Allow if user is instructor OR admin
        if ($course->instructor_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Manually delete related to avoid integrity issues if cascade is missing in DB
        foreach ($course->sections as $section) {
            $section->lessons()->delete();
            $section->delete();
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

    public function globalSearch(\Illuminate\Http\Request $request)
    {
        $q = $request->query('q', '');

        if (strlen($q) < 1) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'courses' => [],
                    'categories' => [],
                    'subcategories' => []
                ]
            ]);
        }

        // 1. Search Courses
        $courses = \App\Models\Course::where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->select('id', 'title', 'slug', 'image_path', 'price', 'is_free')
            ->limit(5)
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'type' => 'course',
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'image' => $course->image_path ? asset('storage/' . $course->image_path) : null,
                    'price' => $course->price,
                    'is_free' => $course->is_free
                ];
            });

        // 2. Search Categories
        $categories = \App\Models\Category::where('name', 'like', "%{$q}%")
            ->select('id', 'name', 'slug', 'image_path')
            ->limit(5)
            ->get()
            ->map(function($cat) {
                return [
                    'id' => $cat->id,
                    'type' => 'category',
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'image' => $cat->image_path ? asset('storage/' . $cat->image_path) : null
                ];
            });

        // 3. Search Subcategories
        $subcategories = \App\Models\SubCategory::where('name', 'like', "%{$q}%")
            ->with('category:id,slug')
            ->select('id', 'name', 'slug', 'category_id')
            ->limit(5)
            ->get()
            ->map(function($sub) {
                return [
                    'id' => $sub->id,
                    'type' => 'subcategory',
                    'name' => $sub->name,
                    'slug' => $sub->slug,
                    'category_slug' => $sub->category?->slug
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'courses' => $courses,
                'categories' => $categories,
                'subcategories' => $subcategories
            ]
        ]);
    }
}

