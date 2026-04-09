<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use App\Models\Vaccine;
use App\Models\AuditLog;
use App\Models\Schedule;
use App\Models\Child;
use App\Models\VaccineRecord;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display main admin dashboard
     */
    public function index()
    {
        // KPIs
        $totalChildren = Child::count();
        $activeStaff = User::where('active', true)->count();
        $upcomingAppointments = Schedule::whereDate('appointment_date', '>=', today())
            ->whereDate('appointment_date', '<=', today()->addDays(7))
            ->count();
        $vaccinesCoveragePercent = $this->getVaccinationCoverage();
        $monthlyRevenue = Payment::where('status', 'Paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
        $pendingPaymentsAmount = Payment::where('status', 'Pending')->sum('amount');

        // Today's Summary
        $todaySummary = [
            'appointments' => Schedule::whereDate('appointment_date', today())->count(),
            'completed_appointments' => Schedule::where('status', 'Completed')
                ->whereDate('appointment_date', today())
                ->count(),
            'payments_received' => Payment::where('status', 'Paid')
                ->whereDate('payment_date', today())
                ->sum('amount'),
            'new_registrations' => Child::whereDate('created_at', today())->count(),
        ];

        // Alerts - Low Stock Vaccines
        $lowStockVaccines = Vaccine::where('active', true)
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Alerts - Overdue Vaccinations
        $overdueVaccinations = Schedule::where('status', '!=', 'Completed')
            ->whereDate('appointment_date', '<', today())
            ->with('child')
            ->limit(5)
            ->get();

        // Alerts - Pending Payments
        $pendingPayments = Payment::where('status', 'Pending')
            ->with('child')
            ->latest('payment_date')
            ->limit(5)
            ->get();

        // Charts Data - Vaccination Coverage by Age Group
        $coverageByAge = $this->getVaccinationCoverageByAge();

        // Charts Data - Top Vaccines This Month
        $topVaccines = $this->getTopVaccinesThisMonth();

        // Recent Appointments
        $recentAppointments = Schedule::with(['child', 'vaccine'])
            ->latest('appointment_date')
            ->limit(8)
            ->get();

        // Recent Payments
        $recentPayments = Payment::with('child')
            ->latest('payment_date')
            ->limit(8)
            ->get();

        // New Children Registrations
        $newChildren = Child::latest('created_at')
            ->limit(5)
            ->get();

        // Recent Audit Logs
        $recentActivities = AuditLog::latest('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalChildren',
            'activeStaff',
            'upcomingAppointments',
            'vaccinesCoveragePercent',
            'monthlyRevenue',
            'pendingPaymentsAmount',
            'todaySummary',
            'lowStockVaccines',
            'overdueVaccinations',
            'pendingPayments',
            'coverageByAge',
            'topVaccines',
            'recentAppointments',
            'recentPayments',
            'newChildren',
            'recentActivities'
        ));
    }

    /**
     * Calculate overall vaccination coverage percentage
     */
    private function getVaccinationCoverage()
    {
        $totalChildren = Child::count();
        if ($totalChildren === 0) return 0;

        // Simple calculation: children with at least one vaccine record
        $vaccinatedChildren = Child::whereHas('vaccineRecords')->count();
        
        return round(($vaccinatedChildren / $totalChildren) * 100, 1);
    }

    /**
     * Get vaccination coverage by age group
     */
    private function getVaccinationCoverageByAge()
    {
        $ageGroups = [
            '0-6 months' => ['min' => 0, 'max' => 6],
            '6-12 months' => ['min' => 6, 'max' => 12],
            '1-2 years' => ['min' => 12, 'max' => 24],
            '2-5 years' => ['min' => 24, 'max' => 60],
        ];

        $data = [];
        foreach ($ageGroups as $label => $range) {
            $minDate = now()->subMonths($range['max']);
            $maxDate = now()->subMonths($range['min']);
            
            $total = Child::whereBetween('dob', [$minDate, $maxDate])->count();
            $vaccinated = Child::whereBetween('dob', [$minDate, $maxDate])
                ->whereHas('vaccineRecords')
                ->count();
            
            $data[] = [
                'label' => $label,
                'total' => $total,
                'vaccinated' => $total > 0 ? round(($vaccinated / $total) * 100, 1) : 0,
            ];
        }

        return $data;
    }

    /**
     * Get top vaccines administered this month
     */
    private function getTopVaccinesThisMonth()
    {
        return VaccineRecord::whereMonth('date_given', now()->month)
            ->whereYear('date_given', now()->year)
            ->selectRaw('vaccine_id, COUNT(*) as count')
            ->groupBy('vaccine_id')
            ->with('vaccine')
            ->orderBy('count', 'DESC')
            ->limit(5)
            ->get();
    }
}
