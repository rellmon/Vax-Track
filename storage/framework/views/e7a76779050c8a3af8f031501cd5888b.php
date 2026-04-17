<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="https://api.fontshare.com/v2/css?f[]=object-sans@400,600,700&display=swap" rel="stylesheet">
<title>Report — VaxTrack</title>
<style>
body{font-family:'Object Sans',sans-serif;padding:32px;font-size:13px}
h1{color:#354f52;font-size:22px;display:flex;align-items:center;gap:8px}
p{color:#475569;margin-bottom:20px;margin-top:4px}
h3{font-size:13px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid #e2e8f0}
table{width:100%;border-collapse:collapse;margin-bottom:16px}
th{padding:8px 10px;background:#f0fdf4;color:#354f52;font-size:11px;font-weight:700;text-transform:uppercase;text-align:left;border:1px solid #e2e8f0}
td{padding:10px;border:1px solid #e2e8f0}
.total{font-size:16px;font-weight:700;color:#52796f}
</style>
</head>
<body>
<h1>
  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#354f52" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
  VaxTrack — Report
</h1>
<p>Type: <?php echo e(['vaccination'=>'Vaccination Summary','inventory'=>'Vaccine Inventory','financial'=>'Financial Summary','children'=>'Children Registry'][$type] ?? $type); ?>

<?php if($type === 'children' && $child_id): ?>
  — <?php echo e(\App\Models\Child::find($child_id)?->full_name); ?>

<?php endif; ?>
<br>
Period: <?php echo e(\Carbon\Carbon::parse($from)->format('M j, Y')); ?> — <?php echo e(\Carbon\Carbon::parse($to)->format('M j, Y')); ?><br>
Generated: <?php echo e(now()->format('F j, Y g:i A')); ?></p>

<?php if($type==='vaccination'): ?>
  <h3>Vaccination Records</h3>
  <table><thead><tr><th>Child</th><th>Vaccine</th><th>Category</th><th>Date</th><th>Dose</th><th>By</th></tr></thead><tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($r->child?->full_name); ?></td><td><?php echo e($r->vaccine?->name); ?></td><td><?php echo e($r->vaccine?->type); ?></td><td><?php echo e(\Carbon\Carbon::parse($r->date_given)->format('M j, Y')); ?></td><td><?php echo e($r->dose_number); ?></td><td><?php echo e($r->administered_by); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody></table>
<?php elseif($type==='inventory'): ?>
  <h3>Vaccine Inventory</h3>
  <table><thead><tr><th>Vaccine</th><th>Type</th><th>Stock</th><th>Price</th><th>Manufacturer</th><th>Status</th></tr></thead><tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($v->name); ?></td><td><?php echo e($v->type); ?></td><td><?php echo e($v->stock); ?></td><td>₱<?php echo e(number_format($v->price,2)); ?></td><td><?php echo e($v->manufacturer); ?></td><td><?php echo e($v->active?'Active':'Inactive'); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody></table>
<?php elseif($type==='financial'): ?>
  <h3>Financial Summary</h3>
  <table><thead><tr><th>Child</th><th>Vaccine</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead><tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($p->child?->full_name); ?></td><td><?php echo e($p->schedule?->vaccine?->name ?? '—'); ?></td><td><?php echo e(\Carbon\Carbon::parse($p->payment_date)->format('M j, Y')); ?></td><td>₱<?php echo e(number_format($p->amount,2)); ?></td><td><?php echo e($p->status); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody></table>
  <p class="total">Total Revenue: ₱<?php echo e(number_format($data->where('status','Paid')->sum('amount'),2)); ?></p>
<?php elseif($type==='children'): ?>
  <h3><?php echo e($child_id ? 'Child Profile' : 'Children Registry'); ?></h3>
  <table><thead><tr><th>Name</th><th>DOB</th><th>Age</th><th>Gender</th><th>Blood Type</th><th>Parent</th></tr></thead><tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($c->full_name); ?></td><td><?php echo e(\Carbon\Carbon::parse($c->dob)->format('M j, Y')); ?></td><td><?php echo e($c->age); ?></td><td><?php echo e($c->gender); ?></td><td><?php echo e($c->blood_type ?: '—'); ?></td><td><?php echo e($c->parent?->full_name ?? '—'); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody></table>
<?php endif; ?>
<script>window.print();</script>
</body>
</html><?php /**PATH D:\vacctrack\resources\views/doctor/reports-print.blade.php ENDPATH**/ ?>