@extends('layouts.admin')

@section('title', $user->name)
@section('page-title', 'Staff Details: ' . $user->name)

@section('content')
<div class="container-fluid">
    <!-- Header & Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h4 style="margin: 0 0 5px 0; font-weight: 700;">{{ $user->name }}</h4>
                            <p style="margin: 0; color: #84a98c;">
                                <span class="badge" style="@if($user->role === 'Admin') background: #fee2e2; color: #dc2626; @elseif($user->role === 'Doctor') background: rgba(82,121,111,.12); color: #52796f; @else background: #f0fdf4; color: #16a34a; @endif">
                                    {{ $user->role }}
                                </span>
                                | {{ $user->username }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('admin.staff.edit', $user) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h6>Total Schedules</h6>
                <div class="stat-value">{{ $metrics['total_schedules'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card success">
                <h6>Completed</h6>
                <div class="stat-value">{{ $metrics['completed_schedules'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card warning">
                <h6>Active</h6>
                <div class="stat-value">{{ $metrics['active_schedules'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h6>Vaccines Given</h6>
                <div class="stat-value">{{ $metrics['total_vaccines_given'] }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <!-- Staff Information -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Information</h6>
                </div>
                <div class="card-body">
                    <div style="font-size: 0.875rem;">
                        <div style="padding: 10px 0; border-bottom: 1px solid #cad2c5;">
                            <p style="color: #84a98c; margin: 0 0 5px 0;">Full Name</p>
                            <p style="margin: 0; font-weight: 600;">{{ $user->name }}</p>
                        </div>
                        <div style="padding: 10px 0; border-bottom: 1px solid #cad2c5;">
                            <p style="color: #84a98c; margin: 0 0 5px 0;">Username</p>
                            <p style="margin: 0; font-weight: 600;">{{ $user->username }}</p>
                        </div>
                        <div style="padding: 10px 0; border-bottom: 1px solid #cad2c5;">
                            <p style="color: #84a98c; margin: 0 0 5px 0;">Email</p>
                            <p style="margin: 0; font-weight: 600;">{{ $user->email ?? 'N/A' }}</p>
                        </div>
                        <div style="padding: 10px 0; border-bottom: 1px solid #cad2c5;">
                            <p style="color: #84a98c; margin: 0 0 5px 0;">Role</p>
                            <p style="margin: 0;">
                                <span class="badge" style="@if($user->role === 'Admin') background: #fee2e2; color: #dc2626; @elseif($user->role === 'Doctor') background: rgba(82,121,111,.12); color: #52796f; @else background: #f0fdf4; color: #16a34a; @endif">
                                    {{ $user->role }}
                                </span>
                            </p>
                        </div>
                        <div style="padding: 10px 0;">
                            <p style="color: #84a98c; margin: 0 0 5px 0;">Member Since</p>
                            <p style="margin: 0; font-weight: 600;">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.staff.edit', $user) }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-pencil"></i> Edit Staff
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Back to Staff
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Recent Activity -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recent Activity (Last 50)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.875rem;">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Model</th>
                                <th>ID</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivity->take(20) as $activity)
                                <tr>
                                    <td>
                                        <span class="badge" style="@if($activity->action === 'Created') background: #dcfce7; color: #16a34a; @elseif($activity->action === 'Updated') background: #fef3c7; color: #b45309; @else background: #fee2e2; color: #dc2626; @endif">
                                            {{ $activity->action }}
                                        </span>
                                    </td>
                                    <td>{{ $activity->model_type }}</td>
                                    <td>{{ $activity->model_id }}</td>
                                    <td>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No activity recorded</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Vaccines -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recently Administered Vaccines (Last 20)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.875rem;">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Vaccine</th>
                                <th>Date</th>
                                <th>Dose</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVaccines as $vaccine)
                                <tr>
                                    <td>
                                        @if($vaccine->child)
                                            {{ $vaccine->child->first_name }} {{ $vaccine->child->last_name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($vaccine->vaccine)
                                            <strong>{{ $vaccine->vaccine->name }}</strong>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $vaccine->date_given ? $vaccine->date_given->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $vaccine->dose_number ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No vaccines administered</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
