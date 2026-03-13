<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://api.fontshare.com/v2/css?f[]=object-sans@400,600,700&display=swap" rel="stylesheet">
<title>{{ $title }} — VaxTrack</title>
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Object Sans', sans-serif;
  padding: 40px;
  font-size: 13px;
  color: #475569;
  background: #fff;
}

.header {
  margin-bottom: 32px;
  padding-bottom: 20px;
  border-bottom: 2px solid #e2e8f0;
}

.header-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

h1 {
  color: #354f52;
  font-size: 24px;
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
}

.header-info {
  font-size: 12px;
  color: #64748b;
}

.info-row {
  margin: 4px 0;
}

.info-label {
  font-weight: 600;
  color: #475569;
}

.table-section {
  margin-bottom: 32px;
}

.section-title {
  font-size: 12px;
  font-weight: 700;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 12px;
  padding-bottom: 8px;
  border-bottom: 2px solid #e2e8f0;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 16px;
}

thead {
  background: #f0fdf4;
}

th {
  padding: 10px;
  background: #f0fdf4;
  color: #354f52;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  text-align: left;
  border: 1px solid #e2e8f0;
}

td {
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-right: 1px solid #e2e8f0;
}

tbody tr:nth-child(even) {
  background: #f8fafc;
}

.vaccine-badge {
  display: inline-block;
  background: #dbeafe;
  color: #1e40af;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 600;
}

.empty-message {
  text-align: center;
  padding: 40px 20px;
  color: #94a3b8;
  font-size: 14px;
}

.footer {
  margin-top: 40px;
  padding-top: 20px;
  border-top: 1px solid #e2e8f0;
  text-align: center;
  font-size: 11px;
  color: #94a3b8;
}

@media print {
  body {
    padding: 0;
  }
  
  .no-print {
    display: none !important;
  }
}

@page {
  size: A4;
  margin: 20mm;
}
</style>
</head>
<body>

<div class="header">
  <div class="header-top">
    <h1>
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#354f52" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/>
        <path d="m14 3-3.5 3.5"/>
        <path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/>
        <path d="m3 21 6.5-6.5"/>
        <path d="m7 7 10 10"/>
      </svg>
      {{ $title }}
    </h1>
  </div>
  <div class="header-info">
    <div class="info-row">
      <span class="info-label">Parent/Guardian:</span> {{ $parentName }}
    </div>
    <div class="info-row">
      <span class="info-label">Document Generated:</span> {{ now()->format('F j, Y \a\t g:i A') }}
    </div>
    <div class="info-row">
      <span class="info-label">Clinic:</span> VaxTrack Clinic
    </div>
  </div>
</div>

@if($records->isEmpty())
  <div class="empty-message">
    <p>No vaccination records found.</p>
  </div>
@else
  @php
    $groupedByChild = $records->groupBy('child_id');
  @endphp

  @foreach($groupedByChild as $childId => $childRecords)
    @php
      $child = $childRecords->first()?->child;
    @endphp
    
    <div class="table-section">
      <div class="section-title">
        {{ $child?->full_name }} 
        @if($groupedByChild->count() > 1)
          — DOB: {{ $child ? \Carbon\Carbon::parse($child->dob)->format('M j, Y') : 'Unknown' }}
        @endif
      </div>
      
      <table>
        <thead>
          <tr>
            <th>Vaccine Name</th>
            <th>Type</th>
            <th>Date Given</th>
            <th>Dose #</th>
            <th>Administered By</th>
          </tr>
        </thead>
        <tbody>
          @foreach($childRecords as $record)
            <tr>
              <td><strong>{{ $record->vaccine?->name ?? '—' }}</strong></td>
              <td><span class="vaccine-badge">{{ $record->vaccine?->type ?? '—' }}</span></td>
              <td>{{ \Carbon\Carbon::parse($record->date_given)->format('F j, Y') }}</td>
              <td>{{ $record->dose_number }}</td>
              <td>{{ $record->administered_by ?? '—' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div style="margin-top: 16px; padding: 12px; background: #f0fdf4; border-radius: 6px; border-left: 3px solid #22c55e;">
        <strong style="color: #354f52;">Summary:</strong>
        <div style="color: #475569; font-size: 12px; margin-top: 6px;">
          Total Vaccines Received: <strong>{{ $childRecords->count() }}</strong>
        </div>
      </div>
    </div>
  @endforeach

  <div class="footer">
    <p>This is an official vaccination record from VaxTrack Clinic.</p>
    <p style="margin-top: 8px;">For inquiries or discrepancies, please contact the clinic directly.</p>
  </div>
@endif

<script>
  // Auto-print when page loads
  window.addEventListener('load', function() {
    window.print();
  });
</script>

</body>
</html>
