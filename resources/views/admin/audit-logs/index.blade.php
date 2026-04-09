@extends('layouts.admin')

@section('title', 'Audit Logs')
@section('page-title', 'Audit & Activity Logs')

@section('content')
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h6>Total Logs</h6>
                <div class="stat-value">{{ $stats['total_logs'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h6>Today's Activities</h6>
                <div class="stat-value">{{ $stats['today_logs'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h6>This Month</h6>
                <div class="stat-value">{{ $stats['this_month_logs'] }}</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.audit-logs') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-select">
                        <option value="">All</option>
                        @foreach($userTypes as $type)
                            <option value="{{ $type }}" @if(request('user_type') == $type) selected @endif>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Action</label>
                    <select name="action" class="form-select">
                        <option value="">All</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" @if(request('action') == $action) selected @endif>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Model Type</label>
                    <select name="model_type" class="form-select">
                        <option value="">All</option>
                        @foreach($modelTypes as $type)
                            <option value="{{ $type }}" @if(request('model_type') == $type) selected @endif>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.audit-logs.export', request()->query()) }}" class="btn btn-success w-100" target="_blank">
                        <i class="bi bi-download"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="table-responsive" style="box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 8px;">
        <table class="table">
            <thead>
                <tr>
                    <th>User Type</th>
                    <th>User ID</th>
                    <th>Action</th>
                    <th>Model</th>
                    <th>Model ID</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <span class="badge" style="background: #d2dcc9; color: #52796f;">
                                {{ $log->user_type }}
                            </span>
                        </td>
                        <td>{{ $log->user_id }}</td>
                        <td>
                            <span class="badge" style="@if($log->action === 'Created') background: #dcfce7; color: #16a34a; @elseif($log->action === 'Updated') background: #fef3c7; color: #b45309; @else background: #fee2e2; color: #dc2626; @endif">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>{{ $log->model_type }}</td>
                        <td>{{ $log->model_id }}</td>
                        <td>
                            <small class="text-muted">{{ $log->ip_address }}</small>
                        </td>
                        <td>
                            <small class="text-muted">{{ $log->created_at->format('M d, Y H:i') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            No audit logs found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
