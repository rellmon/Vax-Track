<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Schedule;
use App\Models\VaccineRecord;
use App\Models\Vaccine;
use App\Models\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController
{
    /**
     * Advanced analytics dashboard
     */
    public function dashboard(Request $request)
    {
        $from = $request->query('from', now()->subMonths(6)->format('Y-m-d'));
        $to = $request->query('to', now()->format('Y-m-d'));

        // Revenue analytics
        $revenueChartData = $this->getRevenueChartData($from, $to);
        $vaccinePopularityData = $this->getVaccinePopularityData($from, $to);
        $appointmentTrends = $this->getAppointmentTrends($from, $to);
        $ageGroupAnalytics = $this->getAgeGroupAnalytics();

        return view('admin.analytics.dashboard', [
            'from' => $from,
            'to' => $to,
            'revenueChartData' => $revenueChartData,
            'vaccinePopularityData' => $vaccinePopularityData,
            'appointmentTrends' => $appointmentTrends,
            'ageGroupAnalytics' => $ageGroupAnalytics,
        ]);
    }

    /**
     * Get revenue trend data for chart
     */
    private function getRevenueChartData($from, $to)
    {
        $payments = Payment::whereBetween('payment_date', [$from, $to])
            ->where('status', 'Paid')
            ->selectRaw("strftime('%Y-%m-%d', payment_date) as date, SUM(amount) as revenue")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $payments->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray(),
            'data' => $payments->pluck('revenue')->toArray(),
        ];
    }

    /**
     * Get vaccine popularity
     */
    private function getVaccinePopularityData($from, $to)
    {
        $vaccines = VaccineRecord::whereBetween('date_given', [$from, $to])
            ->selectRaw('vaccine_id, COUNT(*) as count')
            ->groupBy('vaccine_id')
            ->with('vaccine')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return [
            'labels' => $vaccines->map(fn($v) => $v->vaccine->name)->toArray(),
            'data' => $vaccines->pluck('count')->toArray(),
        ];
    }

    /**
     * Get appointment trends
     */
    private function getAppointmentTrends($from, $to)
    {
        $appointments = Schedule::whereBetween('appointment_date', [$from, $to])
            ->selectRaw("strftime('%Y-%m-%d', appointment_date) as date, status, COUNT(*) as count")
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();

        $dates = $appointments->pluck('date')->unique()->sort()->values();
        $scheduled = [];
        $completed = [];
        $cancelled = [];

        foreach ($dates as $date) {
            $dayData = $appointments->where('date', $date);
            $scheduled[] = $dayData->where('status', 'Scheduled')->sum('count');
            $completed[] = $dayData->where('status', 'Completed')->sum('count');
            $cancelled[] = $dayData->where('status', 'Cancelled')->sum('count');
        }

        return [
            'labels' => $dates->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray(),
            'scheduled' => $scheduled,
            'completed' => $completed,
            'cancelled' => $cancelled,
        ];
    }

    /**
     * Get age group analytics
     */
    private function getAgeGroupAnalytics()
    {
        $children = Child::all();
        
        $age0_6m = 0;
        $age6m_1y = 0;
        $age1_2y = 0;
        $age2_5y = 0;
        $age5plus = 0;

        foreach ($children as $child) {
            $age = $child->dob ? now()->diffInMonths($child->dob) : 0;
            
            if ($age <= 6) $age0_6m++;
            elseif ($age <= 12) $age6m_1y++;
            elseif ($age <= 24) $age1_2y++;
            elseif ($age <= 60) $age2_5y++;
            else $age5plus++;
        }

        return [
            'labels' => ['0-6 months', '6-12 months', '1-2 years', '2-5 years', '5+ years'],
            'data' => [$age0_6m, $age6m_1y, $age1_2y, $age2_5y, $age5plus],
        ];
    }

    /**
     * API: Get chart data
     */
    public function chartData(Request $request)
    {
        $type = $request->query('type', 'revenue');
        $from = $request->query('from', now()->subMonths(6)->format('Y-m-d'));
        $to = $request->query('to', now()->format('Y-m-d'));

        $data = match($type) {
            'revenue' => $this->getRevenueChartData($from, $to),
            'vaccines' => $this->getVaccinePopularityData($from, $to),
            'appointments' => $this->getAppointmentTrends($from, $to),
            default => [],
        };

        return response()->json($data);
    }
}
