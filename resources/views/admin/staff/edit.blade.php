@extends('layouts.admin')

@section('title', 'Edit Staff')
@section('page-title', 'Edit Staff Member: ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Staff Information</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.staff.update', $user) }}">
                        @method('PUT')
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                            <small class="text-muted">Username cannot be changed</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role *</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="Admin" @if(old('role', $user->role) == 'Admin') selected @endif>Admin</option>
                                <option value="Doctor" @if(old('role', $user->role) == 'Doctor') selected @endif>Doctor</option>
                                <option value="Staff" @if(old('role', $user->role) == 'Staff') selected @endif>Staff</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Staff
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reset Password -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Reset Password</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.staff.reset-password', $user) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">New Password *</label>
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

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-lock"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Account Status -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 15px;">Account Status</h6>
                    @if($user->active)
                        <div style="padding: 10px; background: #f0fdf4; border-radius: 6px; border-left: 3px solid #16a34a;">
                            <p style="margin: 0; color: #16a34a; font-weight: 600;">
                                <i class="bi bi-check-circle"></i> Active
                            </p>
                        </div>
                        <form method="POST" action="{{ route('admin.staff.deactivate', $user) }}" style="margin-top: 15px;">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Are you sure you want to deactivate this account? They will not be able to login.')">
                                <i class="bi bi-x-circle"></i> Deactivate Account
                            </button>
                        </form>
                    @else
                        <div style="padding: 10px; background: #fef2f2; border-radius: 6px; border-left: 3px solid #dc2626;">
                            <p style="margin: 0; color: #dc2626; font-weight: 600;">
                                <i class="bi bi-dash-circle"></i> Inactive
                            </p>
                        </div>
                        <form method="POST" action="{{ route('admin.staff.reactivate', $user) }}" style="margin-top: 15px;">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle"></i> Reactivate Account
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Quick Info -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 15px;">Quick Info</h6>
                    <div style="font-size: 0.875rem;">
                        <p style="margin-bottom: 10px;">
                            <strong>Created:</strong><br>
                            {{ $user->created_at->format('M d, Y H:i') }}
                        </p>
                        <p style="margin-bottom: 10px;">
                            <strong>Last Updated:</strong><br>
                            {{ $user->updated_at->format('M d, Y H:i') }}
                        </p>
                        <p>
                            <strong>Staff ID:</strong><br>
                            {{ $user->id }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary w-100 mt-3">
                <i class="bi bi-arrow-left"></i> Back to Staff
            </a>
        </div>
    </div>
</div>

<!-- Reactivate Modal -->
@if(!$user->email)
<div class="modal fade" id="reactivateModal" tabindex="-1" aria-labelledby="reactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.staff.reactivate', $user) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reactivateModalLabel">Reactivate Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please enter a new email address to reactivate this account.</p>
                    <div class="mb-3">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Reactivate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
