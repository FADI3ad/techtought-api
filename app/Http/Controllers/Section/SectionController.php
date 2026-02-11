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










}
