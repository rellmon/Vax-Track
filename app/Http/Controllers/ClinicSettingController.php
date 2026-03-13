<?php

namespace App\Http\Controllers;

use App\Models\ClinicSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClinicSettingController extends Controller
{
    /**
     * Display clinic settings edit form
     */
    public function edit()
    {
        $settings = ClinicSetting::first() ?? new ClinicSetting();
        return view('doctor.clinic-settings', compact('settings'));
    }

    /**
     * Update clinic settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'timezone' => 'nullable|timezone',
            'consultation_fee' => 'nullable|numeric|min:0',
            'vaccine_service_fee' => 'nullable|numeric|min:0',
            'website' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:100',
            'monday_open' => 'nullable|boolean',
            'monday_open_time' => 'nullable|date_format:H:i',
            'monday_close_time' => 'nullable|date_format:H:i',
            'tuesday_open' => 'nullable|boolean',
            'tuesday_open_time' => 'nullable|date_format:H:i',
            'tuesday_close_time' => 'nullable|date_format:H:i',
            'wednesday_open' => 'nullable|boolean',
            'wednesday_open_time' => 'nullable|date_format:H:i',
            'wednesday_close_time' => 'nullable|date_format:H:i',
            'thursday_open' => 'nullable|boolean',
            'thursday_open_time' => 'nullable|date_format:H:i',
            'thursday_close_time' => 'nullable|date_format:H:i',
            'friday_open' => 'nullable|boolean',
            'friday_open_time' => 'nullable|date_format:H:i',
            'friday_close_time' => 'nullable|date_format:H:i',
            'saturday_open' => 'nullable|boolean',
            'saturday_open_time' => 'nullable|date_format:H:i',
            'saturday_close_time' => 'nullable|date_format:H:i',
            'sunday_open' => 'nullable|boolean',
        ]);

        // Build operating hours array
        $operatingHours = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach ($days as $day) {
            $dayLower = strtolower($day);
            $operatingHours[$day] = [
                'is_open' => $request->has("{$dayLower}_open"),
                'open_time' => $request->input("{$dayLower}_open_time", "08:00"),
                'close_time' => $request->input("{$dayLower}_close_time", "17:00"),
            ];
        }

        // Build bank details
        $bankDetails = [
            'bank_name' => $request->input('bank_name'),
            'account_number' => $request->input('account_number'),
            'account_holder' => $request->input('account_holder'),
        ];

        // Create or update clinic settings
        $settings = ClinicSetting::first() ?? new ClinicSetting();
        $settings->fill([
            'clinic_name' => $request->clinic_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'timezone' => $request->timezone ?? 'Asia/Manila',
            'consultation_fee' => $request->consultation_fee ?? 500,
            'vaccine_service_fee' => $request->vaccine_service_fee ?? 200,
            'website' => $request->website,
            'facebook_url' => $request->facebook_url,
            'emergency_phone' => $request->emergency_phone,
            'description' => $request->description,
            'operating_hours' => $operatingHours,
            'bank_details' => $bankDetails,
        ]);
        $settings->save();

        Log::info('Clinic settings updated', [
            'updated_by' => session('doctor_id'),
            'clinic_name' => $settings->clinic_name,
        ]);

        return redirect()->back()->with('success', 'Clinic settings updated successfully!');
    }

    /**
     * API endpoint to get clinic info
     */
    public function getInfo()
    {
        $settings = ClinicSetting::first();
        
        if (!$settings) {
            return response()->json(['error' => 'Clinic settings not configured'], 404);
        }

        return response()->json([
            'clinic_name' => $settings->clinic_name,
            'phone' => $settings->phone,
            'email' => $settings->email,
            'address' => $settings->address,
            'city' => $settings->city,
            'province' => $settings->province,
            'timezone' => $settings->timezone,
            'consultation_fee' => $settings->consultation_fee,
            'vaccine_service_fee' => $settings->vaccine_service_fee,
            'operating_hours' => $settings->operating_hours,
        ]);
    }
}
