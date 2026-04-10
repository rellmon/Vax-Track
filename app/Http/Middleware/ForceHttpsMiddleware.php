<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS in production environments
        // Check X-Forwarded-Proto header for proxied requests (Railway, Heroku, etc.)
        if (config('app.env') === 'production') {
            if (!$request->secure() && $request->header('X-Forwarded-Proto') !== 'https') {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}
