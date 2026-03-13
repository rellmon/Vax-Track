<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ParentGuardian;
use App\Models\SmsOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('doctor_id')) return redirect()->route('doctor.dashboard');
        if (Session::has('parent_id')) return redirect()->route('parent.dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:doctor,parent',
        ]);

        if ($request->role === 'doctor') {
            $user = User::where('username', $request->username)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                Session::put('doctor_id', $user->id);
                Session::put('doctor_name', $user->name);
                Session::put('session_ip', $request->ip());
                Session::put('last_activity', now());
                return redirect()->route('doctor.dashboard');
            }
            return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
        }

        if ($request->role === 'parent') {
            $parent = ParentGuardian::where('username', $request->username)->first();
            if ($parent && Hash::check($request->password, $parent->password)) {
                Session::put('parent_id', $parent->id);
                Session::put('parent_name', $parent->first_name . ' ' . $parent->last_name);
                Session::put('session_ip', $request->ip());
                Session::put('last_activity', now());
                return redirect()->route('parent.dashboard');
            }
            return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
        }

        return back()->withErrors(['login' => 'Invalid role.']);
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:doctor,parent',
        ]);

        if ($request->role === 'doctor') {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['email' => 'Doctor account not found with this email address.'])->withInput();
            }
            SmsOtp::generateAndSend($request->email, 'doctor', $user->id, 'password_reset');
        } else {
            $parent = ParentGuardian::where('email', $request->email)->first();
            if (!$parent) {
                return back()->withErrors(['email' => 'Parent account not found with this email address.'])->withInput();
            }
            SmsOtp::generateAndSend($request->email, 'parent', $parent->id, 'password_reset');
        }

        return redirect()->route('auth.verify-otp')
            ->with('success', 'OTP sent to your email. Check your inbox or spam folder.')
            ->with('email', $request->email)
            ->with('role', $request->role);
    }

    public function showVerifyOtp()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
            'role' => 'required|in:doctor,parent',
        ]);

        $smsOtp = SmsOtp::where('email', $request->email)
            ->where('user_type', $request->role)
            ->where('purpose', 'password_reset')
            ->where('used', false)
            ->first();

        if (!$smsOtp || !$smsOtp->verify($request->otp_code)) {
            return back()->withErrors(['otp_code' => 'Invalid or expired OTP code.'])->withInput();
        }

        Session::put('reset_email', $request->email);
        Session::put('reset_role', $request->role);
        Session::put('reset_user_id', $smsOtp->user_id);

        return redirect()->route('auth.reset-password')
            ->with('success', 'OTP verified. Please set your new password.');
    }

    public function showResetPassword()
    {
        if (!Session::has('reset_email')) {
            return redirect()->route('auth.forgot-password')
                ->withErrors(['error' => 'Please complete the OTP verification first.']);
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!Session::has('reset_email')) {
            return redirect()->route('auth.forgot-password')
                ->withErrors(['error' => 'Session expired. Please try again.']);
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $role = Session::get('reset_role');
        $userId = Session::get('reset_user_id');

        if ($role === 'doctor') {
            $user = User::find($userId);
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            $parent = ParentGuardian::find($userId);
            $parent->password = Hash::make($request->password);
            $parent->save();
        }

        Session::forget(['reset_email', 'reset_role', 'reset_user_id']);

        return redirect()->route('login')
            ->with('success', 'Password reset successful. Please login with your new password.');
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect()->route('login');
    }
}
