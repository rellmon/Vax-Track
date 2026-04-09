<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\Schedule;
use App\Models\VaccineRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display staff/doctor accounts list
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->withCount('schedules', 'vaccineRecords', 'auditLogs')
            ->latest('created_at')
            ->paginate(20);

        // Get roles
        $roles = User::distinct('role')->pluck('role');

        // Get stats
        $stats = [
            'total_staff' => User::count(),
            'active_staff' => User::where('email', '!=', null)->count(),
        ];

        return view('admin.staff.index', compact('users', 'roles', 'stats'));
    }

    /**
     * Show create staff form
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store new staff member
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Doctor,Staff,Admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.staff.show', $user)->with('success', 'Staff member created successfully');
    }

    /**
     * Show staff details
     */
    public function show(User $user)
    {
        // Performance metrics
        $metrics = [
            'total_schedules' => Schedule::where('created_by_user_id', $user->id)->count(),
            'completed_schedules' => Schedule::where('created_by_user_id', $user->id)->where('status', 'Completed')->count(),
            'cancelled_schedules' => Schedule::where('created_by_user_id', $user->id)->where('status', 'Cancelled')->count(),
            'total_vaccines_given' => VaccineRecord::where('user_id', $user->id)->count(),
            'active_schedules' => Schedule::where('created_by_user_id', $user->id)->where('status', 'Scheduled')->count(),
        ];

        // Recent activity
        $recentActivity = AuditLog::where('user_id', $user->id)
            ->latest('created_at')
            ->limit(50)
            ->get();

        // Recent vaccine records
        $recentVaccines = VaccineRecord::where('user_id', $user->id)
            ->with(['child', 'vaccine'])
            ->latest('created_at')
            ->limit(20)
            ->get();

        return view('admin.staff.show', compact('user', 'metrics', 'recentActivity', 'recentVaccines'));
    }

    /**
     * Show edit staff form
     */
    public function edit(User $user)
    {
        return view('admin.staff.edit', compact('user'));
    }

    /**
     * Update staff member
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:Doctor,Staff,Admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Staff member updated successfully');
    }

    /**
     * Reset staff password
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password reset successfully');
    }

    /**
     * Deactivate staff account
     */
    public function deactivate(User $user)
    {
        $user->update(['active' => false]);

        return back()->with('success', 'Staff account deactivated.');
    }

    /**
     * Reactivate staff account
     */
    public function reactivate(Request $request, User $user)
    {
        $user->update(['active' => true]);

        return back()->with('success', 'Staff account reactivated.');
    }

    /**
     * Get staff performance report
     */
    public function performanceReport(Request $request)
    {
        $from = $request->from_date ? \Carbon\Carbon::parse($request->from_date) : now()->subDays(30);
        $to = $request->to_date ? \Carbon\Carbon::parse($request->to_date) : now();

        $staff = User::selectRaw(
            'users.*,
            COUNT(DISTINCT schedules.id) as total_schedules,
            COUNT(DISTINCT vaccine_records.id) as total_vaccines'
        )
        ->leftJoin('schedules', 'users.id', '=', 'schedules.created_by_user_id')
        ->leftJoin('vaccine_records', 'users.id', '=', 'vaccine_records.user_id')
        ->whereBetween('schedules.created_at', [$from, $to])
        ->groupBy('users.id')
        ->get();

        $csvHeader = "Staff Name,Username,Role,Total Schedules,Total Vaccines,Email\n";
        $csvData = '';

        foreach ($staff as $s) {
            $csvData .= "\"{$s->name}\",\"{$s->username}\",\"{$s->role}\",\"{$s->total_schedules}\",\"{$s->total_vaccines}\",\"{$s->email}\"\n";
        }

        return response()
            ->streamDownload(
                function () use ($csvHeader, $csvData) {
                    echo $csvHeader . $csvData;
                },
                'staff-performance-' . now()->format('Y-m-d-His') . '.csv'
            );
    }

    /**
     * Get staff summary API
     */
    public function summary()
    {
        return response()->json([
            'total_staff' => User::count(),
            'total_doctors' => User::where('role', 'Doctor')->count(),
            'total_staff_members' => User::where('role', 'Staff')->count(),
            'total_admins' => User::where('role', 'Admin')->count(),
        ]);
    }
}
