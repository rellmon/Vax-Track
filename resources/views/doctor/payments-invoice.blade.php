<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice #{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }} — VaxTrack</title>
<link href="https://api.fontshare.com/v2/css?f[]=object-sans@400,600,700&f[]=instrument-serif@400&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Object Sans',sans-serif;padding:40px;color:#0f172a;font-size:14px}
h1{font-family:'Instrument Serif',serif;color:#354f52;font-size:28px;font-weight:400;display:flex;align-items:center;gap:10px}
.header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px}
.brand p{color:#475569;font-size:13px;margin-top:6px;line-height:1.7}
.inv-label{font-size:24px;font-weight:700;color:#52796f}
.inv-num{color:#64748b;font-size:13px;margin-top:4px}
hr{border:none;border-top:2px solid #52796f;margin:24px 0}
.bill-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:28px}
.bill-label{font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;font-weight:700;margin-bottom:4px}
.bill-name{font-size:15px;font-weight:700}
.bill-sub{font-size:13px;color:#64748b;margin-top:2px}
table{width:100%;border-collapse:collapse;margin-bottom:20px}
thead th{padding:10px 12px;background:#f0fdf4;color:#354f52;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;text-align:left;border:1px solid #e2e8f0}
tbody td{padding:12px;border:1px solid #e2e8f0;font-size:14px}
.total-row{text-align:right;margin-top:12px}
.total-label{font-size:13px;color:#64748b}
.total-val{font-family:'Instrument Serif',serif;font-size:26px;color:#52796f;font-weight:400}
.footer{text-align:center;margin-top:32px;font-size:12px;color:#94a3b8;border-top:1px solid #e2e8f0;padding-top:16px}
</style>
</head>
<body>
<div class="header">
  <div class="brand">
    <h1>
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#354f52" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
      VaxTrack
    </h1>
    <p>Pediatric Vaccine Management System<br>
    Pasig City, Metro Manila, Philippines<br>
    <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f482959797808695979fb497989d9a9d97da849c">[email&#160;protected]</a> | (02) XXX-XXXX</p>
  </div>
  <div style="text-align:right;">
    <div class="inv-label">INVOICE</div>
    <div class="inv-num">#{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}</div>
    <div class="inv-num">{{ \Carbon\Carbon::parse($payment->payment_date)->format('F j, Y') }}</div>
  </div>
</div>
<hr>
<div class="bill-grid">
  <div>
    <div class="bill-label">Bill To</div>
    <div class="bill-name">{{ $payment->child?->parent?->full_name ?? '—' }}</div>
    <div class="bill-sub">{{ $payment->child?->parent?->phone }}</div>
    <div class="bill-sub">{{ $payment->child?->parent?->email }}</div>
  </div>
  <div>
    <div class="bill-label">Patient</div>
    <div class="bill-name">{{ $payment->child?->full_name }}</div>
    <div class="bill-sub">DOB: {{ \Carbon\Carbon::parse($payment->child?->dob)->format('F j, Y') }}</div>
  </div>
</div>
<table>
  <thead><tr><th>Description</th><th>Category</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
  <tbody>
    <tr>
      <td>{{ $payment->schedule?->vaccine?->name ?? 'Vaccination Service' }}</td>
      <td>{{ $payment->schedule?->vaccine?->type ?? '—' }}</td>
      <td>1</td>
      <td>₱{{ number_format($payment->amount, 2) }}</td>
      <td>₱{{ number_format($payment->amount, 2) }}</td>
    </tr>
  </tbody>
</table>
<div class="total-row">
  <div class="total-label">Total Amount Due</div>
  <div class="total-val">₱{{ number_format($payment->amount, 2) }}</div>
  <div style="font-size:12px;color:#94a3b8;margin-top:4px;">Payment Method: Cash &nbsp;|&nbsp; Status: {{ $payment->status }}</div>
</div>
<div class="footer">
  Thank you for trusting VaxTrack for your child's health.<b