@extends('layouts.doctor')
@section('page-title', 'Payment Detail')
@section('content')
<div style="max-width:540px;">
  <a href="{{ route('doctor.payments') }}" class="btn btn-secondary mb-4" style="display:inline-flex;align-items:center;gap:7px;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Payments
  </a>
  <div class="card">
    <div class="card-header">
      <span class="card-title">Payment #{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span>
      <a href="{{ route('doctor.payments.invoice', $payment) }}" target="_blank" class="btn btn-sm btn-primary" style="display:inline-flex;align-items:center;gap:5px;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print Invoice
      </a>
    </div>
    <div class="card-body">
      <div class="info-grid">
        <div class="info-item"><label>Child</label><p>{{ $payment->child?->full_name }}</p></div>
        <div class="info-item"><label>Vaccine</label><p>{{ $payment->schedule?->vaccine?->name ?: '—' }}</p></div>
        <div class="info-item"><label>Date</label><p>{{ \Carbon\Carbon::parse($payment->payment_date)->format('F j, Y') }}</p></div>
        <div class="info-item"><label>Amount</label><p style="font-size:20px;font-weight:700;color:var(--forest);">₱{{ number_format($payment->amount, 2) }}</p></div>
        <div class="info-item"><label>Method</label>
          <p style="display:flex;align-items:center;gap:6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Cash
          </p>
        </div>
        <div class="info-item"><label>Status</label><p><span class="badge {{ $payment->status==='Paid'?'badge-green':'badge-amber' }}">{{ $payment->status }}</span></p></div>
        @if($payment->notes)
          <div class="info-item" style="grid-column:1/-1"><label>Notes</label><p>{{ $payment->notes }}</p></div>
        @endif
      </div>
      @if($payment->child?->parent)
        <div style="margin-top:16px;padding:12px 14px;background:var(--green-light);border-radius:10px;border:1px solid rgba(82,121,111,.2);">
          <div style="font-size:11px;font-weight:700;color:var(--forest-dark);margin-bottom:4px;text-transform:uppercase;letter-spacing:.06em;">Parent / Guardian</div>
          <div style="font-size:14px;font-weight:600;color:var(--text);">{{ $payment->child->parent->full_name }}</div>
          <div style="font-size:13px;color:var(--text2);">{{ $payment->child->parent->phone }}</div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection