@extends('layouts.admin')

@section('page-title', 'Create Email Template')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0" style="color: #52796f; font-weight: 600;"><i class="bi bi-envelope-plus"></i> New Email Template</h2>
            <p class="text-muted mt-2">Create a new email notification template</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Errors!</strong>
            <ul style="margin: 10px 0 0 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.email-notifications.store') }}" method="POST" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        @csrf

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Template Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g., Appointment Reminder" required>
                    <small class="text-muted">Unique identifier for this template</small>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-control" required>
                        @foreach (['notification' => 'Notification', 'reminder' => 'Reminder', 'alert' => 'Alert', 'report' => 'Report'] as $val => $label)
                            <option value="{{ $val }}" {{ old('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject *</label>
            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Email subject line" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Body *</label>
            <textarea name="body" class="form-control" rows="12" placeholder="Create your email template here. Use {variable_name} for dynamic values." required>{{ old('body') }}</textarea>
            <small class="text-muted d-block mt-2">Available variables: 
                @foreach ($availableVariables as $var => $desc)
                    <code>{{{ $var }}}</code> ({{ $desc }}){{ ! $loop->last ? ', ' : '' }}
                @endforeach
            </small>
        </div>

        <div class="mb-3">
            <label class="form-check-label">
                <input type="checkbox" name="active" value="1" checked class="form-check-input"> Active
            </label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Create Template
            </button>
            <a href="{{ route('admin.email-notifications.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-control, .form-select, .form-check-input {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #52796f;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #2f3e46;
        margin-bottom: 8px;
    }

    .btn-primary {
        background: #52796f;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #354f52;
    }

    code {
        background: #f3f4f6;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Monaco', monospace;
        font-size: 12px;
    }
</style>
@endsection
