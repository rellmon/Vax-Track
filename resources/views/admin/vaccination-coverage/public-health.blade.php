@extends('layouts.admin')

@section('page-title', 'Public Health Report')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 style="color: #52796f; font-weight: 600;"><i class="bi bi-journal-text"></i> Public Health Dashboard</h2>
            <p class="text-muted">Vaccination coverage statistics and public health metrics</p>
        </div>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-auto">
            <label class="form-label">Period:</label>
        </div>
        <div class="col-auto">
            <input type="date" name="from" class="form-control" value="{{ $from }}">
        </div>
        <div class="col-auto">to</div>
        <div class="col-auto">
            <input type="date" name="to" class="form-control" value="{{ $to }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <table class="table table-hover mb-0">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="padding: 15px; font-weight: 600;">Vaccine</th>
                    <th style="padding: 15px; font-weight: 600; text-align: right;">Target</th>
                    <th style="padding: 15px; font-weight: 600; text-align: right;">Vaccinated</th>
                    <th style="padding: 15px; font-weight: 600; text-align: right;">Coverage %</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($coverageData as $item)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 15px;"><strong>{{ $item['vaccine'] }}</strong></td>
                        <td style="padding: 15px; text-align: right;">{{ $item['target'] }}</td>
                        <td style="padding: 15px; text-align: right;">{{ $item['vaccinated'] }}</td>
                        <td style="padding: 15px; text-align: right;">
                            <div style="display: inline-block; min-width: 150px;">
                                <div class="progress" style="height: 20px; border-radius: 4px; background: #e5e7eb;">
                                    <div class="progress-bar" style="width: {{ $item['coverage'] }}%; background: {{ $item['coverage'] >= 90 ? '#10b981' : ($item['coverage'] >= 70 ? '#f59e0b' : '#ef4444') }};">
                                        {{ round($item['coverage'], 1) }}%
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 30px; text-align: center; color: #9ca3af;">
                            No vaccination data available for the selected period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .form-control {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 8px 12px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .btn-primary {
        background: #52796f;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
    }

    .progress {
        height: 20px;
        border-radius: 4px;
    }

    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 12px;
    }
</style>
@endsection
