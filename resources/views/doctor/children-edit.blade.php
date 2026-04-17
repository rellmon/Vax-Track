@extends('layouts.doctor')
@section('page-title', 'Edit Child')
@section('content')
<div style="max-width:680px;">
  <a href="{{ route('doctor.children.show', $child) }}" class="btn btn-secondary mb-4" style="display:inline-flex;align-items:center;gap:7px;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Profile
  </a>
  <div class="card">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:8px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
        Edit — {{ $child->full_name }}
      </span>
    </div>
    <div class="card-body">
      <form action="{{ route('doctor.children.update', $child) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row">
          <div class="form-group"><label>First Name</label><input type="text" name="first_name" class="form-control" value="{{ $child->first_name }}" maxlength="50" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" required></div>
          <div class="form-group"><label>Last Name</label><input type="text" name="last_name" class="form-control" value="{{ $child->last_name }}" maxlength="50" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" required></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" class="form-control" value="{{ $child->dob }}" required></div>
          <div class="form-group"><label>Gender</label>
            <select name="gender" class="form-control" required>
              <option value="">— Select —</option>
              <option value="Male" {{ $child->gender==='Male'?'selected':'' }}>Male</option>
              <option value="Female" {{ $child->gender==='Female'?'selected':'' }}>Female</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Blood Type</label>
            <select name="blood_type" class="form-control">
              <option value="">Unknown</option>
              @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                <option {{ $child->blood_type===$bt?'selected':'' }}>{{ $bt }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group"><label>Address</label><input type="text" name="address" class="form-control" value="{{ $child->address }}" maxlength="255" pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed"></div>
        </div>
        <div class="form-group"><label>Notes / Allergies</label><textarea name="notes" class="form-control" rows="3" maxlength="500">{{ $child->notes }}</textarea></div>
        <div class="flex gap-2 mt-4">
          <a href="{{ route('doctor.children.show', $child) }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection