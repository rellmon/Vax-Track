<?php $__env->startSection('page-title', 'Payment History'); ?>
<?php $__env->startSection('content'); ?>
<div class="pay-stats-grid" style="grid-template-columns:1fr 1fr;max-width:500px;margin-bottom:22px;">
  <div class="pay-stat">
    <div class="pay-stat-label">Total Paid</div>
    <div class="pay-stat-val" style="color:var(--forest);">₱<?php echo e(number_format($totalPaid, 2)); ?></div>
  </div>
  <div class="pay-stat">
    <div class="pay-stat-label">Transactions</div>
    <div class="pay-stat-val"><?php echo e($payments->count()); ?></div>
  </div>
</div>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>Child</th><th>Vaccine</th><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><strong><?php echo e($p->child?->full_name); ?></strong></td>
            <td><?php echo e($p->schedule?->vaccine?->name ?? $p->notes ?? '—'); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($p->payment_date)->format('F j, Y')); ?></td>
            <td><strong>₱<?php echo e(number_format($p->amount, 2)); ?></strong></td>
            <td>
              <span class="badge badge-teal" style="display:inline-flex;align-items:center;gap:4px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Cash
              </span>
            </td>
            <td><span class="badge <?php echo e($p->status==='Paid'?'badge-green':'badge-amber'); ?>"><?php echo e($p->status); ?></span></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="6">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
              <p>No payment records.</p>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.parent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/parent/payments.blade.php ENDPATH**/ ?>