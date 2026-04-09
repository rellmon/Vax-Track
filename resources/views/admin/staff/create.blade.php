@extends('layouts.admin')

@section('title', 'Create Staff')
@section('page-title', 'Add New Staff Member')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Create New Staff Account</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.staff.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role *</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Select Role --</option>
                                <option value="Admin" @if(old('role') == 'Admin') selected @endif>Admin</option>
                                <option value="Doctor" @if(old('role') == 'Doctor') selected @endif>Doctor</option>
                                <option value="Staff" @if(old('role') == 'Staff') selected @endif>Staff</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <small class="text-muted">Minimum 8 characters</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Account
                            </button>
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" style="background: rgba(82,121,111,.08); border: 1px solid rgba(82,121,111,.15); box-shadow: none;">
                <div class="card-body">
                    <h6 style="font-weight: 700; color: #52796f; margin-bottom: 15px;">
                        <i class="bi bi-info-circle"></i> Staff Roles
                    </h6>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 10px 0; border-bottom: 1px solid rgba(82,121,111,.15);">
                            <strong style="color: #1e293b;">Admin</strong>
                            <p style="color: #84a98c; font-size: 0.875rem; margin: 5px 0 0 0;">Full system access. Can manage staff, view all reports, and configure settings.</p>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid rgba(82,121,111,.15);">
                            <strong style="color: #1e293b;">Doctor</strong>
                            <p style="color: #84a98c; font-size: 0.875rem; margin: 5px 0 0 0;">Can manage patients, schedules, vaccines, and payments. Partial admin features.</p>
                        </li>
                        <li style="padding: 10px 0;">
                            <strong style="color: #1e293b;">Staff</strong>
                            <p style="color: #84a98c; font-size: 0.875rem; margin: 5px 0 0 0;">Limited access. Can assist with appointment management and basic tasks.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
