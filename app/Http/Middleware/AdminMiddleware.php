<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for admin role verification.
 * Restricts access to admin-only routes.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming request.
     * @param Closure $next The next middleware in the chain.
     * @return Response The response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
