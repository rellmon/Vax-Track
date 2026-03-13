@extends('layouts.parent')
@section('page-title', 'Vaccination Records')
@section('content')
<div class="card">
  <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
    <span class="card-title">Vaccination History</span>
    <button type="button" class="btn btn-sm btn-primary" onclick="openPrintModal()" style="display:inline-flex;align-items:center;gap:5px;">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Print Records
    </button>
  </div>
  <div class="table-wrapper">
    <table>
      <thead><tr><th>Child</th><th>Vaccine</th><th>Category</th><th>Date Given</th><th>Dose</th><th>Administered By</th></tr></thead>
      <tbody>
        @forelse($records as $r)
          <tr>
            <td><strong>{{ $r->child?->full_name }}</strong></td>
            <td>{{ $r->vaccine?->name }}</td>
            <td><span class="badge badge-blue">{{ $r->vaccine?->type }}</span></td>
            <td>{{ \Carbon\Carbon::parse($r->date_given)->format('F j, Y') }}</td>
            <td>Dose {{ $r->dose_number }}</td>
            <td>{{ $r->administered_by }}</td>
          </tr>
        @empty
          <tr><td colspan="6">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg></div>
              <p>No vaccination records yet.</p>
            </div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Print Modal -->
<div id="printModal" class="custom-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
  <div class="custom-modal-content card" style="width:90%;max-width:500px;animation:slideUp .3s ease;">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-solid);">
      <h5 style="margin:0;">Print Vaccination Records</h5>
      <button type="button" onclick="closePrintModal()" style="background:none;border:none;font-size:24px;cursor:pointer;color:var(--text2);">&times;</button>
    </div>
    <div class="card-body">
      <div class="form-group" style="margin-bottom:20px;">
        <label style="margin-bottom:12px;display:block;font-weight:500;">Select which records to print:</label>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px;border:1px solid var(--border-solid);border-radius:8px;transition:all .2s;">
            <input type="radio" name="printOption" value="all" checked style="cursor:pointer;">
            <span>All children records</span>
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px;border:1px solid var(--border-solid);border-radius:8px;transition:all .2s;">
            <input type="radio" name="printOption" value="specific" style="cursor:pointer;">
            <span>Specific child only</span>
          </label>
        </div>
      </div>

      <div id="childSelectContainer" style="display:none;margin-bottom:20px;">
        <label style="margin-bottom:8px;display:block;font-weight:500;">Select child:</label>
        <select id="childSelect" class="form-control">
          @foreach($children as $child)
            <option value="{{ $child->id }}">{{ $child->full_name }}</option>
          @endforeach
        </select>
      </div>

      <div style="display:flex;gap:8px;justify-content:flex-end;">
        <button type="button" class="btn btn-secondary" onclick="closePrintModal()">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="handlePrint()">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:5px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Print
        </button>
      </div>
    </div>
  </div>
</div>

<style>
@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.custom-modal {
  display: none !important;
}

.custom-modal.active {
  display: flex !important;
}
</style>

<script>
function openPrintModal() {
  document.getElementById('printModal').classList.add('active');
}

function closePrintModal() {
  document.getElementById('printModal').classList.remove('active');
}

// Toggle child select visibility
document.querySelectorAll('input[name="printOption"]').forEach(radio => {
  radio.addEventListener('change', function() {
    const childSelectContainer = document.getElementById('childSelectContainer');
    if (this.value === 'specific') {
      childSelectContainer.style.display = 'block';
    } else {
      childSelectContainer.style.display = 'none';
    }
  });
});

// Close modal when clicking outside
document.getElementById('printModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closePrintModal();
  }
});

function handlePrint() {
  const printOption = document.querySelector('input[name="printOption"]:checked').value;
  let url = '{{ route("parent.print-records") }}?type=' + printOption;
  
  if (printOption === 'specific') {
    const childId = document.getElementById('childSelect').value;
    url += '&child_id=' + childId;
  }
  
  window.open(url, '_blank');
  closePrintModal();
}
</script>
@endsection