@extends('layouts.doctor')
@section('page-title', 'Register New Child')
@section('content')
<div style="max-width:760px;">
  <a href="{{ route('doctor.children') }}" class="btn btn-secondary mb-4" style="display:inline-flex;align-items:center;gap:7px;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Children
  </a>

  <!-- Error Alert -->
  @if($errors->any())
  <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:16px;margin-bottom:20px;color:#991b1b;">
    <div style="display:flex;align-items:flex-start;gap:12px;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <div>
        <strong style="font-size:15px;">❌ Registration Error</strong>
        <ul style="margin:10px 0 0;padding-left:20px;font-size:14px;">
          @foreach($errors->all() as $error)
            <li style="margin:6px 0;">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endif

  <form action="{{ route('doctor.children.store') }}" method="POST">
    @csrf
    <!-- Child Info -->
    <div class="card mb-4">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          Child Information
        </span>
      </div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group"><label>First Name</label><input type="text" name="first_name" class="form-control" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" maxlength="50" required></div>
          <div class="form-group"><label>Last Name</label><input type="text" name="last_name" class="form-control" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" maxlength="50" required></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" class="form-control" required></div>
          <div class="form-group"><label>Gender</label>
            <select name="gender" class="form-control" required>
              <option value="">— Select —</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Blood Type</label>
            <select name="blood_type" class="form-control">
              <option value="">Unknown</option>
              @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)<option>{{ $bt }}</option>@endforeach
            </select>
          </div>
          <div class="form-group"><label>Address</label><input type="text" name="address" class="form-control" maxlength="255" pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed"></div>
        </div>
        <div class="form-group"><label>Notes / Allergies</label><textarea name="notes" class="form-control" placeholder="Any known allergies or special notes..." rows="2" maxlength="500"></textarea></div>
      </div>
    </div>

    <!-- Parent Info -->
    <div class="card mb-4">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Parent / Guardian Information
        </span>
      </div>
      <div class="card-body">
        <div class="section-hint">A parent account will be created. They can log in to the Parent Portal.</div>
        <div class="form-row">
          <div class="form-group"><label>Parent First Name</label><input type="text" name="parent_first_name" class="form-control" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" maxlength="50" value="{{ old('parent_first_name') }}"></div>
          <div class="form-group"><label>Parent Last Name</label><input type="text" name="parent_last_name" class="form-control" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" maxlength="50" value="{{ old('parent_last_name') }}"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Phone Number</label><input type="tel" name="parent_phone" class="form-control" placeholder="09XXXXXXXXX" inputmode="numeric" pattern="^(09[0-9]{9}|\\+639[0-9]{9})$" title="Enter valid Philippine phone number (09XXXXXXXXX or +639XXXXXXXXX)" maxlength="13" value="{{ old('parent_phone') }}"></div>
          <div class="form-group">
            <label>Email @if($errors->has('parent_email')) <span style="color:#dc2626;">*</span>@endif</label>
            <input type="email" name="parent_email" class="form-control @if($errors->has('parent_email')) has-error @endif" value="{{ old('parent_email') }}" style="@if($errors->has('parent_email')) border-color:#dc2626;background:#fef2f2; @endif">
            @if($errors->has('parent_email')) <small style="color:#dc2626;display:block;margin-top:4px;">⚠️ {{ $errors->first('parent_email') }}</small> @endif
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Portal Username @if($errors->has('parent_username')) <span style="color:#dc2626;">*</span>@endif</label>
            <input type="text" name="parent_username" class="form-control @if($errors->has('parent_username')) has-error @endif" maxlength="30" value="{{ old('parent_username') }}" style="@if($errors->has('parent_username')) border-color:#dc2626;background:#fef2f2; @endif" placeholder="Must be unique" pattern="[a-zA-Z0-9_]+" title="Only letters, numbers, and underscores allowed">
            @if($errors->has('parent_username')) <small style="color:#dc2626;display:block;margin-top:4px;">⚠️ {{ $errors->first('parent_username') }}</small> @endif
          </div>
          <div class="form-group"><label>Portal Password @if($errors->has('parent_password')) <span style="color:#dc2626;">*</span>@endif</label><input type="password" name="parent_password" class="form-control @if($errors->has('parent_password')) has-error @endif" placeholder="Set login password" minlength="6" maxlength="128" value="{{ old('parent_password') }}" style="@if($errors->has('parent_password')) border-color:#dc2626;background:#fef2f2; @endif">
            @if($errors->has('parent_password')) <small style="color:#dc2626;display:block;margin-top:4px;">⚠️ {{ $errors->first('parent_password') }}</small> @endif
          </div>
        </div>
      </div>
    </div>

    <!-- First Vaccine -->
    <div class="card mb-4">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
          First Vaccine Shot (Optional)
        </span>
      </div>
      <div class="card-body">
        <div class="section-hint" style="background:var(--green-light);color:#065f46;border-color:rgba(82,121,111,.3);">Record the child's first vaccination at registration time.</div>
        <div class="form-row">
          <div class="form-group"><label>Vaccine</label>
            <select name="vaccine_id" class="form-control">
              <option value="">— Skip —</option>
              @foreach($vaccines as $v)<option value="{{ $v->id }}">{{ $v->name }} ({{ $v->type }}) — ₱{{ number_format($v->price,2) }}</option>@endforeach
            </select>
          </div>
          <div class="form-group"><label>Dose Number</label><input type="number" name="dose_number" class="form-control" value="1" min="1" max="10"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Vaccination Date</label><input type="date" name="vaccine_date" class="form-control" value="{{ today()->format('Y-m-d') }}"></div>
          <div class="form-group"><label>Vaccination Time</label><input type="time" name="vaccine_time" class="form-control"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Dose Given</label><input type="text" name="dose_given" class="form-control" placeholder="e.g., 0.5ml" maxlength="50" pattern="[a-zA-Z0-9.\s\-]+" title="Only letters, numbers, dots, and hyphens allowed"></div>
          <div class="form-group"><label>Route</label>
            <select name="vaccine_route" class="form-control">
              <option value="">Select Route</option>
              <option>Intramuscular (IM)</option>
              <option>Subcutaneous (SC)</option>
              <option>Oral (PO)</option>
              <option>Intradermal (ID)</option>
              <option>Other</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Injection Site</label><input type="text" name="injection_site" class="form-control" placeholder="e.g., Right thigh" maxlength="100" pattern="[a-zA-Z0-9\s\-]+" title="Only letters, numbers, and hyphens allowed"></div>
          <div class="form-group"><label>Batch/Lot Number</label><input type="text" name="batch_number" class="form-control" placeholder="Optional" maxlength="100" pattern="[a-zA-Z0-9\-\.]+" title="Only letters, numbers, hyphens, and dots allowed"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Expiration Date</label><input type="date" name="vaccine_expiration" class="form-control"></div>
          <div class="form-group"><label>Status</label>
            <select name="vaccine_status" class="form-control">
              <option>Completed</option>
              <option>Pending</option>
              <option>Missed</option>
              <option>Delayed</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label>Notes</label><textarea name="vaccine_notes" class="form-control" placeholder="Optional notes about the vaccination..." rows="2" maxlength="500" pattern="[a-zA-Z\s0-9,.\-'\(\)]+" title="Only letters, numbers, and basic punctuation allowed"></textarea></div>
      </div>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('doctor.children') }}" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Register Child
      </button>
    </div>
  </form>
</div>
<script>
document.querySelectorAll('input[name="first_name"], input[name="last_name"], input[name="parent_first_name"], input[name="parent_last_name"]').forEach(field => {
  field.addEventListener('input', function() {
    this.value = this.value.replace(/[0-9]/g, '');
  });
});
document.querySelectorAll('input[name="parent_phone"]').forEach(field => {
  field.addEventListener('input', function() {
    this.value = this.value.replace(/[a-zA-Z]/g, '');
  });
});
</script>
@endsection