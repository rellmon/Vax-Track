<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ParentGuardian;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use App\Models\Schedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParentWelcome;

class ChildController extends Controller
{
    public function index(Request $request)
    {
        $query = Child::with('parent');
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }
        $children = $query->latest()->get();
        return view('doctor.children', compact('children'));
    }

    public function create()
    {
        $vaccines = Vaccine::where('active', true)->get();
        return view('doctor.children-create', compact('vaccines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'dob'         => 'required|date',
            'gender'      => 'required|in:Male,Female',
            'parent_first_name' => 'nullable|string|max:255',
            'parent_last_name'  => 'nullable|string|max:255',
            'parent_email'      => 'nullable|email|unique:parent_guardians,email',
            'parent_username'   => 'nullable|unique:parent_guardians,username',
            'parent_password'   => 'nullable|min:6',
            'parent_phone'      => 'nullable|string|max:20',
            'parent_address'    => 'nullable|string',
        ]);

        // Create parent
        $parentId = null;
        if ($request->parent_first_name && $request->parent_last_name) {
            $parent = ParentGuardian::create([
                'first_name' => $request->parent_first_name,
                'last_name'  => $request->parent_last_name,
                'phone'      => $request->parent_phone,
                'email'      => $request->parent_email,
                'address'    => $request->parent_address,
                'username'   => $request->parent_username,
                'password'   => $request->parent_password ? Hash::make($request->parent_password) : Hash::make('password'),
            ]);
            $parentId = $parent->id;

            // Send welcome email to new parent
            if ($parent->email) {
                try {
                    Mail::to($parent->email)->send(new ParentWelcome($parent));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send welcome email to parent', [
                        'parent_id' => $parent->id,
                        'email' => $parent->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        $child = Child::create([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'dob'         => $request->dob,
            'gender'      => $request->gender,
            'blood_type'  => $request->blood_type,
            'address'     => $request->address,
            'notes'       => $request->notes,
            'parent_id'   => $parentId,
        ]);

        // First vaccine record
        if ($request->vaccine_id) {
            $vaccineDate = $request->vaccine_date ?? today();
            VaccineRecord::create([
                'child_id'        => $child->id,
                'vaccine_id'      => $request->vaccine_id,
                'date_given'      => $vaccineDate,
                'dose_number'     => $request->dose_number ?? 1,
                'notes'           => $request->vaccine_notes,
                'administered_by' => session('doctor_name', 'Dr. Admin'),
            ]);
            
            // Create completed schedule
            $appointmentTime = $request->vaccine_time ? $request->vaccine_time . ':00' : '10:00:00';
            $schedule = Schedule::create([
                'child_id'         => $child->id,
                'vaccine_id'       => $request->vaccine_id,
                'appointment_date' => $vaccineDate,
                'appointment_time' => $appointmentTime,
                'status'           => 'Completed',
                'notes'            => $request->vaccine_notes,
                'sms_sent'         => false,
            ]);
            
            // Create payment for the vaccine
            $vaccine = Vaccine::find($request->vaccine_id);
            if ($vaccine) {
                Payment::create([
                    'child_id'     => $child->id,
                    'schedule_id'  => $schedule->id,
                    'amount'       => $vaccine->price,
                    'method'       => 'Cash',
                    'status'       => 'Pending',
                    'payment_date' => $vaccineDate,
                    'notes'        => 'Auto-generated from child registration',
                ]);
                if ($vaccine->stock > 0) {
                    $vaccine->decrement('stock');
                }
            }
        }

        return redirect()->route('doctor.children')->with('success', 'Child registered successfully.');
    }

    public function createWithExistingParent()
    {
        $parents  = ParentGuardian::all();
        $vaccines = Vaccine::where('active', true)->get();
        return view('doctor.children-create-existing', compact('parents', 'vaccines'));
    }

    public function storeWithExistingParent(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'dob'        => 'required|date',
            'gender'     => 'required|in:Male,Female',
            'parent_id'  => 'required|exists:parent_guardians,id',
        ]);

        $child = Child::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'dob'        => $request->dob,
            'gender'     => $request->gender,
            'blood_type' => $request->blood_type,
            'address'    => $request->address,
            'notes'      => $request->notes,
            'parent_id'  => $request->parent_id,
        ]);

        if ($request->vaccine_id) {
            $vaccineDate = $request->vaccine_date ?? today();
            VaccineRecord::create([
                'child_id'        => $child->id,
                'vaccine_id'      => $request->vaccine_id,
                'date_given'      => $vaccineDate,
                'dose_number'     => $request->dose_number ?? 1,
                'notes'           => $request->vaccine_notes,
                'administered_by' => session('doctor_name', 'Dr. Admin'),
            ]);
            
            // Create completed schedule
            $appointmentTime = $request->vaccine_time ? $request->vaccine_time . ':00' : '10:00:00';
            $schedule = Schedule::create([
                'child_id'         => $child->id,
                'vaccine_id'       => $request->vaccine_id,
                'appointment_date' => $vaccineDate,
                'appointment_time' => $appointmentTime,
                'status'           => 'Completed',
                'notes'            => $request->vaccine_notes,
                'sms_sent'         => false,
            ]);
            
            // Create payment for the vaccine
            $vaccine = Vaccine::find($request->vaccine_id);
            if ($vaccine) {
                Payment::create([
                    'child_id'     => $child->id,
                    'schedule_id'  => $schedule->id,
                    'amount'       => $vaccine->price,
                    'method'       => 'Cash',
                    'status'       => 'Pending',
                    'payment_date' => $vaccineDate,
                    'notes'        => 'Auto-generated from child registration',
                ]);
                if ($vaccine->stock > 0) $vaccine->decrement('stock');
            }
        }

        return redirect()->route('doctor.children')->with('success', 'Child registered with existing parent.');
    }

    public function show(Child $child)
    {
        $child->load(['parent', 'vaccineRecords.vaccine', 'schedules.vaccine']);
        $vaccines = Vaccine::where('active', true)->get();
        return view('doctor.children-show', compact('child', 'vaccines'));
    }

    public function edit(Child $child)
    {
        return view('doctor.children-edit', compact('child'));
    }

    public function update(Request $request, Child $child)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'dob'        => 'required|date',
            'gender'     => 'required|in:Male,Female',
        ]);

        $child->update($request->only(['first_name', 'last_name', 'dob', 'gender', 'blood_type', 'address', 'notes']));
        return redirect()->route('doctor.children')->with('success', 'Child info updated.');
    }

    public function addVaccine(Request $request, Child $child)
    {
        $isAjax = $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        try {
            // Validate input
            $validated = $request->validate([
                'vaccine_id'      => 'required|exists:vaccines,id',
                'dose_number'     => 'required|integer|min:1|max:10',
                'vaccine_date'    => 'required|date_format:Y-m-d',
                'administered_by' => 'nullable|string|max:100',
                'vaccine_notes'   => 'nullable|string|max:500',
            ]);

            // Parse and validate the date
            $vaccineDate = \Carbon\Carbon::createFromFormat('Y-m-d', $validated['vaccine_date']);
            if (!$vaccineDate || $vaccineDate->isFuture()) {
                throw new \Exception('Vaccine date cannot be in the future');
            }

            $administeredBy = $validated['administered_by'] ?? session('doctor_name', 'Dr. Admin');

            // Create vaccine record
            $vaccineRecord = VaccineRecord::create([
                'child_id'        => $child->id,
                'vaccine_id'      => $validated['vaccine_id'],
                'date_given'      => $vaccineDate->toDateString(),
                'dose_number'     => (int)$validated['dose_number'],
                'notes'           => $validated['vaccine_notes'] ?? '',
                'administered_by' => $administeredBy,
            ]);

            // Log successful creation
            \Illuminate\Support\Facades\Log::info('Vaccine record created', [
                'child_id' => $child->id,
                'vaccine_id' => $validated['vaccine_id'],
                'date_given' => $vaccineDate->toDateString(),
            ]);

            // Return response
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vaccine record added successfully',
                    'record' => $vaccineRecord
                ], 200);
            }

            return redirect()->route('doctor.children.show', $child)
                ->with('success', 'Vaccine record added successfully.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = implode(', ', array_values($e->errors())[0] ?? ['Validation failed']);
            
            \Illuminate\Support\Facades\Log::warning('Vaccine record validation error', [
                'child_id' => $child->id,
                'errors' => $e->errors(),
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error: ' . $errorMessage
                ], 422);
            }

            return redirect()->route('doctor.children.show', $child)
                ->withErrors($e->errors())
                ->withInput();
                
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error adding vaccine record', [
                'child_id' => $child->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('doctor.children.show', $child)
                ->with('error', 'Error adding vaccine record: ' . $e->getMessage());
        }
    }
}
