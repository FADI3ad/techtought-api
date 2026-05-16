<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\StoreSectionRequest;
use App\Http\Requests\Section\UpdateSectionRequest;
use App\Models\Section;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::select(['id', 'slug', 'name'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Sections retrieved successfully',
            'data' => [
                'sections' => $sections
            ],
            'meta' => [
                'total' => $sections->count()
            ]
        ], 200);
    }

    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();

        // add order
        $data['order'] = Section::where('course_id', $data['course_id'])->count() + 1;

        $section = Section::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Section created successfully',
            'data' => [
                'section' => [
                    'id' => $section->id,
                    'slug' => $section->slug,
                    'name' => $section->name,
                    'order' => $section->order
                ]
            ]
        ], 201);
    }

    public function show(Section $section)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Section retrieved successfully',
            'data' => [
                'section' => [
                    'id' => $section->id,
                    'slug' => $section->slug,
                    'name' => $section->name
                ]
            ]
        ], 200);
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Section updated successfully',
            'data' => [
                'section' => [
                    'id' => $section->id,
                    'slug' => $section->slug,
                    'name' => $section->name
                ]
            ]
        ], 200);
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Section deleted successfully'
        ], 200);
    }
}