<?php

namespace App\Http\Controllers\Admin;

use App\Models\ScheduledReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduledReportsController
{
    /**
     * List scheduled reports
     */
    public function index()
    {
        $reports = ScheduledReport::with('createdBy')->orderBy('next_run_date')->paginate(20);

        return view('admin.scheduled-reports.index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Show create report form
     */
    public function create()
    {
        return view('admin.scheduled-reports.create', [
            'types' => ScheduledReport::getReportTypes(),
            'frequencies' => ScheduledReport::getFrequencies(),
        ]);
    }

    /**
     * Store scheduled report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:scheduled_reports',
            'report_type' => 'required|in:financial,audit,inventory,coverage,vaccines',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'email',
            'active' => 'boolean',
        ]);

        $validated['created_by_user_id'] = session('doctor_id');
        $validated['next_run_date'] = $this->calculateNextRunDate($validated['frequency']);

        ScheduledReport::create($validated);

        return redirect()->route('admin.scheduled-reports.index')
            ->with('success', 'Scheduled report created successfully.');
    }

    /**
     * Show edit report form
     */
    public function edit(ScheduledReport $scheduledReport)
    {
        return view('admin.scheduled-reports.edit', [
            'report' => $scheduledReport,
            'types' => ScheduledReport::getReportTypes(),
            'frequencies' => ScheduledReport::getFrequencies(),
        ]);
    }

    /**
     * Update scheduled report
     */
    public function update(Request $request, ScheduledReport $scheduledReport)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:scheduled_reports,name,' . $scheduledReport->id,
            'report_type' => 'required|in:financial,audit,inventory,coverage,vaccines',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'email',
            'active' => 'boolean',
        ]);

        $scheduledReport->update($validated);

        return redirect()->route('admin.scheduled-reports.index')
            ->with('success', 'Scheduled report updated successfully.');
    }

    /**
     * Delete scheduled report
     */
    public function destroy(ScheduledReport $scheduledReport)
    {
        $scheduledReport->delete();

        return redirect()->route('admin.scheduled-reports.index')
            ->with('success', 'Scheduled report deleted successfully.');
    }

    /**
     * Show report details
     */
    public function show(ScheduledReport $scheduledReport)
    {
        return view('admin.scheduled-reports.show', [
            'report' => $scheduledReport,
            'types' => ScheduledReport::getReportTypes(),
            'frequencies' => ScheduledReport::getFrequencies(),
        ]);
    }

    /**
     * Test run scheduled report
     */
    public function testRun(Request $request, ScheduledReport $scheduledReport)
    {
        // In production, generate and send the report here
        $recipients = implode(', ', $scheduledReport->recipients);
        
        \Log::info("Test run of {$scheduledReport->name} ({$scheduledReport->report_type}) to: {$recipients}");

        return redirect()->back()
            ->with('success', "Test run completed. Report would be sent to: {$recipients}");
    }

    /**
     * Calculate next run date based on frequency
     */
    private function calculateNextRunDate($frequency)
    {
        return match($frequency) {
            'daily' => now()->addDay(),
            'weekly' => now()->addWeek(),
            'monthly' => now()->addMonth(),
            'quarterly' => now()->addMonths(3),
            default => now()->addDay(),
        };
    }

    /**
     * API: Get next reports due
     */
    public function dueReports()
    {
        $reports = ScheduledReport::getDueReports();
        
        return response()->json([
            'count' => $reports->count(),
            'reports' => $reports->map(fn($r) => [
                'id' => $r->id,
                'name' => $r->name,
                'type' => $r->report_type,
                'recipients' => $r->recipients,
                'next_run' => $r->next_run_date->format('Y-m-d H:i'),
            ]),
        ]);
    }
}
