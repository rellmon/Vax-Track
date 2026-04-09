@extends('layouts.admin')

@section('page-title', 'Edit SMS Template')

@section('content')
<div class="container-fluid">
    <h2 style="color: #52796f; margin-bottom: 10px; font-weight: 600;"><i class="bi bi-chat-dots"></i> Edit SMS Template</h2>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.sms-templates.update', $template) }}" method="POST" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Template Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ $template->name }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Type *</label>
                            <select name="type" class="form-control" required>
                                @foreach (['reminder', 'alert', 'confirmation', 'notification'] as $t)
                                    <option value="{{ $t }}" {{ $template->type === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message *</label>
                    <textarea name="message" class="form-control" rows="8" oninput="updateCharCount()" id="msgInput" required>{{ $template->message }}</textarea>
                    <small>Characters: <strong id="charCount">{{ strlen($template->message) }}</strong>/160 (SMS: <strong id="smsCount">{{ ceil(strlen($template->message) / 160) }}</strong>)</small>
                </div>

                <label><input type="checkbox" name="active" value="1" {{ $template->active ? 'checked' : '' }}> Active</label>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.sms-templates.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <form action="{{ route('admin.sms-templates.test', $template) }}" method="POST" style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                @csrf
                <label style="font-weight: 600; margin-bottom: 10px; display: block;">Test SMS</label>
                <input type="tel" name="test_phone" class="form-control" placeholder="09XX..." required>
                <button type="submit" class="btn btn-success w-100 mt-2">Send Test</button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCharCount() {
        const msg = document.getElementById('msgInput').value;
        document.getElementById('charCount').textContent = msg.length;
        document.getElementById('smsCount').textContent = Math.ceil(msg.length / 160);
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

    .btn-primary, .btn-success {
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-primary {
        background: #52796f;
    }

    .btn-success {
        background: #16a34a;
    }
</style>
@endsection
