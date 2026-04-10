<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialController extends Controller
{
    /**
     * Display financial dashboard
     */
    public function dashboard(Request $request)
    {
        $from = $request->from_date ? Carbon::parse($request->from_date) : now()->subDays(30);
        $to = $request->to_date ? Carbon::parse($request->to_date) : now();

        // Core KPIs
        $stats = [
            'total_revenue' => Payment::where('status', 'Paid')
                ->whereBetween('payment_date', [$from, $to])
                ->sum('amount'),
            'pending_amount' => Payment::where('status', 'Pending')
                ->whereBetween('payment_date', [$from, $to])
                ->sum('amount'),
            'unpaid_amount' => Payment::where('status', 'Unpaid')
                ->whereBetween('payment_date', [$from, $to])
                ->sum('amount'),
            'total_transactions' => Payment::where('status', 'Paid')
                ->whereBetween('payment_date', [$from, $to])
                ->count(),
            'refunded_amount' => Payment::where('status', 'Refunded')
                ->whereBetween('payment_date', [$from, $to])
                ->sum('amount'),
        ];

        // Outstanding payments
        $outstandingPayments = Payment::with(['child', 'schedule'])
            ->where('status', '!=', 'Paid')
            ->orderBy('payment_date')
            ->limit(20)
            ->get();

        // Daily revenue breakdown
        $dateFormat = DB::connection()->getDriverName() === 'mysql' 
            ? "DATE_FORMAT(payment_date, '%Y-%m-%d')" 
            : "strftime('%Y-%m-%d', payment_date)";
        
        $dailyRevenue = Payment::selectRaw("$dateFormat as date, COUNT(*) as count, SUM(amount) as revenue")
            ->where('status', 'Paid')
            ->whereBetween('payment_date', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by vaccine
        $vaccineRevenue = Payment::join('schedules', 'payments.schedule_id', '=', 'schedules.id')
            ->join('vaccines', 'schedules.vaccine_id', '=', 'vaccines.id')
            ->selectRaw('vaccines.name, COUNT(*) as count, SUM(payments.amount) as revenue')
            ->where('payments.status', 'Paid')
            ->whereBetween('payments.payment_date', [$from, $to])
            ->groupBy('vaccines.id', 'vaccines.name')
            ->orderByRaw('SUM(payments.amount) DESC')
            ->get();

        // Payment status breakdown
        $paymentStatus = Payment::selectRaw('status, COUNT(*) as count, SUM(amount) as amount')
            ->whereBetween('payment_date', [$from, $to])
            ->groupBy('status')
            ->get();

        // Recent transactions
        $recentTransactions = Payment::with(['child', 'schedule.vaccine'])
            ->whereBetween('payment_date', [$from, $to])
            ->latest('payment_date')
            ->limit(50)
            ->paginate(20);

        // Monthly comparison (current vs previous month)
        $currentMonth = Payment::where('status', 'Paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $previousMonth = Payment::where('status', 'Paid')
            ->whereMonth('payment_date', now()->subMonth()->month)
            ->whereYear('payment_date', now()->subMonth()->year)
            ->sum('amount');

        $monthlyGrowth = $previousMonth > 0 
            ? (($currentMonth - $previousMonth) / $previousMonth) * 100 
            : 0;

        return view('admin.financial.dashboard', compact(
            'stats', 
            'outstandingPayments', 
            'dailyRevenue', 
            'vaccineRevenue',
            'paymentStatus',
            'recentTransactions',
            'currentMonth',
            'previousMonth',
            'monthlyGrowth',
            'from',
            'to'
        ));
    }

    /**
     * Show payment details
     */
    public function paymentDetails(Payment $payment)
    {
        $payment->load(['child', 'schedule.vaccine']);
        return view('admin.financial.payment-details', compact('payment'));
    }

    /**
     * Download financial report
     */
    public function downloadReport(Request $request)
    {
        $from = $request->from_date ? Carbon::parse($request->from_date) : now()->subDays(30);
        $to = $request->to_date ? Carbon::parse($request->to_date) : now();

        $payments = Payment::with(['child', 'schedule.vaccine'])
            ->whereBetween('payment_date', [$from, $to])
            ->latest('payment_date')
            ->get();

        $csvHeader = "Payment ID,Child Name,Vaccine,Amount,Status,Payment Date,Method\n";
        $csvData = '';

        foreach ($payments as $p) {
            $childName = $p->child ? $p->child->first_name . ' ' . $p->child->last_name : 'N/A';
            $vaccineName = $p->schedule && $p->schedule->vaccine ? $p->schedule->vaccine->name : 'N/A';
            $csvData .= "\"{$p->id}\",\"{$childName}\",\"{$vaccineName}\",\"{$p->amount}\",\"{$p->status}\",\"{$p->payment_date}\",\"{$p->method}\"\n";
        }

        return response()
            ->streamDownload(
                function () use ($csvHeader, $csvData) {
                    echo $csvHeader . $csvData;
                },
                'financial-report-' . now()->format('Y-m-d-His') . '.csv'
            );
    }

    /**
     * Handle payment status update
     */
    public function updatePaymentStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:Pending,Paid,Unpaid,Refunded'
        ]);

        $payment->update(['status' => $request->status]);

        return back()->with('success', 'Payment status updated successfully');
    }

    /**
     * Get financial summary API
     */
    public function summary(Request $request)
    {
        $from = $request->from_date ? Carbon::parse($request->from_date) : now()->subDays(30);
        $to = $request->to_date ? Carbon::parse($request->to_date) : now();

        $summary = [
            'total_revenue' => Payment::where('status', 'Paid')
                ->whereBetween('payment_date', [$from, $to])
                ->sum('amount'),
            'pending_amount' => Payment::where('status', 'Pending')
                ->whereBetween('payment_date', [$from, $to])
                ->sum('amount'),
            'outstanding_count' => Payment::where('status', '!=', 'Paid')
                ->whereBetween('payment_date', [$from, $to])
                ->count(),
            'average_transaction' => Payment::where('status', 'Paid')
                ->whereBetween('payment_date', [$from, $to])
                ->avg('amount'),
            'payment_methods' => Payment::selectRaw('method, COUNT(*) as count, SUM(amount) as total')
                ->where('status', 'Paid')
                ->whereBetween('payment_date', [$from, $to])
                ->groupBy('method')
                ->get(),
        ];

        return response()->json($summary);
    }
}
