@extends('layouts.admin')

@section('page-title', 'SMS Templates')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 class="mb-0" style="color: #52796f; font-weight: 600;"><i class="bi bi-chat-dots"></i> SMS Templates</h2>
            <p class="text-muted mt-2">Manage SMS notification templates</p>
        </div>
        <div class="col-lg-4 text-end">
            <a href="{{ route('admin.sms-templates.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> New Template
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <table class="table table-hover mb-0">
            <thead style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <tr>
                    <th style="padding: 15px; font-weight: 600;">Name</th>
                    <th style="padding: 15px; font-weight: 600;">Type</th>
                    <th style="padding: 15px; font-weight: 600;">Message</th>
                    <th style="padding: 15px; font-weight: 600;">Status</th>
                    <th style="padding: 15px; font-weight: 600; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($templates as $template)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 15px;"><strong>{{ $template->name }}</strong></td>
                        <td style="padding: 15px;">
                            <span class="badge" style="background: #d2dcc9; color: #1e40af; padding: 5px 10px; border-radius: 4px; font-size: 12px;">{{ ucfirst($template->type) }}</span>
                        </td>
                        <td style="padding: 15px;"><small class="text-muted">{{ Str::limit($template->message, 40) }}</small></td>
                        <td style="padding: 15px;">
                            @if ($template->active)
                                <span class="badge" style="background: #dcfce7; color: #166534; padding: 5px 10px; border-radius: 4px; font-size: 12px;">Active</span>
                            @else
                                <span class="badge" style="background: #fee2e2; color: #b91c1c; padding: 5px 10px; border-radius: 4px; font-size: 12px;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="{{ route('admin.sms-templates.edit', $template) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: #9ca3af;">
                            No SMS templates found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $templates->links('pagination::bootstrap-5') }}
</div>

<style>
    .btn-primary {
        background: #52796f;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #354f52;
    }
</style>
@endsection
