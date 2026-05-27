<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Get the redirection URL for the specified provider (Google, GitHub, Facebook).
     *
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google', 'github', 'facebook'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid provider specified.'
            ], 400);
        }

        try {
            // Generate OAuth redirection URL statelessly for API consumption
            $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'url' => $url
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate redirection URL: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle the provider callback from the frontend SPA.
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'github', 'facebook'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid provider specified.'
            ], 400);
        }

        try {
            // Retrieve user details from OAuth provider statelessly using the code in query
            $socialUser = Socialite::driver($provider)->stateless()->user();

            if (!$socialUser || !$socialUser->getEmail()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to retrieve email address from provider.'
                ], 422);
            }

            // 1. Search for existing user with this specific OAuth provider account
            $user = User::where('provider_name', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if (!$user) {
                // 2. Search for user by email address (in case they signed up via email previously)
                $user = User::where('email', $socialUser->getEmail())->first();

                if ($user) {
                    // Link the existing account to this provider
                    $user->update([
                        'provider_name' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'provider_token' => $socialUser->token,
                    ]);
                } else {
                    // 3. Create a brand new user
                    // Some providers like Github might not have a full name, default to nickname or email local part
                    $name = $socialUser->getName() ?: ($socialUser->getNickname() ?: explode('@', $socialUser->getEmail())[0]);
                    
                    // Create user record
                    $user = User::create([
                        'name' => $name,
                        'email' => $socialUser->getEmail(),
                        'image' => $socialUser->getAvatar(),
                        'role' => 'student',
                        'is_blocked' => false,
                        'password' => null, // Password is null for social signups
                        'phone' => null, // Phone is nullable now
                        'provider_name' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'provider_token' => $socialUser->token,
                    ]);
                }
            } else {
                // Update their access token just in case
                $user->update([
                    'provider_token' => $socialUser->token,
                ]);
            }

            // Check if the user is blocked
            if ($user->is_blocked) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account has been suspended. Please contact support.'
                ], 403);
            }

            // Generate Sanctum Access Token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully authenticated with ' . ucfirst($provider),
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'image' => $user->image ? (Str::startsWith($user->image, ['http://', 'https://']) ? $user->image : asset('storage/' . $user->image)) : null,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
