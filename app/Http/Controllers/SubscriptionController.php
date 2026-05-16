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
}
