<?php

namespace App\Http\Controllers\Lesson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\StoreLessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Models\Lesson;


class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::select(['id', 'section_id'])->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Lessons retrieved successfully',
            'data' => [
                "lessons" => $lessons
            ],
            'meta' => [
                'total' => $lessons->count()
            ]
        ], 200);
    }

    public function store(StoreLessonRequest $request)
    {


        $lesson = Lesson::create($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Lesson created successfully',
            'data' => [
                "lesson" => [
                    "id" => $lesson->id,
                    "section_id" => $lesson->section_id,
                ]
            ]
        ], 201);
    }

    public function show(Lesson $lesson)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Lesson retrieved successfully',
            'data' => [
                "lesson" => [
                    "id" => $lesson->id,
                    "section_id" => $lesson->section_id,
                ]
            ]
        ], 200);
    }


    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {

        $lesson->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson updated successfully',
            'data' => [
                'lesson' => [
                    "id" => $lesson->id,
                    "section_id" => $lesson->section_id,

                ]
            ]
        ], 200);
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Lesson deleted successfully'
        ], 200);
    }
}