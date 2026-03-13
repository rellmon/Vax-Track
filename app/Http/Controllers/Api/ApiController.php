<?php

namespace App\Http\Controllers\Api;

use App\Models\ParentGuardian;
use App\Models\Child;
use App\Models\VaccineRecord;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Mail\ParentWelcome;
use Illuminate\Support\Facades\Mail;

class ApiController extends \App\Http\Controllers\Controller
{
    /**
     * API authentication - generate token (basic implementation)
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $parent = ParentGuardian::where('email', $request->email)->first();

        if (!$parent || !Hash::check($request->password, $parent->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are invalid.'],
            ]);
        }

        // Generate simple token (in production, use Sanctum or Passport)
        $token = hash('sha256', $parent->id . $parent->email . now()->timestamp);

        return response()->json([
            'success' => true,
            'message' => 'Authentication successful',
            'data' => [
                'parent_id' => $parent->id,
                'name' => $parent->name,
                'email' => $parent->email,
                'token' => $token,
            ]
        ]);
    }

    /**
     * POST /api/parents/register - Register new parent
     */
    public function registerParent(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:parent_guardians,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $parent = ParentGuardian::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'username' => $request->email, // Use email as username
            ]);

            // Send welcome email
            try {
                Mail::to($parent->email)->send(new ParentWelcome($parent));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Welcome email failed for API registration', [
                    'parent_id' => $parent->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Parent registered successfully',
                'data' => [
                    'parent_id' => $parent->id,
                    'name' => $parent->name,
                    'email' => $parent->email,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * GET /api/children/{parent_id} - Get parent's children
     */
    public function getChildren($parentId)
    {
        $children = Child::where('parent_id', $parentId)
            ->whereNull('deleted_at')
            ->with('vaccineRecords.vaccine')
            ->get();

        if ($children->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No children found',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Children retrieved successfully',
            'data' => $children->map(function ($child) {
                return [
                    'id' => $child->id,
                    'first_name' => $child->first_name,
                    'last_name' => $child->last_name,
                    'dob' => $child->dob,
                    'gender' => $child->gender,
                    'vaccine_records_count' => $child->vaccineRecords->count(),
                ];
            }),
        ]);
    }

    /**
     * GET /api/children/{child_id}/records - Get child's vaccine records
     */
    public function getChildRecords($childId)
    {
        $child = Child::find($childId);

        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found',
            ], 404);
        }

        $records = VaccineRecord::where('child_id', $childId)
            ->with('vaccine')
            ->orderBy('date_given', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Vaccine records retrieved successfully',
            'data' => [
                'child' => [
                    'id' => $child->id,
                    'name' => $child->first_name . ' ' . $child->last_name,
                ],
                'records' => $records->map(function ($record) {
                    return [
                        'id' => $record->id,
                        'vaccine_name' => $record->vaccine->name,
                        'date_given' => $record->date_given,
                        'dose_number' => $record->dose_number,
                        'notes' => $record->notes,
                    ];
                }),
            ],
        ]);
    }

    /**
     * GET /api/appointments/{parent_id} - Get parent's child appointments
     */
    public function getAppointments($parentId)
    {
        $appointments = Schedule::with(['child', 'vaccine'])
            ->whereIn('child_id', Child::where('parent_id', $parentId)->pluck('id'))
            ->where('status', '!=', 'Cancelled')
            ->orderBy('appointment_date')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Appointments retrieved successfully',
            'data' => $appointments->map(function ($appt) {
                return [
                    'id' => $appt->id,
                    'child_name' => $appt->child->first_name . ' ' . $appt->child->last_name,
                    'vaccine' => $appt->vaccine->name,
                    'appointment_date' => $appt->appointment_date,
                    'appointment_time' => $appt->appointment_time,
                    'status' => $appt->status,
                ];
            }),
        ]);
    }

    /**
     * POST /api/appointments - Create appointment
     */
    public function createAppointment(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'vaccine_id' => 'required|exists:vaccines,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $schedule = Schedule::create([
                'child_id' => $request->child_id,
                'vaccine_id' => $request->vaccine_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'Scheduled',
                'notes' => $request->notes,
                'sms_sent' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully',
                'data' => [
                    'appointment_id' => $schedule->id,
                    'appointment_date' => $schedule->appointment_date,
                    'appointment_time' => $schedule->appointment_time,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create appointment',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * PUT /api/appointments/{appointment_id} - Update appointment
     */
    public function updateAppointment(Request $request, $appointmentId)
    {
        $appointment = Schedule::find($appointmentId);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found',
            ], 404);
        }

        $request->validate([
            'appointment_date' => 'nullable|date|after:today',
            'appointment_time' => 'nullable|date_format:H:i',
            'status' => 'nullable|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $appointment->update($request->only(['appointment_date', 'appointment_time', 'status', 'notes']));

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully',
            'data' => $appointment,
        ]);
    }

    /**
     * DELETE /api/appointments/{appointment_id} - Cancel appointment
     */
    public function cancelAppointment($appointmentId)
    {
        $appointment = Schedule::find($appointmentId);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found',
            ], 404);
        }

        $appointment->update(['status' => 'Cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled successfully',
        ]);
    }

    /**
     * GET /api/clinic-info - Get public clinic information
     */
    public function getClinicInfo()
    {
        $settings = \App\Models\ClinicSetting::first();

        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Clinic settings not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Clinic information retrieved successfully',
            'data' => [
                'clinic_name' => $settings->clinic_name,
                'phone' => $settings->phone,
                'email' => $settings->email,
                'address' => $settings->address,
                'city' => $settings->city,
                'province' => $settings->province,
                'timezone' => $settings->timezone,
                'operating_hours' => $settings->operating_hours,
                'consultation_fee' => $settings->consultation_fee,
                'vaccine_service_fee' => $settings->vaccine_service_fee,
            ],
        ]);
    }
}
