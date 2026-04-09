@extends('layouts.admin')

@section('title', $vaccine->name)
@section('page-title', 'Vaccine Details: ' . $vaccine->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Vaccine Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Vaccine Name</h6>
                            <p style="margin: 0; font-weight: 500; font-size: 1.25rem;">{{ $vaccine->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Type</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $vaccine->type }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Manufacturer</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $vaccine->manufacturer }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Status</h6>
                            <p style="margin: 0;">
                                <span class="badge" style="@if($vaccine->active) background: #dcfce7; color: #16a34a; @else background: #f3f4f6; color: #6b7280; @endif">
                                    {{ $vaccine->active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Unit Price</h6>
                            <p style="margin: 0; font-weight: 500; font-size: 1.25rem; color: #52796f;">₱{{ number_format($vaccine->price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Description</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $vaccine->description ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid #cad2c5;">

                    <h6 style="font-weight: 700; margin-bottom: 15px; margin-top: 20px;">Update Stock Level</h6>
                    <form method="POST" action="{{ route('admin.vaccine-inventory.stock', $vaccine) }}" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label class="form-label">New Stock Level</label>
                            <input type="number" name="stock" class="form-control" value="{{ $vaccine->stock }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-circle"></i> Update Stock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Stock Summary -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 15px;">Stock Summary</h6>
                    <div style="padding: 15px; background: @if($vaccine->stock > 20)#f0fdf4 @elseif($vaccine->stock > 10)#fef3c7 @else #fee2e2 @endif; border-radius: 6px; border-left: 3px solid @if($vaccine->stock > 20)#16a34a @elseif($vaccine->stock > 10)#ea580c @else #dc2626 @endif;">
                        <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Current Stock</p>
                        <p style="font-size: 2rem; font-weight: 700; margin: 0; color: @if($vaccine->stock > 20)#16a34a @elseif($vaccine->stock > 10)#ea580c @else #dc2626 @endif;">{{ $vaccine->stock }}</p>
                    </div>
                    <div style="padding: 15px; background: #e8ede2; border-radius: 6px; border-left: 3px solid #52796f; margin-top: 10px;">
                        <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Stock Value</p>
                        <p style="font-size: 1.5rem; font-weight: 700; margin: 0; color: #52796f;">₱{{ number_format($vaccine->stock * $vaccine->price, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 15px;">Usage Statistics</h6>
                    <div style="padding: 10px 0; border-bottom: 1px solid #cad2c5;">
                        <p style="color: #84a98c; font-size: 0.875rem; margin: 0 0 5px 0;">Total Used</p>
                        <p style="font-weight: 700; margin: 0; font-size: 1.25rem;">{{ $usage }}</p>
                    </div>
                    <div style="padding: 10px 0; border-bottom: 1px solid #cad2c5;">
                        <p style="color: #84a98c; font-size: 0.875rem; margin: 0 0 5px 0;">Pending Schedules</p>
                        <p style="font-weight: 700; margin: 0; font-size: 1.25rem;">{{ $pendingSchedules }}</p>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <a href="{{ route('admin.vaccine-inventory.dashboard') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-left"></i> Back to Inventory
            </a>
        </div>
    </div>

    <!-- Recent Usage -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recent Usage (Last 20 Records)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Child Name</th>
                                <th>Date Given</th>
                                <th>Dose Number</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsage as $record)
                                <tr>
                                    <td>
                                        @if($record->child)
                                            <strong>{{ $record->child->first_name }} {{ $record->child->last_name }}</strong>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $record->date_given ? $record->date_given->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $record->dose_number ?? 'N/A' }}</td>
                                    <td>{{ $record->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent usage</td>
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
