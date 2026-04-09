@extends('layouts.admin')

@section('page-title', 'Vaccine Details -' . $vaccine->name)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 style="color: #52796f; font-weight: 600;"><i class="bi bi-syringe"></i> {{ $vaccine->name }}</h2>
            <p class="text-muted">{{ $vaccine->description }}</p>
        </div>
        <div class="col-lg-4 text-end">
            <form method="GET">
                <input type="date" name="from" class="form-control-sm" value="{{ $from }}">
                <input type="date" name="to" class="form-control-sm" value="{{ $to }}">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div style="font-size: 28px; font-weight: 700; color: #52796f;">{{ $vaccine->stock }}</div>
                <div style="font-size: 12px; color: #9ca3af;">Current Stock</div>
            </div>
        </div>
        <div class="col-lg-3">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div style="font-size: 28px; font-weight: 700; color: #10b981;">₱{{ number_format($vaccine->price, 2) }}</div>
                <div style="font-size: 12px; color: #9ca3af;">Price per Dose</div>
            </div>
        </div>
        <div class="col-lg-3">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div style="font-size: 28px; font-weight: 700; color: #f59e0b;">{{ $vaccine->type }}</div>
                <div style="font-size: 12px; color: #9ca3af;">Vaccine Type</div>
            </div>
        </div>
        <div class="col-lg-3">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div style="font-size: 28px; font-weight: 700; color: #8b5cf6;">{{ $vaccine->manufacturer }}</div>
                <div style="font-size: 12px; color: #9ca3af;">Manufacturer</div>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h5 style="margin-bottom: 15px; font-weight: 600;">Recent Vaccination Records</h5>
        <table class="table table-hover mb-0">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="padding: 10px;">Child</th>
                    <th style="padding: 10px;">Parent</th>
                    <th style="padding: 10px;">Date Given</th>
                    <th style="padding: 10px;">Dose</th>
                    <th style="padding: 10px;">Staff</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 10px;">{{ $record->child->first_name }} {{ $record->child->last_name }}</td>
                        <td style="padding: 10px;">{{ $record->child->parent->first_name ?? 'N/A' }}</td>
                        <td style="padding: 10px;">{{ $record->date_given }}</td>
                        <td style="padding: 10px;">{{ $record->dose_number }}</td>
                        <td style="padding: 10px;"><small>{{ $record->administered_by }}</small></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: #9ca3af;">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $records->links() }}
    </div>
</div>

<style>
    .form-control-sm {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 12px;
        display: inline-block;
        width: auto;
        margin-right: 5px;
    }

    .btn-primary {
        background: #52796f;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }
</style>
@endsection
