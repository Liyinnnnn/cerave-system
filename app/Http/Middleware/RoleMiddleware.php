<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|string[]  $roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            // If requesting API or expecting JSON, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'code' => 'ERR_UNAUTHENTICATED',
                    'message' => 'Authentication required.',
                ], 401);
            }
            // Otherwise redirect to login
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if (!in_array($request->user()->role, $roles, true)) {
            // If requesting API or expecting JSON, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'code' => 'ERR_UNAUTHORIZED',
                    'message' => 'Your role does not have permission to access this resource.',
                ], 403);
            }
            // Otherwise redirect to dashboard with error
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
