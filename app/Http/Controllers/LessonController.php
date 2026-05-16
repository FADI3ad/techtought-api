<?php

namespace App\Http\Controllers;

use App\Http\Requests\lesson\StoreLessonRequest;
use App\Http\Requests\lesson\UpdateLessonRequest;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::select(['id', 'slug', 'title', 'section_id'])->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Lessons retrieved successfully',
            'data' => [
                'lessons' => $lessons
            ],
            'meta' => [
                'total' => $lessons->count()
            ]
        ], 200);
    }

    public function store(StoreLessonRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('lessons', 'public');
            $data['video_path'] = $path;
        }

        $data['order'] = Lesson::where('section_id', $data['section_id'])->count() + 1;

        $lesson = Lesson::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson created successfully',
            'data' => [
                'lesson' => [
                    'id' => $lesson->id,
                    'section_id' => $lesson->section_id,
                    'video_path' => $lesson->video_path
                        ? asset('storage/' . $lesson->video_path)
                        : null,
                    'order' => $lesson->order
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
                'lesson' => [
                    'id' => $lesson->id,
                    'section_id' => $lesson->section_id,
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
                    'id' => $lesson->id,
                    'section_id' => $lesson->section_id,
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
