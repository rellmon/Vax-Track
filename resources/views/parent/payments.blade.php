{{-- ══ PARENT PAYMENTS ══ --}}
{{-- Save as: resources/views/parent/payments.blade.php --}}
@extends('layouts.parent')
@section('page-title', 'Payment History')
@section('content')
<div class="pay-stats-grid" style="grid-template-columns:1fr 1fr;max-width:500px;margin-bottom:22px;">
  <div class="pay-stat">
    <div class="pay-stat-label">Total Paid</div>
    <div class="pay-stat-val" style="color:var(--forest);">₱{{ number_format($totalPaid, 2) }}</div>
  </div>
  <div class="pay-stat">
    <div class="pay-stat-label">Transactions</div>
    <div class="pay-stat-val">{{ $payments->count() }}</div>
  </div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>Child</th><th>Vaccine</th><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($payments as $p)
          <tr>
            <td><strong>{{ $p->child?->full_name }}</strong></td>
            <td>{{ $p->schedule?->vaccine?->name ?? $p->notes ?? '—' }}</td>
            <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('F j, Y') }}</td>
            <td><strong>₱{{ number_format($p->amount, 2) }}</strong></td>
            <td>
              <span class="badge badge-teal" style="display:inline-flex;align-items:center;gap:4px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Cash
              </span>
            </td>
            <td><span class="badge {{ $p->status==='Paid'?'badge-green':'badge-amber' }}">{{ $p->status }}</span></td>
          </tr>
        @empty
          <tr><td colspan="6">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
              <p>No payment records.</p>
            </div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection