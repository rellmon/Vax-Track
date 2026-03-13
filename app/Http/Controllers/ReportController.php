<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_children'      => Child::count(),
            'total_vaccinations'  => VaccineRecord::count(),
            'total_revenue'       => Payment::where('status', 'Paid')->sum('amount'),
            'active_vaccines'     => Vaccine::where('active', true)->count(),
        ];
        $children = Child::all();
        return view('doctor.reports', compact('stats', 'children'));
    }

    public function generate(Request $request)
    {
        $type  = $request->type ?? 'vaccination';
        $from  = $request->from ?? now()->subDays(30)->format('Y-m-d');
        $to    = $request->to   ?? now()->format('Y-m-d');
        $child_id = $request->child_id ?? null;

        $data = [];
        if ($type === 'vaccination') {
            $data = VaccineRecord::with(['child', 'vaccine'])
                ->whereBetween('date_given', [$from, $to])
                ->latest('date_given')->get();
        } elseif ($type === 'inventory') {
            $data = Vaccine::all();
        } elseif ($type === 'financial') {
            $data = Payment::with(['child', 'schedule.vaccine'])
                ->whereBetween('payment_date', [$from, $to])
                ->latest('payment_date')->get();
        } elseif ($type === 'children') {
            $query = Child::with('parent');
            if ($child_id) {
                $query = $query->where('id', $child_id);
            }
            $data = $query->latest()->get();
        }

        $stats = [
            'total_children'     => Child::count(),
            'total_vaccinations' => VaccineRecord::count(),
            'total_revenue'      => Payment::where('status', 'Paid')->sum('amount'),
            'active_vaccines'    => Vaccine::where('active', true)->count(),
        ];
        $children = Child::all();

        return view('doctor.reports', compact('type', 'from', 'to', 'data', 'stats', 'child_id', 'children'));
    }

    public function print(Request $request)
    {
        $type = $request->type ?? 'vaccination';
        $from = $request->from ?? now()->subDays(30)->format('Y-m-d');
        $to   = $request->to   ?? now()->format('Y-m-d');
        $child_id = $request->child_id ?? null;

        $data = [];
        if ($type === 'vaccination') {
            $data = VaccineRecord::with(['child', 'vaccine'])
                ->whereBetween('date_given', [$from, $to])
                ->latest('date_given')->get();
        } elseif ($type === 'inventory') {
            $data = Vaccine::all();
        } elseif ($type === 'financial') {
            $data = Payment::with(['child', 'schedule.vaccine'])
                ->whereBetween('payment_date', [$from, $to])
                ->latest('payment_date')->get();
        } elseif ($type === 'children') {
            $query = Child::with('parent');
            if ($child_id) {
                $query = $query->where('id', $child_id);
            }
            $data = $query->latest()->get();
        }

        return view('doctor.reports-print', compact('type', 'from', 'to', 'data', 'child_id'));
    }

    public function download(Request $request)
    {
        $type = $request->type ?? 'vaccination';
        $from = $request->from ?? now()->subDays(30)->format('Y-m-d');
        $to   = $request->to   ?? now()->format('Y-m-d');
        $child_id = $request->child_id ?? null;

        $data = [];
        if ($type === 'vaccination') {
            $data = VaccineRecord::with(['child', 'vaccine'])
                ->whereBetween('date_given', [$from, $to])
                ->latest('date_given')->get();
        } elseif ($type === 'inventory') {
            $data = Vaccine::all();
        } elseif ($type === 'financial') {
            $data = Payment::with(['child', 'schedule.vaccine'])
                ->whereBetween('payment_date', [$from, $to])
                ->latest('payment_date')->get();
        } elseif ($type === 'children') {
            $query = Child::with('parent');
            if ($child_id) {
                $query = $query->where('id', $child_id);
            }
            $data = $query->latest()->get();
        }

        $typeLabels = [
            'vaccination' => 'Vaccination Summary',
            'inventory' => 'Vaccine Inventory',
            'financial' => 'Financial Summary',
            'children' => 'Children Registry'
        ];
        
        $fileName = 'report-' . $type . '-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        $pdf = PDF::loadView('doctor.reports-print', compact('type', 'from', 'to', 'data', 'child_id'));
        
        return $pdf->download($fileName);
    }
}
