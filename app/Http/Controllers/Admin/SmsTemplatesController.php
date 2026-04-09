<?php

namespace App\Http\Controllers\Admin;

use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplatesController
{
    /**
     * List SMS templates
     */
    public function index()
    {
        $templates = SmsTemplate::orderBy('type')->paginate(20);

        return view('admin.sms-templates.index', [
            'templates' => $templates,
            'types' => ['reminder', 'alert', 'confirmation', 'notification'],
        ]);
    }

    /**
     * Show create template form
     */
    public function create()
    {
        return view('admin.sms-templates.create', [
            'availableVariables' => SmsTemplate::getAvailableVariables(),
            'types' => ['reminder', 'alert', 'confirmation', 'notification'],
        ]);
    }

    /**
     * Store template
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:sms_templates|max:255',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:reminder,alert,confirmation,notification',
            'active' => 'boolean',
        ]);

        SmsTemplate::create($validated);

        return redirect()->route('admin.sms-templates.index')
            ->with('success', 'SMS template created successfully.');
    }

    /**
     * Show edit template form
     */
    public function edit(SmsTemplate $smsTemplate)
    {
        return view('admin.sms-templates.edit', [
            'template' => $smsTemplate,
            'availableVariables' => SmsTemplate::getAvailableVariables(),
            'types' => ['reminder', 'alert', 'confirmation', 'notification'],
        ]);
    }

    /**
     * Update template
     */
    public function update(Request $request, SmsTemplate $smsTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sms_templates,name,' . $smsTemplate->id,
            'message' => 'required|string|max:1000',
            'type' => 'required|in:reminder,alert,confirmation,notification',
            'active' => 'boolean',
        ]);

        $smsTemplate->update($validated);

        return redirect()->route('admin.sms-templates.index')
            ->with('success', 'SMS template updated successfully.');
    }

    /**
     * Delete template
     */
    public function destroy(SmsTemplate $smsTemplate)
    {
        $smsTemplate->delete();

        return redirect()->route('admin.sms-templates.index')
            ->with('success', 'SMS template deleted successfully.');
    }

    /**
     * Test SMS template
     */
    public function test(Request $request, SmsTemplate $smsTemplate)
    {
        $request->validate([
            'test_phone' => 'required|string',
        ]);

        $message = $this->replacePlaceholders($smsTemplate->message);
        $charCount = strlen($message);

        // In production, actually send via SMS provider
        \Log::info("SMS test for {$smsTemplate->name} to {$request->test_phone}: {$message}");

        return redirect()->back()
            ->with('success', "Test SMS sent to {$request->test_phone} ({$charCount} characters)");
    }

    /**
     * Replace template placeholders with sample data
     */
    private function replacePlaceholders($text)
    {
        return str_replace(
            ['{child_name}', '{parent_name}', '{vaccine_name}', '{appointment_date}', 
             '{appointment_time}', '{clinic_name}', '{clinic_phone}'],
            ['Sample Child', 'Sample Parent', 'Sample Vaccine', '2026-03-25', '10:00 AM', 
             'VaccTrack', '555-1234'],
            $text
        );
    }

    /**
     * Character count for SMS message
     */
    public function characterCount(Request $request)
    {
        $message = $request->input('message', '');
        return response()->json([
            'length' => strlen($message),
            'sms_count' => ceil(strlen($message) / 160),
        ]);
    }

    /**
     * API: Get available variables
     */
    public function variables()
    {
        return response()->json(SmsTemplate::getAvailableVariables());
    }
}
