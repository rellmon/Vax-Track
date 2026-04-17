@extends('layouts.doctor')
@section('page-title', 'Child Profile')
@section('content')
<div>
  <a href="{{ route('doctor.children') }}" class="btn btn-secondary mb-4" style="display:inline-flex;align-items:center;gap:7px;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Children
  </a>

  <div class="section-grid mb-4">
    <div class="card">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          Child Info
        </span>
        <a href="{{ route('doctor.children.edit', $child) }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
          Edit
        </a>
      </div>
      <div class="card-body">
        <div class="info-grid">
          <div class="info-item"><label>Full Name</label><p>{{ $child->full_name }}</p></div>
          <div class="info-item"><label>Date of Birth</label><p>{{ \Carbon\Carbon::parse($child->dob)->format('F j, Y') }}</p></div>
          <div class="info-item"><label>Age</label><p>{{ $child->age }}</p></div>
          <div class="info-item"><label>Gender</label><p>{{ $child->gender }}</p></div>
          <div class="info-item"><label>Blood Type</label><p>{{ $child->blood_type ?: '—' }}</p></div>
          <div class="info-item"><label>Address</label><p>{{ $child->address ?: '—' }}</p></div>
        </div>
        @if($child->notes)
          <div style="margin-top:12px;padding:10px 14px;background:var(--green-light);border-radius:8px;font-size:13px;color:var(--forest-dark);display:flex;align-items:flex-start;gap:8px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/></svg>
            {{ $child->notes }}
          </div>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Parent / Guardian
        </span>
      </div>
      <div class="card-body">
        @if($child->parent)
          <div class="info-grid">
            <div class="info-item"><label>Name</label><p>{{ $child->parent->full_name }}</p></div>
            <div class="info-item"><label>Phone</label><p>{{ $child->parent->phone ?: '—' }}</p></div>
            <div class="info-item"><label>Email</label><p>{{ $child->parent->email ?: '—' }}</p></div>
            <div class="info-item"><label>Username</label><p>{{ $child->parent->username ?: '—' }}</p></div>
          </div>
        @else
          <p class="text-muted">No parent linked.</p>
        @endif
      </div>
    </div>
  </div>

  <div class="section-grid">
    <div class="card">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
          Vaccination History
        </span>
        <button type="button" class="btn btn-sm btn-primary" onclick="openAddVaccineModal()" style="display:inline-flex;align-items:center;gap:5px;">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Past Vaccine
        </button>
      </div>
      <div class="table-wrapper">
        <table>
          <thead><tr><th>Vaccine</th><th>Date Given</th><th>Dose</th><th>Administered By</th></tr></thead>
          <tbody>
            @forelse($child->vaccineRecords as $r)
              <tr>
                <td><strong>{{ $r->vaccine?->name }}</strong> <span class="badge badge-blue">{{ $r->vaccine?->type }}</span></td>
                <td>{{ \Carbon\Carbon::parse($r->date_given)->format('M j, Y') }}</td>
                <td>Dose {{ $r->dose_number }}</td>
                <td>{{ $r->administered_by }}</td>
              </tr>
            @empty
              <tr><td colspan="4"><div class="empty-state" style="padding:20px;"><p>No records yet.</p></div></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Schedules
        </span>
      </div>
      <div class="table-wrapper">
        <table>
          <thead><tr><th>Vaccine</th><th>Date</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($child->schedules as $s)
              <tr>
                <td>{{ $s->vaccine?->name }}</td>
                <td>{{ \Carbon\Carbon::parse($s->appointment_date)->format('M j, Y') }}</td>
                <td><span class="badge {{ $s->status==='Completed'?'badge-green':($s->status==='Cancelled'?'badge-red':'badge-amber') }}">{{ $s->status }}</span></td>
              </tr>
            @empty
              <tr><td colspan="3"><div class="empty-state" style="padding:20px;"><p>No schedules.</p></div></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Past Vaccine Modal — uses the same .modal-overlay structure as all other modals -->
