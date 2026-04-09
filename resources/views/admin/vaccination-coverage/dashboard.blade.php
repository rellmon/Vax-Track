@extends('layouts.admin')

@section('page-title', 'Vaccination Coverage')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 style="color: #52796f; font-weight: 600;"><i class="bi bi-syringe"></i> Vaccination Coverage Report</h2>
            <p class="text-muted">Track vaccination rates and coverage statistics</p>
        </div>
        <div class="col-lg-4 text-end">
            <form method="GET" style="display: inline-flex; gap: 10px;">
                <input type="date" name="from" class="form-control form-control-sm" value="{{ $from }}">
                <input type="date" name="to" class="form-control form-control-sm" value="{{ $to }}">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('admin.vaccination-coverage.export', ['from' => $from, 'to' => $to]) }}" class="btn btn-sm btn-outline-secondary">Export CSV</a>
            </form>
        </div>
    </div>

    <!-- Overall Coverage Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; text-align: center;">
                <div style="font-size: 48px; font-weight: 700;">{{ number_format($overallCoverage['coverage_percentage'], 1) }}%</div>
                <div style="font-size: 14px; opacity: 0.9;">Overall Vaccination Coverage</div>
                <div style="font-size: 12px; margin-top: 10px; opacity: 0.85;">{{ $overallCoverage['total_vaccinated'] }} of {{ $overallCoverage['total_population'] }} children vaccinated ({{ $overallCoverage['vaccine_count'] }} vaccines)</div>
            </div>
        </div>
    </div>

    <!-- Vaccine Coverage Table -->
    <div class="row">
        <div class="col-lg-12">
            <div style="background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 20px;">
                <h5 style="color: #2f3e46; font-weight: 600; margin-bottom: 15px;"><i class="bi bi-bar-chart"></i> Coverage by Vaccine</h5>
                <table class="table table-hover mb-0">
                    <thead style="background: #f9fafb;">
                        <tr>
                            <th>Vaccine</th>
                            <th>Target Population</th>
                            <th>Vaccinated</th>
                            <th>Coverage %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vaccineCoverage as $vc)
                            <tr>
                                <td><strong>{{ $vc->vaccine->name }}</strong></td>
                                <td>{{ $vc->total_target }}</td>
                                <td>{{ $vc->total_vaccinated }}</td>
                                <td>
                                    <div class="progress" style="height: 20px; border-radius: 4px; background: #e5e7eb;">
                                        <div class="progress-bar" style="width: {{ $vc->avg_coverage }}%; background: #10b981;">{{ round($vc->avg_coverage, 1) }}%</div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 30px; text-align: center; color: #9ca3af;">No vaccination data available for the selected period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control-sm {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 13px;
    }

    .btn-sm {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
    }

    .btn-primary {
        background: #52796f;
        border: none;
    }

    .btn-outline-secondary {
        border: 1px solid #d1d5db;
    }

    .progress {
        height: 20px;
    }
</style>
@endsection
