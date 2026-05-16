<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $comments = Comment::with('user')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'Comments retrieved successfully',
            'data' => CommentResource::collection($comments),
            'meta' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
            ]
        ], 200);
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'course_id' => $request->input('course_id'),
            'user_id' => $request->user()->id,
            'comment' => $request->input('comment'),
        ]);

        $comment->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'data' => new CommentResource($comment)
        ], 201);
    }

    public function show(Comment $comment)
    {
        $comment->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Comment retrieved successfully',
            'data' => new CommentResource($comment)
        ], 200);
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->update([
            'comment' => $request->input('comment'),
        ]);

        $comment->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Comment updated successfully',
            'data' => new CommentResource($comment)
        ], 200);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id && $request->user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted successfully'
        ], 200);
    }

    public function courseComments(Course $course, Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $comments = $course->comments()
            ->with('user')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'Course comments retrieved successfully',
            'data' => CommentResource::collection($comments),
            'meta' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'course' => [
                    'id' => $course->id,
                    'slug' => $course->slug,
                    'title' => $course->title,
                ]
            ]
        ], 200);
    }
}
