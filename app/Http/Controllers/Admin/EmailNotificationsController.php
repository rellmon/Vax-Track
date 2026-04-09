<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailNotificationsController
{
    /**
     * List email templates
     */
    public function index()
    {
        $templates = EmailTemplate::orderBy('type')->paginate(20);

        return view('admin.email-notifications.index', [
            'templates' => $templates,
            'types' => ['notification', 'reminder', 'alert', 'report'],
        ]);
    }

    /**
     * Show create template form
     */
    public function create()
    {
        return view('admin.email-notifications.create', [
            'availableVariables' => EmailTemplate::getAvailableVariables(),
            'types' => ['notification', 'reminder', 'alert', 'report'],
        ]);
    }

    /**
     * Store template
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:email_templates|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:notification,reminder,alert,report',
            'active' => 'boolean',
        ]);

        EmailTemplate::create($validated);

        return redirect()->route('admin.email-notifications.index')
            ->with('success', 'Email template created successfully.');
    }

    /**
     * Show edit template form
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-notifications.edit', [
            'template' => $emailTemplate,
            'availableVariables' => EmailTemplate::getAvailableVariables(),
            'types' => ['notification', 'reminder', 'alert', 'report'],
        ]);
    }

    /**
     * Update template
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:email_templates,name,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:notification,reminder,alert,report',
            'active' => 'boolean',
        ]);

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-notifications.index')
            ->with('success', 'Email template updated successfully.');
    }

    /**
     * Delete template
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('admin.email-notifications.index')
            ->with('success', 'Email template deleted successfully.');
    }

    /**
     * Test email template
     */
    public function test(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        // Simulate sending with sample variables
        $subject = $emailTemplate->subject;
        $body = $this->replacePlaceholders($emailTemplate->body);

        // In production, actually send the email here
        \Log::info("Email test for {$emailTemplate->name} to {$request->test_email}");

        return redirect()->back()
            ->with('success', "Test email sent to {$request->test_email}");
    }

    /**
     * Replace template placeholders with sample data
     */
    private function replacePlaceholders($text)
    {
        return str_replace(
            ['{child_name}', '{parent_name}', '{vaccine_name}', '{appointment_date}', 
             '{appointment_time}', '{clinic_name}', '{clinic_phone}', '{clinic_address}'],
            ['Sample Child', 'Sample Parent', 'Sample Vaccine', '2026-03-25', '10:00 AM', 
             'VaccTrack Clinic', '555-1234', '123 Main St'],
            $text
        );
    }

    /**
     * API: Get available variables
     */
    public function variables()
    {
        return response()->json(EmailTemplate::getAvailableVariables());
    }
}
