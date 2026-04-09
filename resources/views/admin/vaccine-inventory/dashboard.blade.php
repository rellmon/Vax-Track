@extends('layouts.admin')

@section('title', 'Vaccine Inventory')
@section('page-title', 'Vaccine Inventory Management')

@section('content')
<div class="container-fluid">
    <!-- KPI Row -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6>Total Vaccines</h6>
                <div class="stat-value">{{ $stats['total_vaccines'] }}</div>
                <small class="text-muted">in catalog</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card success">
                <h6>Active Vaccines</h6>
                <div class="stat-value">{{ $stats['active_vaccines'] }}</div>
                <small class="text-muted">available for use</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card warning">
                <h6>Low Stock Count</h6>
                <div class="stat-value">{{ $stats['low_stock_count'] }}</div>
                <small class="text-muted">below threshold</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6>Stock Value</h6>
                <div class="stat-value">₱{{ number_format($stats['total_stock_value'], 2) }}</div>
                <small class="text-muted">inventory cost</small>
            </div>
        </div>
    </div>

    <!-- Cost Analysis -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 20px;">Cost Analysis</h6>
                    <div style="padding: 15px; background: rgba(82,121,111,.08); border-radius: 6px; margin-bottom: 10px;">
                        <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Current Stock Value</p>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #52796f; margin: 0;">₱{{ number_format($costAnalysis['total_stock_cost'], 2) }}</p>
                    </div>
                    <div style="padding: 15px; background: #fef3c7; border-radius: 6px;">
                        <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Usage Cost (30 Days)</p>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #ea580c; margin: 0;">₱{{ number_format($costAnalysis['usage_cost_30d'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Vaccines by Category</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Count</th>
                                <th>Total Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr>
                                    <td><strong>{{ $cat->type }}</strong></td>
                                    <td>{{ $cat->count }}</td>
                                    <td>{{ $cat->total_stock ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No categories</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    @if($lowStockVaccines->count() > 0)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #ea580c;">
                    <div class="card-header" style="background: #fef3c7; border-bottom: 2px solid #fed7aa; padding: 20px;">
                        <h6 class="mb-0" style="font-weight: 700; color: #b45309;">
                            <i class="bi bi-exclamation-triangle"></i> Low Stock Alert
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Vaccine Name</th>
                                    <th>Current Stock</th>
                                    <th>Price</th>
                                    <th>Stock Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockVaccines as $vaccine)
                                    <tr>
                                        <td><strong>{{ $vaccine->name }}</strong></td>
                                        <td>
                                            <span style="color: #ea580c; font-weight: 700;">{{ $vaccine->stock }}</span>
                                        </td>
                                        <td>₱{{ number_format($vaccine->price, 2) }}</td>
                                        <td>₱{{ number_format($vaccine->stock * $vaccine->price, 2) }}</td>
                                        <td>
                                            @if($vaccine->stock <= 0)
                                                <span class="badge" style="background: #fee2e2; color: #dc2626;">Out of Stock</span>
                                            @else
                                                <span class="badge" style="background: #fef3c7; color: #b45309;">Low Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.vaccine-inventory.show', $vaccine) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Out of Stock -->
    @if($outOfStockVaccines->count() > 0)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-circle"></i> Out of Stock!</strong>
                    {{ $outOfStockVaccines->count() }} vaccine(s) are out of stock and cannot be used.
                </div>
            </div>
        </div>
    @endif

    <!-- Top Used Vaccines -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Top Used Vaccines (30 Days)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vaccine</th>
                                <th>Usage Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topUsedVaccines as $vaccine)
                                <tr>
                                    <td><strong>{{ $vaccine->name }}</strong></td>
                                    <td>
                                        <span style="background: rgba(82,121,111,.12); color: #52796f; padding: 4px 8px; border-radius: 4px; font-weight: 600;">
                                            {{ $vaccine->usage_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">No usage data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h6 class="mb-0" style="font-weight: 700;">Download Report</h6>
                    </div>
                </div>
                <div class="card-body">
                    <p style="color: #84a98c; margin-bottom: 15px;">Export complete vaccine inventory with usage statistics.</p>
                    <a href="{{ route('admin.vaccine-inventory.report') }}" class="btn btn-success w-100">
                        <i class="bi bi-download"></i> Download Inventory Report (CSV)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- All Vaccines Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">All Vaccines Inventory</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vaccine Name</th>
                                <th>Type</th>
                                <th>Manufacturer</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Used (7d)</th>
                                <th>Used (30d)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allVaccines as $vaccine)
                                <tr>
                                    <td><strong>{{ $vaccine->name }}</strong></td>
                                    <td>{{ $vaccine->type }}</td>
                                    <td>{{ $vaccine->manufacturer }}</td>
                                    <td>
                                        <span style="@if($vaccine->stock > 20) color: #16a34a; @elseif($vaccine->stock > 10) color: #ea580c; @else color: #dc2626; @endif font-weight: 700;">
                                            {{ $vaccine->stock }}
                                        </span>
                                    </td>
                                    <td>₱{{ number_format($vaccine->price, 2) }}</td>
                                    <td>{{ $vaccine->used_7days ?? 0 }}</td>
                                    <td>{{ $vaccine->used_30days ?? 0 }}</td>
                                    <td>
                                        @if($vaccine->active)
                                            <span class="badge" style="background: #dcfce7; color: #16a34a;">Active</span>
                                        @else
                                            <span class="badge" style="background: #f3f4f6; color: #6b7280;">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.vaccine-inventory.show', $vaccine) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No vaccines found</td>
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
