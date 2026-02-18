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
        $course = Course::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Course created successfully',
            'data' => [
                "course" => [
                    "id" => $course->id,
                    "slug" => $course->slug,
                    "title" => $course->title,
                    "description" => $course->description,
                    "image" => $course->image_path,
                    "requirements" => $course->requirements,
                    "language" => $course->lang,
                    "is_free" => $course->is_free,
                    "price" => $course->price,
                    "subcategory" => $course->subCategory->name
                    // "instructor_id" => $course->instructor_id,
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
                    "image" => $course->image_path,
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





    
}
