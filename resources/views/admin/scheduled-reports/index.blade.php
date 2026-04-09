@extends('layouts.admin')

@section('page-title', 'Scheduled Reports')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 style="color: #52796f; font-weight: 600;"><i class="bi bi-calendar-event"></i> Scheduled Reports</h2>
            <p class="text-muted">Automated report delivery to email recipients</p>
        </div>
        <div class="col-lg-4 text-end">
            <a href="{{ route('admin.scheduled-reports.create') }}" class="btn btn-primary">New Report</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <table class="table table-hover mb-0">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="padding: 15px; font-weight: 600;">Name</th>
                    <th style="padding: 15px; font-weight: 600;">Type</th>
                    <th style="padding: 15px; font-weight: 600;">Frequency</th>
                    <th style="padding: 15px; font-weight: 600;">Next Run</th>
                    <th style="padding: 15px; font-weight: 600;">Status</th>
                    <th style="padding: 15px; font-weight: 600; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 15px;"><strong>{{ $report->name }}</strong></td>
                        <td style="padding: 15px;"><span class="badge" style="background: #d2dcc9; color: #1e40af; padding: 5px 10px;">{{ ucfirst(str_replace('_', ' ', $report->report_type)) }}</span></td>
                        <td style="padding: 15px;">{{ ucfirst($report->frequency) }}</td>
                        <td style="padding: 15px;"><small>{{ $report->next_run_date->format('M d, Y H:i') }}</small></td>
                        <td style="padding: 15px;">
                            @if ($report->active)
                                <span class="badge" style="background: #dcfce7; color: #166534;">Active</span>
                            @else
                                <span class="badge" style="background: #fee2e2; color: #b91c1c;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="{{ route('admin.scheduled-reports.edit', $report) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.scheduled-reports.destroy', $report) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: #9ca3af;">No scheduled reports configured.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reports->links() }}
</div>

<style>
    .btn-primary {
        background: #52796f;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
    }
</style>
@endsection
