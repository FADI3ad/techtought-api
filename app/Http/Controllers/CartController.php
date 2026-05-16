<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Cart::where('user_id', $request->user()->id)
            ->with(['course.category'])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart items retrieved successfully',
            'data' => CartResource::collection($cartItems),
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $userId = $request->user()->id;
        $courseId = $request->course_id;

        // Check if already in cart
        $exists = Cart::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course is already in your cart',
            ], 422);
        }

        $cart = Cart::create([
            'user_id' => $userId,
            'course_id' => $courseId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Course added to cart successfully',
            'data' => new CartResource($cart),
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart successfully',
        ], 200);
    }
}
