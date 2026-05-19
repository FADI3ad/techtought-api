<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //-------------------------------------------------
    // Store a newly created resource in storage.
    //--------------------------------------------------
    public function store(StoreSubscriptionRequest $request)
    {
        $subscription = Subscription::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscribed successfully to the newsletter.',
            'data' => [
                'subscription' => $subscription
            ]
        ], 201);
    }

    //-------------------------------------------------
    // List all subscriptions for Admin panel.
    //--------------------------------------------------
    public function adminIndex()
    {
        $subscriptions = Subscription::latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscriptions retrieved successfully.',
            'data' => [
                'subscriptions' => $subscriptions
            ]
        ], 200);
    }

    //-------------------------------------------------
    // Delete a subscription (unsubscribe).
    //--------------------------------------------------
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription removed successfully.'
        ], 200);
    }
}
