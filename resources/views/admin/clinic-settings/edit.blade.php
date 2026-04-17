@extends('layouts.admin')

@section('page-title', 'Clinic Settings')

@section('content')

<div style="max-width: 900px; margin: 0 auto;">
  {{-- Header --}}
  <div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.875rem; font-weight: 700; color: #2f3e46; margin: 0; margin-bottom: 8px;">Clinic Settings</h1>
    <p style="color: #a8ada9; font-size: 0.95rem;">Manage your clinic information and configuration</p>
  </div>

  {{-- Success Message --}}
  @if (session('success'))
    <div style="background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 16px; margin-bottom: 24px; color: #065f46;">
      <strong>✓ Success!</strong> {{ session('success') }}
    </div>
  @endif

  {{-- Error Messages --}}
  @if ($errors->any())
    <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin-bottom: 24px; color: #7f1d1d;">
      <strong>⚠ Error!</strong> Please fix the errors below:
      <ul style="margin: 8px 0 0 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form --}}
  <form action="{{ route('admin.clinic-settings.update') }}" method="POST" style="background: rgba(202, 210, 197, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(202, 210, 197, 0.3); padding: 32px; border-radius: 16px;">
    @csrf

    {{-- Basic Information Section --}}
    <div style="margin-bottom: 32px;">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">Basic Information</h3>
      
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Clinic Name *</label>
          <input type="text" name="clinic_name" value="{{ old('clinic_name', $settings->clinic_name ?? '') }}" required pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('clinic_name')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Email *</label>
          <input type="email" name="email" value="{{ old('email', $settings->email ?? '') }}" required
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('email')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Phone *</label>
          <input type="tel" name="phone" value="{{ old('phone', $settings->phone ?? '') }}" required pattern="^(09[0-9]{9}|\\+639[0-9]{9})$" title="Enter valid Philippine phone number (09XXXXXXXXX or +639XXXXXXXXX)" maxlength="13"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('phone')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Emergency Phone</label>
          <input type="tel" name="emergency_phone" value="{{ old('emergency_phone', $settings->emergency_phone ?? '') }}" pattern="^(09[0-9]{9}|\\+639[0-9]{9})$" title="Enter valid Philippine phone number (09XXXXXXXXX or +639XXXXXXXXX)" maxlength="13"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('emergency_phone')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
      </div>

      <div>
        <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Address *</label>
        <input type="text" name="address" value="{{ old('address', $settings->address ?? '') }}" required pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed"
               style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
        @error('address')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
      </div>
    </div>

    {{-- Location Section --}}
    <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid rgba(202, 210, 197, 0.3);">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">Location</h3>
      
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">City *</label>
          <input type="text" name="city" value="{{ old('city', $settings->city ?? '') }}" required pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('city')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Province *</label>
          <input type="text" name="province" value="{{ old('province', $settings->province ?? '') }}" required pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('province')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Postal Code *</label>
          <input type="text" name="postal_code" value="{{ old('postal_code', $settings->postal_code ?? '') }}" required pattern="[0-9]+" title="Only numbers allowed" maxlength="10"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('postal_code')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
      </div>
    </div>

    {{-- System Settings Section --}}
    <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid rgba(202, 210, 197, 0.3);">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">System Settings</h3>
      
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Timezone *</label>
          <select name="timezone" required
                  style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
            <option value="Asia/Manila" {{ old('timezone', $settings->timezone ?? 'Asia/Manila') === 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila (UTC+8)</option>
            <option value="Asia/Bangkok" {{ old('timezone', $settings->timezone ?? 'Asia/Manila') === 'Asia/Bangkok' ? 'selected' : '' }}>Asia/Bangkok (UTC+7)</option>
            <option value="UTC" {{ old('timezone', $settings->timezone ?? 'Asia/Manila') === 'UTC' ? 'selected' : '' }}>UTC</option>
          </select>
          @error('timezone')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Website</label>
          <input type="url" name="website" value="{{ old('website', $settings->website ?? '') }}" placeholder="https://..."
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('website')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
      </div>

      <div style="margin-top: 20px;">
        <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Facebook URL</label>
        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" placeholder="https://facebook.com/..."
               style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
        @error('facebook_url')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
      </div>
    </div>

    {{-- Fees Section --}}
    <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid rgba(202, 210, 197, 0.3);">
      <h3 style="font-size: 1.125rem; font-weight: 600; color: #52796f; margin: 0 0 20px 0;">Fees</h3>
      
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Consultation Fee (₱)</label>
          <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $settings->consultation_fee ?? 0) }}" step="0.01" min="0"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('consultation_fee')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
        <div>
          <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Vaccine Service Fee (₱)</label>
          <input type="number" name="vaccine_service_fee" value="{{ old('vaccine_service_fee', $settings->vaccine_service_fee ?? 0) }}" step="0.01" min="0"
                 style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46;">
          @error('vaccine_service_fee')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
        </div>
      </div>
    </div>

    {{-- Description Section --}}
    <div style="margin-bottom: 32px;">
      <label style="display: block; font-weight: 600; color: #2f3e46; margin-bottom: 8px; font-size: 0.95rem;">Description</label>
      <textarea name="description" rows="4" placeholder="Brief description of your clinic..."
                style="width: 100%; padding: 12px; border: 1px solid rgba(202, 210, 197, 0.5); background: rgba(255, 255, 255, 0.7); border-radius: 8px; font-size: 0.95rem; color: #2f3e46; font-family: inherit;">{{ old('description', $settings->description ?? '') }}</textarea>
      @error('description')<span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>@enderror
    </div>

    {{-- Action Buttons --}}
    <div style="display: flex; gap: 12px;">
      <button type="submit" style="background: #52796f; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer;">
        ✓ Save Settings
      </button>
      <a href="{{ route('admin.dashboard') }}" style="background: transparent; color: #52796f; padding: 12px 24px; border: 1px solid #52796f; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block;">
        Cancel
      </a>
    </div>
  </form>
</div>

@endsection
