@extends('layouts.admin')

@section('page-title', 'Create SMS Template')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0" style="color: #52796f; font-weight: 600;"><i class="bi bi-chat-dots"></i> New SMS Template</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.sms-templates.store') }}" method="POST" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Template Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Appointment Reminder" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Type *</label>
                            <select name="type" class="form-control" required>
                                <option>reminder</option>
                                <option>alert</option>
                                <option>confirmation</option>
                                <option>notification</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message (Max 1000 chars) *</label>
                    <textarea name="message" class="form-control" rows="8" placeholder="Your SMS message..." oninput="updateCharCount()" id="msgInput" required></textarea>
                    <small class="text-muted">Characters: <strong id="charCount">0</strong>/160 (SMS: <strong id="smsCount">0</strong>)</small>
                </div>

                <div class="mb-3">
                    <label><input type="checkbox" name="active" value="1" checked> Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Create Template</button>
            </form>
        </div>

        <div class="col-lg-4">
            <div style="background: #f0fdf4; padding: 15px; border-radius: 10px; border-left: 4px solid #16a34a; margin-bottom: 20px;">
                <strong style="color: #166534;">Available Variables:</strong>
                <div style="font-size: 12px; color: #166534; margin-top: 10px;">
                    <code>{child_name}</code>, <code>{parent_name}</code>, <code>{vaccine_name}</code>, <code>{appointment_date}</code>, <code>{clinic_name}</code>, <code>{clinic_phone}</code>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateCharCount() {
        const msg = document.getElementById('msgInput').value;
        const len = msg.length;
        document.getElementById('charCount').textContent = len;
        document.getElementById('smsCount').textContent = Math.ceil(len / 160);
    }
</script>

<style>
    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 10px 12px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #52796f;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .btn-primary {
        background: #52796f;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }

    code {
        background: #f3f4f6;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: monospace;
        font-size: 11px;
    }
</style>
@endsection
