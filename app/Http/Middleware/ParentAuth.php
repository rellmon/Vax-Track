<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class ParentAuth {
    public function handle(Request $request, Closure $next) {
        if (!session('parent_id')) {
            return redirect()->route('login')->withErrors(['login' => 'Please login as parent.']);
        }

        // Check session timeout (1 hour of inactivity)
        $lastActivity = session('last_activity');
        if ($lastActivity && now()->subHours(1) > $lastActivity) {
            session()->flush();
            return redirect()->route('login')->withErrors(['login' => 'Session expired. Please login again.']);
        }

        // Update last activity
        session(['last_activity' => now()]);

        // Check IP consistency
        $sessionIp = session('session_ip');
        $currentIp = $request->ip();
        if ($sessionIp && $sessionIp !== $currentIp) {
            \Illuminate\Support\Facades\Log::warning('Session IP change detected', [
                'user_id' => session('parent_id'),
                'user_type' => 'parent',
                'old_ip' => $sessionIp,
                'new_ip' => $currentIp,
            ]);
            // Log but don't force logout for mobile users who may change networks
        }

        return $next($request);
    }
}
