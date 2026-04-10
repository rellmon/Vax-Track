@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

{{-- KPIs Grid (4 columns on desktop, responsive on mobile) --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon teal">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>
    <div><div class="stat-label">Total Children</div><div class="stat-value">{{ $totalChildren }}</div></div>
  </div>

  <div class="stat-card">
    <div class="stat-icon green">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/><path d="M12 6v6l4 2"/></svg>
    </div>
    <div><div class="stat-label">Coverage</div><div class="stat-value">{{ $vaccinesCoveragePercent }}%</div></div>
  </div>

  <div class="stat-card">
    <div class="stat-icon amber">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div><div class="stat-label">Upcoming</div><div class="stat-value">{{ $upcomingAppointments }}</div></div>
  </div>

  <div class="stat-card">
    <div class="stat-icon blue">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
    </div>
    <div><div class="stat-label">Revenue (Month)</div><div class="stat-value">₱{{ number_format($monthlyRevenue, 0) }}</div></div>
  </div>
</div>

{{-- Alerts & Summaries --}}
<div class="section-grid">
  <div>
    @if($lowStockVaccines->count() > 0)
      <div class="card mb-4">
        <div class="card-header">
          <span class="card-title">⚠️ Low Stock ({{ $lowStockVaccines->count() }})</span>
        </div>
        <div class="card-body" style="padding: 0;">
          <div style="max-height: 300px; overflow-y: auto;">
            @foreach($lowStockVaccines as $vaccine)
              <div style="padding: 12px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600;">{{ $vaccine->name }}</span>
                <span style="background: var(--red-light); color: var(--red); padding: 4px 8px; border-radius: 8px; font-weight: 700; font-size: 12px;">{{ $vaccine->stock }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    @if($overdueVaccinations->count() > 0)
      <div class="card mb-4">
        <div class="card-header">
          <span class="card-title">⏰ Overdue ({{ $overdueVaccinations->count() }})</span>
        </div>
        <div class="card-body" style="padding: 0;">
          <div style="max-height: 300px; overflow-y: auto;">
            @foreach($overdueVaccinations as $appt)
              <div style="padding: 12px 24px; border-bottom: 1px solid var(--border);">
                <div style="font-weight: 600;">{{ $appt->child->full_name ?? 'N/A' }}</div>
                <small style="color: var(--text3);">{{ $appt->appointment_date ? $appt->appointment_date->format('M d, Y') : 'N/A' }}</small>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    @if($pendingPayments->count() > 0)
      <div class="card">
        <div class="card-header">
          <span class="card-title">💰 Pending ({{ $pendingPayments->count() }})</span>
        </div>
        <div class="card-body" style="padding: 0;">
          <div style="max-height: 300px; overflow-y: auto;">
            @foreach($pendingPayments as $payment)
              <div style="padding: 12px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                <div>
                  <div style="font-weight: 600;">{{ $payment->child->full_name ?? 'N/A' }}</div>
                  <small style="color: var(--text3);">{{ $payment->schedule?->vaccine?->name ?? 'N/A' }}</small>
                </div>
                <div style="text-align: right;">₱{{ number_format($payment->amount, 2) }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif
  </div>

  <div>
    <div class="card mb-4">
      <div class="card-header">
        <span class="card-title">📊 Today's Summary</span>
      </div>
      <div class="card-body">
        <div class="info-grid">
          <div class="info-item">
            <label>Appointments</label>
            <p style="font-size: 20px; font-weight: 700; color: var(--forest);">{{ $todaySummary['appointments'] }}</p>
          </div>
          <div class="info-item">
            <label>Completed</label>
            <p style="font-size: 20px; font-weight: 700; color: var(--forest);">{{ $todaySummary['completed_appointments'] }}</p>
          </div>
          <div class="info-item">
            <label>New Register</label>
            <p style="font-size: 20px; font-weight: 700; color: var(--forest);">{{ $todaySummary['new_registrations'] }}</p>
          </div>
          <div class="info-item">
            <label>Active Staff</label>
            <p style="font-size: 20px; font-weight: 700; color: var(--forest);">{{ $activeStaff }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <span class="card-title">💳 Payment Status</span>
      </div>
      <div class="card-body">
        <div class="info-grid">
          <div class="info-item">
            <label>Paid</label>
            <p style="color: var(--forest); font-weight: 700;">₱{{ number_format($stats['total_revenue'], 0) }}</p>
          </div>
          <div class="info-item">
            <label>Pending</label>
            <p style="color: var(--amber); font-weight: 700;">₱{{ number_format($pendingPaymentsAmount, 0) }}</p>
          </div>
        </div>
        <div class="info-grid" style="margin-top: 16px;">
          <div class="info-item">
            <label>Unpaid</label>
            <p style="color: var(--red); font-weight: 700;">₱{{ number_format($stats['unpaid_amount'], 0) }}</p>
          </div>
          <div class="info-item">
            <label>Refunded</label>
            <p style="color: var(--blue); font-weight: 700;">₱{{ number_format($stats['refunded_amount'], 0) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
