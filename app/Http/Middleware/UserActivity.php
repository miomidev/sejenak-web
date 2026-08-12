<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = null;

        if (Auth::guard('api')->check()) {
            $userId = Auth::guard('api')->id();
        } elseif (Auth::check()) {
            $userId = Auth::id();
        }

        if ($userId) {
            $expiresAt = now()->addMinutes(2); // Keep online for 2 minutes
            Cache::put('user-is-online-' . $userId, true, $expiresAt);
        }

        return $next($request);
    }
}
