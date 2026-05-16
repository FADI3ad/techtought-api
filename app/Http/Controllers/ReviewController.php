<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $reviews = Review::orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'Reviews retrieved successfully',
            'data' => ReviewResource::collection($reviews),
            'meta' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
            ]
        ], 200);
    }

    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $review = Review::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Review created successfully',
            'data' => new ReviewResource($review)
        ], 201);
    }

    public function show(Review $review)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Review retrieved successfully',
            'data' => new ReviewResource($review)
        ], 200);
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Review updated successfully',
            'data' => new ReviewResource($review)
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