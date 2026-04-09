@extends('layouts.admin')

@section('page-title', 'Edit Email Template')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0" style="color: #52796f; font-weight: 600;"><i class="bi bi-envelope-check"></i> Edit Email Template</h2>
            <p class="text-muted mt-2">{{ $template->name }}</p>
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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.email-notifications.update', $template) }}" method="POST" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Template Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $template->name) }}" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Type *</label>
                            <select name="type" class="form-control" required>
                                @foreach (['notification' => 'Notification', 'reminder' => 'Reminder', 'alert' => 'Alert', 'report' => 'Report'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('type', $template->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject *</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject', $template->subject) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Body *</label>
                    <textarea name="body" class="form-control" rows="12" required>{{ old('body', $template->body) }}</textarea>
                    <small class="text-muted d-block mt-2">Available variables: 
                        @foreach ($availableVariables as $var => $desc)
                            <code>{{{ $var }}}</code>{{ ! $loop->last ? ', ' : '' }}
                        @endforeach
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-check-label">
                        <input type="checkbox" name="active" value="1" {{ old('active', $template->active) ? 'checked' : '' }} class="form-check-input"> Active
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Template
                    </button>
                    <a href="{{ route('admin.email-notifications.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <h5 style="color: #2f3e46; font-weight: 600; margin-bottom: 15px;">📬 Test Template</h5>
                <form action="{{ route('admin.email-notifications.test', $template) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 13px;">Test Email Address</label>
                        <input type="email" name="test_email" class="form-control" placeholder="your@email.com" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Send Test Email</button>
                </form>
            </div>

            <div style="background: #f0fdf4; padding: 15px; border-radius: 10px; border-left: 4px solid #16a34a;">
                <strong style="color: #52796f; display: block; margin-bottom: 10px;"><i class="bi bi-lightbulb"></i> Tips</strong>
                <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #166534;">
                    <li>Use variable names in curly braces</li>
                    <li>Test before using in production</li>
                    <li>Keep subjects under 100 characters</li>
                    <li>Use professional formatting</li>
                </ul>
            </div>
        </div>
    </div>
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

    .btn-primary, .btn-success {
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-primary {
        background: #52796f;
    }

    .btn-primary:hover {
        background: #354f52;
    }

    .btn-success {
        background: #16a34a;
    }

    .btn-success:hover {
        background: #15803d;
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
