<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('sanctum')->check() && auth('sanctum')->user()->is_blocked) {
            auth('sanctum')->user()->tokens()->delete();
            return response()->json([
                'status' => 'error',
                'message' => 'Your account has been blocked. You have been logged out.'
            ], 403);
        }

        return $next($request);
    }
}
