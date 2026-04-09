<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display audit logs dashboard
     */
    public function index(Request $request)
    {
        $query = AuditLog::query();

        // Filter by user type
        if ($request->has('user_type') && $request->user_type) {
            $query->where('user_type', $request->user_type);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by user ID
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Pagination
        $logs = $query->latest('created_at')->paginate(50);

        // Get distinct values for filter dropdowns
        $userTypes = AuditLog::distinct('user_type')->pluck('user_type');
        $actions = AuditLog::distinct('action')->pluck('action');
        $modelTypes = AuditLog::distinct('model_type')->pluck('model_type');

        // Stats
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
            'this_month_logs' => AuditLog::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        return view('admin.audit-logs.index', compact('logs', 'userTypes', 'actions', 'modelTypes', 'stats'));
    }

    /**
     * Show detailed view of a single audit log
     */
    public function show(AuditLog $auditLog)
    {
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    /**
     * Export audit logs as CSV
     */
    public function export(Request $request)
    {
        $query = AuditLog::query();

        // Apply same filters as index
        if ($request->has('user_type') && $request->user_type) {
            $query->where('user_type', $request->user_type);
        }
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }
        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', $request->model_type);
        }
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $logs = $query->latest('created_at')->get();

        // Generate CSV
        $csvHeader = "User Type,User ID,Action,Model Type,Model ID,IP Address,Timestamp\n";
        $csvData = '';

        foreach ($logs as $log) {
            $csvData .= "\"{$log->user_type}\",\"{$log->user_id}\",\"{$log->action}\",\"{$log->model_type}\",\"{$log->model_id}\",\"{$log->ip_address}\",\"{$log->created_at}\"\n";
        }

        return response()
            ->streamDownload(
                function () use ($csvHeader, $csvData) {
                    echo $csvHeader . $csvData;
                },
                'audit-logs-' . now()->format('Y-m-d-His') . '.csv'
            );
    }

    /**
     * Get activity summary for dashboard
     */
    public function activitySummary()
    {
        $summary = [
            'last_24h' => AuditLog::where('created_at', '>=', now()->subHours(24))->count(),
            'last_7d' => AuditLog::where('created_at', '>=', now()->subDays(7))->count(),
            'last_30d' => AuditLog::where('created_at', '>=', now()->subDays(30))->count(),
            'by_action' => AuditLog::selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->pluck('count', 'action'),
            'by_user_type' => AuditLog::selectRaw('user_type, COUNT(*) as count')
                ->groupBy('user_type')
                ->pluck('count', 'user_type'),
            'recent_changes' => AuditLog::with(['old_values', 'new_values'])
                ->latest('created_at')
                ->limit(10)
                ->get(),
        ];

        return response()->json($summary);
    }
}
