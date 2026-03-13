<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Vaccine;
use App\Models\Schedule;
use App\Models\Payment;
use App\Models\VaccineRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorController extends Controller
{
    public function dashboard(Request $request)
    {
        // Core metrics
        $totalChildren = Child::count();
        $availableVaccines = Vaccine::where('active', true)->count();
        $pendingSchedules = Schedule::where('status', 'Scheduled')->count();
        $completedToday = Schedule::where('status', 'Completed')
            ->whereDate('appointment_date', today())
            ->count();

        // Widget 1: Upcoming appointments today
        $todayAppointments = Schedule::with(['child', 'vaccine', 'child.parent'])
            ->where('status', 'Scheduled')
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        // Widget 2: Next 5 upcoming schedules
        $upcomingSchedules = Schedule::with(['child', 'vaccine'])
            ->where('status', 'Scheduled')
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();

        // Widget 3: Recent vaccine records (last 10)
        $recentVaccineRecords = VaccineRecord::with(['child', 'vaccine'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Widget 4: This week's appointments
        $thisWeekAppointments = Schedule::with(['child', 'vaccine'])
            ->where('status', 'Scheduled')
            ->whereBetween('appointment_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->count();

        // Widget 5: Pending vaccine approvals (if applicable)
        $pendingApprovals = Child::whereNull('approved_at')
            ->count();

        // Widget 6: Payment statistics
        $pendingPayments = Payment::where('status', '!=', 'Completed')->count();
        $totalPendingAmount = Payment::where('status', '!=', 'Completed')
            ->sum('amount');

        // Widget 7: Vaccine stock alerts
        $lowStockVaccines = Vaccine::where('active', true)
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Calendar events
        $calendarEvents = Schedule::selectRaw('appointment_date, count(*) as count')
            ->where('status', '!=', 'Cancelled')
            ->groupBy('appointment_date')
            ->get()
            ->keyBy('appointment_date');

        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        return view('doctor.dashboard', compact(
            'totalChildren', 'availableVaccines', 'pendingSchedules',
            'completedToday', 'upcomingSchedules', 'calendarEvents', 'month', 'year',
            'todayAppointments', 'recentVaccineRecords', 'thisWeekAppointments',
            'pendingApprovals', 'pendingPayments', 'totalPendingAmount', 'lowStockVaccines'
        ));
    }
}
