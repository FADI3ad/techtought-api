<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::select(['id', 'content', 'slug','course_id'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Reviews retrieved successfully',
            'data' => [
                "reviews" => $reviews
            ],
            'meta' => [
                'total' => $reviews->count()
            ]
        ], 200);
    }

    public function store(StoreReviewRequest $request)
    {
        $review = Review::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Review created successfully',
            'data' => [
                 "Review"=>[
"id"=>$review->id,
"slug"=>$review->slug,
"content"=>$review->content,
"course_id"=>$review->course_id,



                ]
            ]
        ], 201);
    }

    public function show(Review $review)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Review retrieved successfully',
            'data' => [
               "Review"=>[
"id"=>$review->id,
"slug"=>$review->slug,
"content"=>$review->content,
"course_id"=>$review->course_id,



                ]
            ]
        ], 200);
    }

    public function update(Review $review, UpdateReviewRequest $request)
    {
        $review->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Review updated successfully',
            'data' => [
                "Review"=>[
"id"=>$review->id,
"slug"=>$review->slug,
"content"=>$review->content,
"course_id"=>$review->course_id,



                ]
            ]
        ], 200);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Review deleted successfully'
        ], 200);
    }
}