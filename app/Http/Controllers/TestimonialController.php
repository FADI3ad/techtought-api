<?php

namespace App\Http\Controllers;

use App\Http\Requests\Testimonial\StoreTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    //-------------------------------------------------
    // Display a listing of visible testimonials.
    //--------------------------------------------------
    public function index()
    {
        $testimonials = Testimonial::where('is_visible', true)
            ->with('user:id,name,image')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonials retrieved successfully',
            'data' => [
                'testimonials' => $testimonials
            ],
            'meta' => [
                'total' => $testimonials->count()
            ]
        ], 200);
    }

    //-------------------------------------------------
    // Display a listing of all testimonials for admin.
    //--------------------------------------------------
    public function adminIndex()
    {
        $testimonials = Testimonial::with('user:id,name,email')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'All testimonials retrieved successfully',
            'data' => [
                'testimonials' => $testimonials
            ],
            'meta' => [
                'total' => $testimonials->count()
            ]
        ], 200);
    }

    //-------------------------------------------------
    // Store a newly created testimonial in storage.
    //--------------------------------------------------
    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = Testimonial::create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_visible' => false, // Always false until admin approves
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for your rating! It will be visible after review.',
            'data' => [
                'testimonial' => $testimonial
            ]
        ], 201);
    }

    //-------------------------------------------------
    // Toggle the visibility of a testimonial.
    //--------------------------------------------------
    public function toggleVisibility(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_visible' => !$testimonial->is_visible
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $testimonial->is_visible ? 'Testimonial approved successfully.' : 'Testimonial hidden successfully.',
            'data' => [
                'testimonial' => $testimonial
            ]
        ], 200);
    }

    //-------------------------------------------------
    // Remove the specified testimonial from storage.
    //--------------------------------------------------
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial deleted successfully.',
            'data' => null
        ], 200);
    }
}
