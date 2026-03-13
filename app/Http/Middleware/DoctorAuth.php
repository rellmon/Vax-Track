<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class DoctorAuth {
    public function handle(Request $request, Closure $next) {
        if (!session('doctor_id')) {
            return redirect()->route('login')->withErrors(['login' => 'Please login as doctor.']);
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
                'user_id' => session('doctor_id'),
                'user_type' => 'doctor',
                'old_ip' => $sessionIp,
                'new_ip' => $currentIp,
            ]);
        }

        return $next($request);
    }
}
