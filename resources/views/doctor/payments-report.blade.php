<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="https://api.fontshare.com/v2/css?f[]=object-sans@400,600,700&display=swap" rel="stylesheet">
<title>Payment Report — VaxTrack</title>
<style>
body{font-family:'Object Sans',sans-serif;padding:32px;font-size:13px}
h1{color:#354f52;font-size:22px;margin-bottom:4px;display:flex;align-items:center;gap:8px}
p{color:#475569;margin-bottom:20px}
table{width:100%;border-collapse:collapse}
th{padding:8px 10px;background:#f0fdf4;color:#354f52;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;text-align:left;border:1px solid #e2e8f0}
td{padding:10px;border:1px solid #e2e8f0}
.total{text-align:right;font-size:18px;font-weight:700;color:#52796f;margin-top:16px}
</style>
</head>
<body>
<h1>
  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#354f52" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
  VaxTrack — Payment Report
</h1>
<p>Generated: {{ now()->format('F j, Y g:i A') }}</p>
<table>
  <thead><tr><th>#</th><th>Child</th><th>Vaccine</th><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
  <tbody>
    @foreach($payments as $i => $p)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $p->child?->full_name }}</td>
        <td>{{ $p->schedule?->vaccine?->name ?? $p->notes ?? '—' }}</td>
        <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('M j, Y') }}</td>
        <td>₱{{ number_format($p->amount, 2) }}</td>
        <td>Cash</td>
        <td>{{ $p->status }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="total">Total Revenue: ₱{{ number_format($totalRevenue, 2) }}</div>
<script>window.print();</script>
</body>
</html>