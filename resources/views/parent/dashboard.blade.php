@extends('layouts.parent')
@section('page-title', 'My Children')
@section('content')

<style>
  .vaccine-booklet {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 24px;
    border: 2px solid #52796f;
  }

  .booklet-header {
    background: linear-gradient(135deg, #2f3e46 0%, #354f52 100%);
    padding: 28px;
    color: white;
  }

  .booklet-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 16px;
    display: flex;
    align-items:center;
    gap: 8px;
  }

  .booklet-info-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 0;
  }

  .info-field {
    font-size: 12px;
  }

  .info-field label {
    display: block;
    font-weight: 600;
    font-size: 10px;
    text-transform: uppercase;
    opacity: 0.85;
    margin-bottom: 4px;
  }

  .info-field value {
    display: block;
    font-size: 13px;
    font-weight: 500;
  }

  .booklet-content {
    padding: 0;
  }

  .vaccine-table-wrapper {
    overflow-x: auto;
  }

  .vaccine-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
  }

  .vaccine-table thead {
    background: #FFA500;
  }

  .vaccine-table th {
    padding: 14px 12px;
    color: white;
    font-weight: 700;
    font-size: 13px;
    text-align: left;
    border: 1px solid #FF8C00;
    background: #FFA500;
  }

  .vaccine-table td {
    padding: 12px;
    border: 1px solid #E8E8E8;
    font-size: 12px;
    background: white;
  }

  .vaccine-table tbody tr:nth-child(even) {
    background: #F9F9F9;
  }

  .vaccine-table tbody tr:hover {
    background: #F0F5F4;
  }

  .vaccine-name {
    font-weight: 600;
    color: #354f52;
  }

  .dose-badge {
    display: inline-block;
    background: #52796f;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
    min-width: 30px;
  }

  .status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
  }

  .status-done {
    background: #D1FAE5;
    color: #065F46;
  }

  .status-upcoming {
    background: #FEF3C7;
    color: #92400E;
  }

  .vaccine-row-done {
    background: #F0FDF4;
  }

  .vaccine-row-done td {
    background: #F0FDF4;
  }

  .vaccine-date {
    font-weight: 500;
    color: #52796f;
  }

  .booklet-footer {
    padding: 16px 28px;
    background: #F0FDF4;
    border-top: 2px solid #52796f;
    font-size: 11px;
    color: #52796f;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .next-appointment-banner {
    background: linear-gradient(135deg, rgba(82,121,111,0.1) 0%, rgba(82,121,111,0.05) 100%);
    padding: 14px 16px;
    margin: 0;
    border-bottom: 2px solid #52796f;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
  }

  .next-appointment-banner svg {
    color: #52796f;
    flex-shrink: 0;
  }

  @media (max-width: 768px) {
    .booklet-header {
      padding: 20px;
    }

    .booklet-info-section {
      grid-template-columns: 1fr;
    }

    .vaccine-table {
      font-size: 11px;
    }

    .vaccine-table th,
    .vaccine-table td {
      padding: 8px 6px;
      font-size: 11px;
    }
  }

  @media print {
    .vaccine-booklet {
      page-break-inside: avoid;
      box-shadow: none;
      border: 1px solid #ccc;
    }
  }
</style>

@forelse($children as $child)
  @php
    $records   = $child->vaccineRecords->sortBy('date_given');
    $nextSched = $child->schedules->where('status','Scheduled')->sortBy('appointment_date')->first();
  @endphp
  
  <div class="vaccine-booklet">
    {{-- Header with Child Info --}}
    <div class="booklet-header">
      <div class="booklet-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
        </svg>
        Child Immunization Record
      </div>
      <div class="booklet-info-section">
        <div class="info-field">
          <label>Child's Name</label>
          <value>{{ $child->full_name }}</value>
        </div>
        <div class="info-field">
          <label>Date of Birth</label>
          <value>{{ \Carbon\Carbon::parse($child->dob)->format('F j, Y') }}</value>
        </div>
        <div class="info-field">
          <label>Age</label>
          <value>{{ $child->age }}</value>
        </div>
        <div class="info-field">
          <label>Gender</label>
          <value>{{ ucfirst($child->gender) }}</value>
        </div>
        <div class="info-field">
          <label>Blood Type</label>
          <value>{{ $child->blood_type ?: 'Not recorded' }}</value>
        </div>
        <div class="info-field">
          <label>Address</label>
          <value>{{ $child->address ?: 'Not recorded' }}</value>
        </div>
      </div>
    </div>

    {{-- Next Appointment Banner --}}
    @if($nextSched)
      <div class="next-appointment-banner">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <div>
          <strong>Next Appointment:</strong> {{ $nextSched->vaccine?->name }} on {{ \Carbon\Carbon::parse($nextSched->appointment_date)->format('M j, Y') }} at {{ \Carbon\Carbon::parse($nextSched->appointment_time)->format('g:i A') }}
        </div>
      </div>
    @endif

    {{-- Vaccine Records Table --}}
    <div class="booklet-content">
      <div class="vaccine-table-wrapper">
        <table class="vaccine-table">
          <thead>
            <tr>
              <th>Vaccine</th>
              <th>Doses</th>
              <th>Date Given</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($vaccines as $vaccine)
              @php
                $vaccineRecord = $records->where('vaccine_id', $vaccine->id)->first();
              @endphp
              <tr class="{{ $vaccineRecord ? 'vaccine-row-done' : '' }}">
                <td class="vaccine-name">{{ $vaccine->name }}</td>
                <td style="text-align: center;">
                  @if($vaccineRecord)
                    <span class="dose-badge">{{ $vaccineRecord->dose_number }}</span>
                  @else
                    <span style="color: #999;">—</span>
                  @endif
                </td>
                <td class="vaccine-date">
                  @if($vaccineRecord)
                    {{ \Carbon\Carbon::parse($vaccineRecord->date_given)->format('m/d/Y') }}
                  @else
                    <span style="color: #999;">—</span>
                  @endif
                </td>
                <td>
                  @if($vaccineRecord)
                    <span class="status-badge status-done">Done</span>
                  @else
                    <span class="status-badge status-upcoming">Upcoming</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="empty-table-state">
                  <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3; margin-bottom: 8px; display: inline-block;">
                    <path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/>
                    <path d="m14 3-3.5 3.5"/>
                    <path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/>
                    <path d="m3 21 6.5-6.5"/>
                    <path d="m7 7 10 10"/>
                  </svg>
                  <div>No vaccines available</div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Footer --}}
    <div class="booklet-footer">
      <span>Total Vaccinations: <strong>{{ $records->count() }}</strong> / {{ $vaccines->count() }}</span>
      <span>Last Updated: {{ now()->format('M j, Y') }}</span>
    </div>

    {{-- Notes Section --}}
    @if($child->notes)
      <div style="padding: 16px 28px; background: #FAFAF9; border-top: 1px solid #E8E8E8;">
        <div style="font-size: 11px; font-weight: 600; color: #52796f; text-transform: uppercase; margin-bottom: 6px;">Notes</div>
        <div style="font-size: 13px; color: #2f3e46;">{{ $child->notes }}</div>
      </div>
    @endif
  </div>
@empty
  <div class="empty-state">
    <div class="empty-icon">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
    </div>
    <p>No children registered under your account. Please contact the clinic.</p>
  </div>
@endforelse
@endsection