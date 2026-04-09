@extends('layouts.admin')

@section('title', 'Audit Log Details')
@section('page-title', 'Audit Log Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h6 class="mb-0" style="font-weight: 700;">Activity Details</h6>
                        <a href="{{ route('admin.audit-logs') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">User Type</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $auditLog->user_type }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">User ID</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $auditLog->user_id }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Action</h6>
                            <p style="margin: 0;">
                                <span class="badge" style="@if($auditLog->action === 'Created') background: #dcfce7; color: #16a34a; @elseif($auditLog->action === 'Updated') background: #fef3c7; color: #b45309; @else background: #fee2e2; color: #dc2626; @endif">
                                    {{ $auditLog->action }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Timestamp</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $auditLog->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid #cad2c5; margin: 30px 0;">

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Model Type</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $auditLog->model_type }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">Model ID</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $auditLog->model_id }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">IP Address</h6>
                            <p style="margin: 0; font-weight: 500;">{{ $auditLog->ip_address }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 style="color: #84a98c; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 8px;">User Agent</h6>
                            <p style="margin: 0; font-weight: 500; font-size: 0.85rem; word-break: break-all;">{{ $auditLog->user_agent }}</p>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid #cad2c5; margin: 30px 0;">

                    @if($auditLog->old_values || $auditLog->new_values)
                        <div class="row">
                            @if($auditLog->old_values)
                                <div class="col-md-6 mb-4">
                                    <h6 style="font-weight: 700; color: #dc2626; margin-bottom: 15px;">Old Values</h6>
                                    <div style="background: #fef2f2; padding: 15px; border-radius: 6px; border-left: 3px solid #dc2626;">
                                        <pre style="margin: 0; white-space: pre-wrap; word-break: break-word;">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </div>
                                </div>
                            @endif

                            @if($auditLog->new_values)
                                <div class="col-md-6 mb-4">
                                    <h6 style="font-weight: 700; color: #16a34a; margin-bottom: 15px;">New Values</h6>
                                    <div style="background: #f0fdf4; padding: 15px; border-radius: 6px; border-left: 3px solid #16a34a;">
                                        <pre style="margin: 0; white-space: pre-wrap; word-break: break-word;">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
