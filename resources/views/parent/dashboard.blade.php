@extends('layouts.parent')
@section('page-title', 'My Children')
@section('content')

<div class="parent-header">
  <h2>Welcome, {{ session('parent_name') }}</h2>
  <p>Here's your children's health overview from VaxTrack Clinic</p>
</div>

@forelse($children as $child)
  @php
    $records   = $child->vaccineRecords;
    $nextSched = $child->schedules->where('status','Scheduled')->sortBy('appointment_date')->first();
  @endphp
  <div class="card mb-4">
    <div class="card-header">
      <div class="flex items-center gap-3">
        <div style="width:44px;height:44px;background:var(--forest);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;flex-shrink:0;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
          <div style="font-size:16px;font-weight:700;">{{ $child->full_name }}</div>
          <div style="font-size:12px;color:var(--text3);">{{ $child->age }} old &bull; {{ $child->gender }} &bull; {{ $child->blood_type ?: 'Unknown blood type' }}</div>
        </div>
      </div>
      <span class="badge badge-teal">DOB: {{ \Carbon\Carbon::parse($child->dob)->format('M j, Y') }}</span>
    </div>
    <div class="card-body">
      <div class="info-grid" style="margin-bottom:14px;">
        <div class="info-item">
          <label>Total Vaccinations</label>
          <p style="font-size:22px;font-weight:700;color:var(--forest);">{{ $records->count() }}</p>
        </div>
        <div class="info-item">
          <label>Next Appointment</label>
          <p>
            @if($nextSched)
              <strong>{{ $nextSched->vaccine?->name }}</strong> on {{ \Carbon\Carbon::parse($nextSched->appointment_date)->format('M j, Y') }} at {{ \Carbon\Carbon::parse($nextSched->appointment_time)->format('g:i A') }}
            @else
              No upcoming schedule
            @endif
          </p>
        </div>
      </div>
      @if($child->notes)
        <div style="padding:10px 14px;background:var(--green-light);border-radius:8px;font-size:13px;color:var(--forest-dark);display:flex;align-items:flex-start;gap:8px;border:1px solid rgba(82,121,111,.18);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/></svg>
          {{ $child->notes }}
        </div>
      @endif
    </div>
  </div>
@empty
  <div class="empty-state">
    <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
    <p>No children registered under your account. Please contact the clinic.</p>
  </div>
@endforelse
@endsection