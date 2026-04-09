@extends('layouts.admin')

@section('page-title', 'Report Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 style="color: #52796f; font-weight: 600;"><i class="bi bi-calendar-event"></i> {{ $report->name }}</h2>
        </div>
        <div class="col-lg-4 text-end">
            <form action="{{ route('admin.scheduled-reports.test', $report) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-info">Test Run</button>
            </form>
            <a href="{{ route('admin.scheduled-reports.edit', $report) }}" class="btn btn-sm btn-primary">Edit</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <h5 style="margin-bottom: 15px;">Report Information</h5>
                <dl style="margin: 0;">
                    <dt style="font-weight: 600;">Type</dt>
                    <dd style="margin-bottom: 15px;">{{ App\Models\ScheduledReport::getReportTypes()[$report->report_type] ?? 'N/A' }}</dd>
                    <dt style="font-weight: 600;">Frequency</dt>
                    <dd style="margin-bottom: 15px;">{{ App\Models\ScheduledReport::getFrequencies()[$report->frequency] ?? 'N/A' }}</dd>
                    <dt style="font-weight: 600;">Status</dt>
                    <dd style="margin-bottom: 15px;">
                        @if ($report->active)
                            <span class="badge" style="background: #dcfce7; color: #166534;">Active</span>
                        @else
                            <span class="badge" style="background: #fee2e2; color: #b91c1c;">Inactive</span>
                        @endif
                    </dd>
                    <dt style="font-weight: 600;">Next Run</dt>
                    <dd style="margin-bottom: 15px;">{{ $report->next_run_date->format('M d, Y H:i') }}</dd>
                    <dt style="font-weight: 600;">Last Run</dt>
                    <dd style="margin-bottom: 0;">{{ $report->last_run_date ? $report->last_run_date->format('M d, Y H:i') : 'Never' }}</dd>
                </dl>
            </div>

            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h5 style="margin-bottom: 15px;">Recipients</h5>
                <div style="background: #f9fafb; padding: 15px; border-radius: 6px;">
                    @foreach ($report->recipients as $email)
                        <div style="padding: 5px 0;"><i class="bi bi-envelope"></i> {{ $email }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary, .btn-info {
        border-radius: 6px;
        border: none;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 12px;
    }

    .btn-primary {
        background: #52796f;
    }

    .btn-info {
        background: #0891b2;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>
@endsection
