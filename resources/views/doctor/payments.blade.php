@extends('layouts.doctor')
@section('page-title', 'Payments')
@section('content')

<style>
  .payment-stats-improved { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 28px; }
  .pay-stat-card { background: white; border: 1px solid var(--border-light); border-radius: 12px; padding: 24px; }
  .pay-stat-label-new { font-size: 13px; font-weight: 600; text-transform: uppercase; color: var(--text3); margin-bottom: 12px; letter-spacing: 0.5px; }
  .pay-stat-val-new { font-size: 32px; font-weight: 700; margin: 0; }
  .pay-stat-trend { font-size: 12px; color: var(--text3); margin-top: 8px; }
  .toolbar-improved { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
</style>

<div class="payment-stats-improved">
  <div class="pay-stat-card" style="border-left: 4px solid var(--forest);">
    <div class="pay-stat-label-new">Total Revenue</div>
    <p class="pay-stat-val-new" style="color: var(--forest);">₱{{ number_format($totalRevenue, 2) }}</p>
    <div class="pay-stat-trend">All-time total receipts</div>
  </div>
  <div class="pay-stat-card" style="border-left: 4px solid var(--amber);">
    <div class="pay-stat-label-new">Pending Collections</div>
    <p class="pay-stat-val-new" style="color: var(--amber);">₱{{ number_format($pendingTotal, 2) }}</p>
    <div class="pay-stat-trend">Awaiting payment</div>
  </div>
  <div class="pay-stat-card" style="border-left: 4px solid #22c55e;">
    <div class="pay-stat-label-new">Today's Revenue</div>
    <p class="pay-stat-val-new" style="color: #22c55e;">₱{{ number_format($todayRevenue, 2) }}</p>
    <div class="pay-stat-trend">{{ now()->format('F j, Y') }}</div>
  </div>
</div>

<div class="toolbar-improved">
  <div></div>
  <div style="display: flex; gap: 12px;">
    <a href="{{ route('doctor.payments.report') }}" target="_blank" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:8px;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Print Report
    </a>
    <button class="btn btn-primary" onclick="document.getElementById('modal-payment').classList.add('open')" style="display:inline-flex;align-items:center;gap:8px;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Process Payment
    </button>
  </div>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr>
        <th>Child</th><th>Vaccine / Service</th><th>Date</th>
        <th>Amount</th><th>Method</th><th>Status</th><th>Actions</th>
      </tr></thead>
      <tbody>
        @forelse($payments as $p)
          <tr>
            <td><strong>{{ $p->child?->full_name }}</strong></td>
            <td>{{ $p->schedule?->vaccine?->name ?: ($p->notes ?: '—') }}</td>
            <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('M j, Y') }}</td>
            <td><strong>₱{{ number_format($p->amount, 2) }}</strong></td>
            <td>
              <span class="badge badge-teal" style="display:inline-flex;align-items:center;gap:4px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Cash
              </span>
            </td>
            <td><span class="badge {{ $p->status==='Paid'?'badge-green':'badge-amber' }}">{{ $p->status }}</span></td>
            <td>
              <div class="flex gap-2">
                <a href="{{ route('doctor.payments.show', $p) }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                  View
                </a>
                <a href="{{ route('doctor.payments.invoice', $p) }}" target="_blank" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                  Invoice
                </a>
                @if($p->status === 'Pending')
                  <form action="{{ route('doctor.payments.status', $p) }}" method="POST" style="display:inline;">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="Paid">
                    <button type="submit" class="btn btn-sm btn-success" style="display:inline-flex;align-items:center;gap:5px;">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                      Mark Paid
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="7">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
              <p>No payments recorded yet.</p>
            </div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Process Payment Modal -->
<div class="modal-overlay" id="modal-payment" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="modal modal-md">
    <div class="modal-header">
      <h3 class="modal-title">Process Payment</h3>
      <button class="modal-close" onclick="document.getElementById('modal-payment').classList.remove('open')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <form action="{{ route('doctor.payments.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label>Select Schedule / Service</label>
          <select name="schedule_id" class="form-control" required id="pay-sched-sel" onchange="updateAmount(this)">
            <option value="">— Select unpaid schedule —</option>
            @foreach($unpaidSchedules as $s)
              <option value="{{ $s->id }}" data-price="{{ $s->vaccine?->price }}">
                {{ $s->child?->full_name }} — {{ $s->vaccine?->name }} ({{ \Carbon\Carbon::parse($s->appointment_date)->format('M j') }}) — ₱{{ number_format($s->vaccine?->price ?? 0, 2) }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Amount (₱)</label>
            <input type="number" name="amount" id="pay-amount" class="form-control" placeholder="0.00" inputmode="decimal" step="0.01" min="0" max="999999.99" required pattern="[0-9]+(\.[0-9]{1,2})?" onkeypress="return /[0-9.]/.test(String.fromCharCode(event.which))">
          </div>
          <div class="form-group">
            <label>Payment Method</label>
            <select name="method" class="form-control">
              <option>Cash</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Payment Date</label>
          <input type="date" name="payment_date" class="form-control" value="{{ today()->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="Paid">Paid</option>
            <option value="Pending">Pending</option>
          </select>
        </div>
        <div class="form-group">
          <label>Notes</label>
          <textarea name="notes" class="form-control" placeholder="Optional notes..." rows="2" maxlength="500" pattern="[a-zA-Z\s0-9,.\-']+" title="Only letters, numbers, and basic punctuation allowed"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modal-payment').classList.remove('open')">Cancel</button>
        <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          Process Payment
        </button>
      </div>
    </form>
  </div>
</div>

@section('scripts')
<script>
function updateAmount(sel) {
  const price = sel.options[sel.selectedIndex].dataset.price;
  if (price) document.getElementById('pay-amount').value = parseFloat(price).toFixed(2);
}
</script>
@endsection
@endsection