<div class="modal-overlay" id="addPastVaccineModal" onclick="if(event.target===this)closeAddVaccineModal()">
  <div class="modal modal-md">
    <div class="modal-header">
      <h3 class="modal-title">Add Past Vaccine Record</h3>
      <button class="modal-close" onclick="closeAddVaccineModal()">✕</button>
    </div>
    <form id="pastVaccineForm" action="{{ route('doctor.children.addVaccine', $child) }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="section-hint" style="background:var(--blue-light);color:var(--blue);border-color:rgba(61,107,114,.3);margin-bottom:16px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Record a vaccine shot from a different clinic or healthcare facility (past vaccination).
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Vaccine <span style="color:var(--red);">*</span></label>
            <select name="vaccine_id" class="form-control" required>
              <option value="">— Select Vaccine —</option>
              @foreach($vaccines as $v)
                <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->type }})</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Dose Number <span style="color:var(--red);">*</span></label>
            <input type="number" name="dose_number" class="form-control" value="1" min="1" max="10" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Vaccination Date <span style="color:var(--red);">*</span></label>
            <input type="date" name="vaccine_date" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Clinic / Healthcare Facility</label>
            <input type="text" name="clinic_name" class="form-control" placeholder="e.g., ABC Clinic, Health Center" maxlength="100" pattern="[a-zA-Z0-9\s,.\-]+" title="Only letters, numbers, and basic punctuation allowed">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Dose Given</label>
            <input type="text" name="dose_given" class="form-control" placeholder="e.g., 0.5ml" maxlength="50" pattern="[a-zA-Z0-9.\s\-]+" title="Only letters, numbers, dots, and hyphens allowed">
          </div>
          <div class="form-group">
            <label>Route</label>
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
          <div class="form-group">
            <label>Injection Site</label>
            <input type="text" name="injection_site" class="form-control" placeholder="e.g., Right thigh" maxlength="100" pattern="[a-zA-Z0-9\s\-]+" title="Only letters, numbers, and hyphens allowed">
          </div>
          <div class="form-group">
            <label>Batch/Lot Number</label>
            <input type="text" name="batch_number" class="form-control" placeholder="Optional" maxlength="100" pattern="[a-zA-Z0-9\-\.]+" title="Only letters, numbers, hyphens, and dots allowed">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Expiration Date</label>
            <input type="date" name="vaccine_expiration" class="form-control">
          </div>
          <div class="form-group">
            <label>Administered By</label>
            <input type="text" name="administered_by" class="form-control" placeholder="e.g., Dr. Name" maxlength="100" pattern="[a-zA-Z\s.]+" title="Only letters, spaces, and dots allowed">
          </div>
        </div>

        <div class="form-group">
          <label>Notes</label>
          <textarea name="vaccine_notes" class="form-control" placeholder="Optional notes about the vaccination..." rows="2" maxlength="500"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeAddVaccineModal()">Cancel</button>
        <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Save Vaccine Record
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openAddVaccineModal() {
  document.getElementById('addPastVaccineModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeAddVaccineModal() {
  document.getElementById('addPastVaccineModal').classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('pastVaccineForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const form = this;
  const formData = new FormData(form);
  
  fetch(form.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => {
    console.log('Response status:', response.status);
    if (!response.ok) {
      return response.text().then(text => {
        throw new Error(`HTTP ${response.status}: ${text || 'Unknown error'}`);
      });
    }
    return response.text().then(text => {
      try {
        return JSON.parse(text);
      } catch (e) {
        console.error('Failed to parse JSON:', text);
        throw new Error('Server returned invalid JSON: ' + text.substring(0, 100));
      }
    });
  })
  .then(data => {
    if (data.success) {
      alert('✅ Vaccine record added successfully!');
      closeAddVaccineModal();
      form.reset();
      location.reload();
    } else {
      alert('❌ Error: ' + (data.message || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Fetch error:', error);
    alert('❌ An error occurred while saving the record.\n\nError: ' + error.message);
  });
});
</script>
@endsection