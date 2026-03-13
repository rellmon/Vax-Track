<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Child;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use App\Models\SmsLog;
use App\Services\PhilSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    protected $philSmsService;

    public function __construct(PhilSmsService $philSmsService)
    {
        $this->philSmsService = $philSmsService;
    }

    public function index(Request $request)
    {
        $query = Schedule::with(['child', 'vaccine']);
        if ($request->search) {
            $query->whereHas('child', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }
        $schedules = $query->latest('appointment_date')->get();
        $children  = Child::all();
        $vaccines  = Vaccine::where('active', true)->get();
        $smsLogs   = SmsLog::latest()->limit(15)->get();

        return view('doctor.schedules', compact('schedules', 'children', 'vaccines', 'smsLogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'child_id'         => 'required|exists:children,id',
            'vaccine_id'       => 'required|exists:vaccines,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        $schedule = Schedule::create([
            'child_id'         => $request->child_id,
            'vaccine_id'       => $request->vaccine_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => 'Scheduled',
            'notes'            => $request->notes,
            'sms_sent'         => false,
        ]);

        $child   = Child::find($request->child_id);
        $vaccine = Vaccine::find($request->vaccine_id);
        $parent  = $child?->parent;

        if ($parent && $parent->phone) {
            // FIX: Use plain ASCII hyphen instead of em-dash (—)
            // PhilSMS rejects messages containing non-ASCII/UTF-8 special characters
            $message = "Reminder: {$child->first_name} {$child->last_name}'s {$vaccine->name} appointment is on "
                . \Carbon\Carbon::parse($request->appointment_date)->format('F j, Y')
                . " at {$request->appointment_time}. - VaccTrack Clinic";

            $this->philSmsService->queueSms($parent->phone, $message, [
                'type'        => 'appointment_reminder',
                'child_id'    => $child->id,
                'schedule_id' => $schedule->id,
            ]);

            $schedule->update(['sms_sent' => true]);
        }

        return redirect()->route('doctor.schedules')->with('success', 'Schedule created and SMS reminder sent.');
    }

    public function updateStatus(Request $request, Schedule $schedule)
    {
        $request->validate(['status' => 'required|in:Scheduled,Completed,Cancelled']);
        $schedule->update(['status' => $request->status]);

        if ($request->status === 'Completed') {
            $exists = VaccineRecord::where('child_id', $schedule->child_id)
                ->where('vaccine_id', $schedule->vaccine_id)
                ->where('date_given', $schedule->appointment_date)
                ->exists();

            if (!$exists) {
                VaccineRecord::create([
                    'child_id'        => $schedule->child_id,
                    'vaccine_id'      => $schedule->vaccine_id,
                    'date_given'      => $schedule->appointment_date,
                    'dose_number'     => 1,
                    'notes'           => $schedule->notes,
                    'administered_by' => session('doctor_name', 'Dr. Admin'),
                ]);
                $vaccine = $schedule->vaccine;
                if ($vaccine && $vaccine->stock > 0) $vaccine->decrement('stock');
            }
        }

        return redirect()->route('doctor.schedules')->with('success', 'Status updated.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('doctor.schedules')->with('success', 'Schedule deleted.');
    }

    public function sendSms(Schedule $schedule)
    {
        $child   = $schedule->child;
        $vaccine = $schedule->vaccine;
        $parent  = $child?->parent;

        if (!$parent || !$parent->phone) {
            return redirect()->route('doctor.schedules')->with('error', 'No parent phone number linked to this child.');
        }

        // FIX: Use plain ASCII hyphen instead of em-dash (—)
        // PhilSMS rejects messages containing non-ASCII/UTF-8 special characters
        $message = "Reminder: {$child->first_name} {$child->last_name}'s {$vaccine->name} appointment is on "
            . \Carbon\Carbon::parse($schedule->appointment_date)->format('F j, Y')
            . " at {$schedule->appointment_time}. - VaccTrack Clinic";

        $this->philSmsService->queueSms($parent->phone, $message, [
            'type'        => 'manual_reminder',
            'child_id'    => $child->id,
            'schedule_id' => $schedule->id,
        ]);

        $schedule->update(['sms_sent' => true]);

        return redirect()->route('doctor.schedules')->with('success', "SMS reminder queued for {$parent->phone}.");
    }

    public function clearSmsLogs()
    {
        SmsLog::truncate();
        return redirect()->route('doctor.schedules')->with('success', 'SMS log cleared.');
    }
}