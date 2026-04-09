<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClinicSetting;
use Illuminate\Http\Request;

class ClinicSettingsController
{
    /**
     * Show clinic settings form
     */
    public function edit()
    {
        $settings = ClinicSetting::first() ?? new ClinicSetting();
        
        return view('admin.clinic-settings.edit', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update clinic settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'timezone' => 'required|string',
            'consultation_fee' => 'nullable|numeric|min:0',
            'vaccine_service_fee' => 'nullable|numeric|min:0',
            'website' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'emergency_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $settings = ClinicSetting::first() ?? new ClinicSetting();
        $settings->fill($validated)->save();

        return redirect()->route('admin.clinic-settings.edit')
            ->with('success', 'Clinic settings updated successfully.');
    }

    /**
     * API: Get clinic settings
     */
    public function summary()
    {
        $settings = ClinicSetting::first();
        
        return response()->json([
            'clinic_name' => $settings->clinic_name ?? 'VaccTrack Clinic',
            'phone' => $settings->phone,
            'email' => $settings->email,
            'address' => $settings->address,
            'city' => $settings->city,
            'province' => $settings->province,
            'timezone' => $settings->timezone ?? 'Asia/Manila',
            'consultation_fee' => $settings->consultation_fee ?? 0,
            'vaccine_service_fee' => $settings->vaccine_service_fee ?? 0,
        ]);
    }
}
