<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{


    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();


        if ($data['is_free']) {
            $data['price'] = 0;
        }


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $data['image_path'] = $path;
        }

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Course created successfully',
            'data' => [
                "course" => [
                    "id" => $course->id,
                    "slug" => $course->slug,
                    "title" => $course->title,
                    "description" => $course->description,
                    "image_path" => $course->image_path
                        ? asset('storage/' . $course->image_path)
                        : null,
                    "requirements" => $course->requirements,
                    "language" => $course->lang,
                    "is_free" => $course->is_free,
                    "price" => $course->price,
                    "category_id" => $course->category_id,
                    "sub_category_id" => $course->sub_category_id,
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
                "course" => [
                    "id" => $course->id,
                    "slug" => $course->slug,
                    "title" => $course->title,
                    "description" => $course->description,
                    "image_path" => asset('storage/' . $course->image_path),
                    "is_free" => $course->is_free,
                    "price" => $course->price,
                    "subcategory" => $course->subCategory->name
                    // "instructor_id" => $course->instructor_id,
                ]
            ]
        ], 201);
    }


    public function update(UpdateCourseRequest $request, $id) {}


    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Course deleted successfully'
        ], 200);
    }





    public function showWithSectionsAndLessons(Course $course)
    {
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
