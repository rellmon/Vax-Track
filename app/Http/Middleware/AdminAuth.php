<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in via session
        if (!Session::has('doctor_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user = User::find(Session::get('doctor_id'));

        // Verify user exists and has appropriate role
        if (!$user || !in_array($user->role, ['Admin', 'Doctor'])) {
            Session::flush();
            return redirect('/login')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
