@extends('layouts.admin')

@section('page-title', 'Create Scheduled Report')

@section('content')
<div class="container-fluid">
    <h2 style="color: #52796f; margin-bottom: 20px; font-weight: 600;"><i class="bi bi-calendar-plus"></i> New Scheduled Report</h2>

    <form action="{{ route('admin.scheduled-reports.store') }}" method="POST" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 700px;">
        @csrf

        <div class="mb-3">
            <label class="form-label">Report Name *</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Weekly Financial Report" required>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Report Type *</label>
                    <select name="report_type" class="form-control" required>
                        @foreach (App\Models\ScheduledReport::getReportTypes() as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Frequency *</label>
                    <select name="frequency" class="form-control" required>
                        @foreach (App\Models\ScheduledReport::getFrequencies() as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Recipients * (one per line)</label>
            <textarea name="recipients" class="form-control" rows="5" placeholder="email1@example.com&#10;email2@example.com" required></textarea>
            <small class="text-muted">Enter one email address per line</small>
        </div>

        <label><input type="checkbox" name="active" value="1" checked> Active</label>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Create Report</button>
            <a href="{{ route('admin.scheduled-reports.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 10px 12px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #52796f;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .btn-primary {
        background: #52796f;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }
</style>
@endsection
