<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Schedule;
use App\Models\VaccineRecord;
use App\Models\Payment;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    private function getChildren()
    {
        return Child::where('parent_id', session('parent_id'))->get();
    }

    public function dashboard()
    {
        $children = $this->getChildren()->load(['vaccineRecords', 'schedules.vaccine']);
        return view('parent.dashboard', compact('children'));
    }

    public function schedules()
    {
        $childIds  = $this->getChildren()->pluck('id');
        $schedules = Schedule::with(['child', 'vaccine'])
            ->whereIn('child_id', $childIds)
            ->latest('appointment_date')
            ->get();
        return view('parent.schedules', compact('schedules'));
    }

    public function records()
    {
        $children = $this->getChildren();
        $childIds = $children->pluck('id');
        $records  = VaccineRecord::with(['child', 'vaccine'])
            ->whereIn('child_id', $childIds)
            ->latest('date_given')
            ->get();
        return view('parent.records', compact('records', 'children'));
    }

    public function payments()
    {
        $childIds     = $this->getChildren()->pluck('id');
        $payments     = Payment::with(['child', 'schedule.vaccine'])
            ->whereIn('child_id', $childIds)
            ->latest('payment_date')
            ->get();
        $totalPaid    = $payments->where('status', 'Paid')->sum('amount');
        return view('parent.payments', compact('payments', 'totalPaid'));
    }

    public function printRecords(Request $request)
    {
        $request->validate([
            'type'     => 'required|in:all,specific',
            'child_id' => 'nullable|exists:children,id|integer',
        ]);

        $children = $this->getChildren();
        $childIds = $children->pluck('id');

        // Verify requested child belongs to this parent
        if ($request->type === 'specific' && $request->child_id) {
            if (!$childIds->contains($request->child_id)) {
                abort(403, 'Unauthorized access');
            }
            $childIds = collect([$request->child_id]);
        }

        $records = VaccineRecord::with(['child', 'vaccine'])
            ->whereIn('child_id', $childIds)
            ->latest('date_given')
            ->get();

        $parentName = session('parent_name', 'Parent');
        $title = $request->type === 'specific' 
            ? 'Vaccination Records — ' . ($records->first()?->child?->full_name ?? 'Child')
            : 'All Children Vaccination Records';

        return view('parent.records-print', compact('records', 'parentName', 'title'));
    }
}