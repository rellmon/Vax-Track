@extends('layouts.admin')

@section('page-title', 'Clinic Settings')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0" style="color: #52796f; font-weight: 600;"><i class="bi bi-gear"></i> Clinic Settings</h2>
            <p class="text-muted mt-2">Manage your clinic information and configuration</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please fix the errors below.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.clinic-settings.update') }}" method="POST" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        @csrf

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Clinic Name *</label>
                    <input type="text" name="clinic_name" class="form-control" value="{{ old('clinic_name', $settings->clinic_name ?? '') }}" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $settings->phone ?? '') }}" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Emergency Phone</label>
                    <input type="tel" name="emergency_phone" class="form-control" value="{{ old('emergency_phone', $settings->emergency_phone ?? '') }}">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Address *</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $settings->address ?? '') }}" required>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">City *</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $settings->city ?? '') }}" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Province *</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province', $settings->province ?? '') }}" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">Postal Code *</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $settings->postal_code ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Timezone *</label>
                    <select name="timezone" class="form-control" required>
                        <option value="Asia/Manila" {{ old('timezone', $settings->timezone ?? 'Asia/Manila') === 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila (UTC+8)</option>
                        <option value="Asia/Bangkok" {{ old('timezone', $settings->timezone ?? 'Asia/Manila') === 'Asia/Bangkok' ? 'selected' : '' }}>Asia/Bangkok (UTC+7)</option>
                        <option value="UTC" {{ old('timezone', $settings->timezone ?? 'Asia/Manila') === 'UTC' ? 'selected' : '' }}>UTC</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control" value="{{ old('website', $settings->website ?? '') }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Facebook URL</label>
            <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" placeholder="https://facebook.com/...">
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Consultation Fee (₱)</label>
                    <input type="number" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $settings->consultation_fee ?? 0) }}" step="0.01" min="0">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Vaccine Service Fee (₱)</label>
                    <input type="number" name="vaccine_service_fee" class="form-control" value="{{ old('vaccine_service_fee', $settings->vaccine_service_fee ?? 0) }}" step="0.01" min="0">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Brief description of your clinic...">{{ old('description', $settings->description ?? '') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Save Settings
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-control, .form-select {
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
        font-size: 14px;
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

    .btn-outline-secondary {
        border: 1px solid #d1d5db;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-outline-secondary:hover {
        background: #f3f4f6;
    }
</style>
@endsection
