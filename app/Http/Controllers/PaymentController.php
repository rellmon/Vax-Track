<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Child;
use App\Models\Schedule;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments     = Payment::with(['child', 'schedule.vaccine'])->latest('payment_date')->get();
        $unpaidSchedules = Schedule::with(['child', 'vaccine'])
            ->where('status', '!=', 'Cancelled')
            ->whereDoesntHave('payment')
            ->get();
        $totalRevenue = Payment::where('status', 'Paid')->sum('amount');
        $pendingPayments = Payment::where('status', 'Pending')->sum('amount');
        $pendingSchedules = Schedule::where('status', 'Scheduled')
            ->whereDoesntHave('payment')
            ->with('vaccine')
            ->get()
            ->sum(fn($s) => $s->vaccine?->price ?? 0);
        $pendingTotal = $pendingPayments + $pendingSchedules;
        $todayRevenue = Payment::where('status', 'Paid')->whereDate('payment_date', today())->sum('amount');

        return view('doctor.payments', compact(
            'payments', 'unpaidSchedules', 'totalRevenue', 'pendingTotal', 'todayRevenue'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id'  => 'required|exists:schedules,id',
            'amount'       => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status'       => 'required|in:Paid,Pending',
        ]);

        $schedule = Schedule::find($request->schedule_id);
        Payment::create([
            'child_id'     => $schedule->child_id,
            'schedule_id'  => $request->schedule_id,
            'amount'       => $request->amount,
            'method'       => 'Cash',
            'status'       => $request->status,
            'payment_date' => $request->payment_date,
            'notes'        => $request->notes,
        ]);

        return redirect()->route('doctor.payments')->with('success', 'Payment processed successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['child', 'schedule.vaccine', 'child.parent']);
        return view('doctor.payments-show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate(['status' => 'required|in:Paid,Pending']);
        $payment->update(['status' => $request->status]);
        return redirect()->route('doctor.payments')->with('success', 'Payment status updated.');
    }

    public function invoice(Payment $payment)
    {
        $payment->load(['child', 'schedule.vaccine', 'child.parent']);
        return view('doctor.payments-invoice', compact('payment'));
    }

    public function printReport()
    {
        $payments     = Payment::with(['child', 'schedule.vaccine'])->latest('payment_date')->get();
        $totalRevenue = $payments->where('status', 'Paid')->sum('amount');
        return view('doctor.payments-report', compact('payments', 'totalRevenue'));
    }
}
