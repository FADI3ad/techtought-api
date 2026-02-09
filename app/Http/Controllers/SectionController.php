<?php


namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Section::all()
        ]);
    }

    public function show($id)
    {
        return response()->json(
            Section::findOrFail($id)
        );
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $section = Section::create($validated);

        return response()->json($section, 201);
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);


        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'course_id' => 'sometimes|required|exists:courses,id',
        ]);

        $section->update($validated);

        return response()->json($section);
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();

        return response()->json(['message' => 'deleted']);
    }
}
