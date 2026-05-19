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
        $query = Review::with('user');

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Fetch authenticated user's review for this course if requested
        $userReview = null;
        if (auth('sanctum')->check() && $request->has('course_id')) {
            $userReview = Review::where('user_id', auth('sanctum')->id())
                ->where('course_id', $request->course_id)
                ->first();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reviews retrieved successfully',
            'data' => ReviewResource::collection($reviews),
            'user_review' => $userReview ? new ReviewResource($userReview) : null,
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
        $userId = auth()->id();

        // Verify if user is enrolled in this course
        $isEnrolled = auth()->user()->enrolledCourses()->where('course_id', $data['course_id'])->exists();
        if (!$isEnrolled) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must be enrolled in this course to rate or review it.'
            ], 403);
        }

        // Check if a review already exists
        $review = Review::where('user_id', $userId)
            ->where('course_id', $data['course_id'])
            ->first();

        if ($review) {
            $review->update([
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]);
            $message = 'Review updated successfully';
            $statusCode = 200;
        } else {
            $data['user_id'] = $userId;
            $review = Review::create($data);
            $message = 'Review created successfully';
            $statusCode = 201;
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => new ReviewResource($review)
        ], $statusCode);
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