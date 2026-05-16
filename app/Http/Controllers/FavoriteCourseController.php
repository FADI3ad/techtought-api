<?php

namespace App\Http\Controllers;

use App\Http\Requests\Favorite\StoreFavoriteRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class FavoriteCourseController extends Controller
{
    //-------------------------------------------------
    // Display a listing of the favorite courses.
    //--------------------------------------------------
    public function index(Request $request)
    {
        $favorites = $request->user()->favoriteCourses()->with(['instructor', 'category', 'subCategory'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Favorite courses retrieved successfully',
            'data' => [
                'favorites' => $favorites
            ],
            'meta' => [
                'total' => $favorites->count()
            ]
        ], 200);
    }

    //-------------------------------------------------
    // Store a newly created resource in storage.
    //--------------------------------------------------
    public function store(StoreFavoriteRequest $request)
    {
        $user = $request->user();
        $courseId = $request->course_id;

        // Use syncWithoutDetaching to avoid duplicates
        $user->favoriteCourses()->syncWithoutDetaching([$courseId]);

        return response()->json([
            'status' => 'success',
            'message' => 'Course added to favorites successfully.',
            'data' => null
        ], 201);
    }

    //-------------------------------------------------
    // Remove the specified resource from storage.
    //--------------------------------------------------
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        
        $user->favoriteCourses()->detach($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Course removed from favorites successfully.',
            'data' => null
        ], 200);
    }
}
