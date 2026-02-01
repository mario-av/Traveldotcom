<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for advanced role verification.
 * Restricts access to advanced and admin users.
 */
class AdvancedMiddleware
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
        if (!auth()->check() || !auth()->user()->isAdvanced()) {
            abort(403, 'Unauthorized. Advanced access required.');
        }

        return $next($request);
    }
}
