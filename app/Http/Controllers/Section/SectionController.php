<?php

namespace App\Http\Controllers\Section;

use App\Models\Section;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;

class SectionController extends Controller
{

    public function store(StoreSectionRequest $request)
    {
        $name = $request->input('name');
        $courseId  = $request->input('courseId');



        Section::create([
            "name" => $name,
            "course_id" => $courseId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Section created successfuly',
            'data' => [
                'section' => [
                    'name' => $name,
                    'course_id' => $courseId,
                ],

            ]
        ], 201);
    }
       
    public function index() 
    {
        $sections = Section::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Sections retrieved successfully',
            'data' => [
                'sections' => $sections,
            ]
        ], 200);
    }
    public function show(Section $section)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Section retrieved successfully',
            'data' => [
                'section' => [
                    'name' => $section->name,
                    'course_id' => $section->course_id,
                ],
            ]
        ], 200);
    }

    public function update(StoreSectionRequest $request, Section $section)
    {
        $name = $request->input('name');
        $courseId = $request->input('courseId');

        $section->update([
            "name" => $name,
            "course_id" => $courseId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Section updated successfully',
            'data' => [
                'section' => [
                    'name' => $name,
                    'course_id' => $courseId,
                ],
            ]
        ], 201);
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Section deleted successfully',
            'data' => null
        ], 201);
    }
}











