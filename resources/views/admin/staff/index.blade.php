@extends('layouts.admin')

@section('title', 'Staff Management')
@section('page-title', 'Staff & Doctor Management')

@section('content')
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h6>Total Staff</h6>
                <div class="stat-value">{{ $stats['total_staff'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card success">
                <h6>Active Staff</h6>
                <div class="stat-value">{{ $stats['active_staff'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary w-100" style="height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 600;">
                <i class="bi bi-plus-circle"></i> Add New Staff
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-4" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.staff.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search by Name/Email/Username</label>
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" @if(request('role') == $role) selected @endif>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Search
                    </button>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="table-responsive" style="box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 8px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Schedules</th>
                    <th>Vaccines Given</th>
                    <th>Audit Logs</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->username }}</td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            @if($user->active)
                                <span class="badge" style="background: #f0fdf4; color: #16a34a;">
                                    <i class="bi bi-check-circle"></i> Active
                                </span>
                            @else
                                <span class="badge" style="background: #fef2f2; color: #dc2626;">
                                    <i class="bi bi-dash-circle"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="@if($user->role === 'Admin') background: #fee2e2; color: #dc2626; @elseif($user->role === 'Doctor') background: rgba(82,121,111,.12); color: #52796f; @else background: #f0fdf4; color: #16a34a; @endif">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td><span class="badge" style="background: rgba(82,121,111,.12); color: #52796f;">{{ $user->schedules_count ?? 0 }}</span></td>
                        <td><span class="badge" style="background: #fef3c7; color: #b45309;">{{ $user->vaccine_records_count ?? 0 }}</span></td>
                        <td><span class="badge" style="background: #f3f4f6; color: #4b5563;">{{ $user->audit_logs_count ?? 0 }}</span></td>
                        <td>
                            <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.staff.show', $user) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.staff.edit', $user) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            No staff members found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
