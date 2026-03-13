<?php $__env->startSection('page-title', 'My Schedules'); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr><th>Child</th><th>Vaccine</th><th>Category</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><strong><?php echo e($s->child?->full_name); ?></strong></td>
            <td><?php echo e($s->vaccine?->name); ?></td>
            <td><span class="badge badge-blue"><?php echo e($s->vaccine?->type); ?></span></td>
            <td><?php echo e(\Carbon\Carbon::parse($s->appointment_date)->format('F j, Y')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($s->appointment_time)->format('g:i A')); ?></td>
            <td><span class="badge <?php echo e($s->status==='Completed'?'badge-green':($s->status==='Cancelled'?'badge-red':'badge-amber')); ?>"><?php echo e($s->status); ?></span></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="6">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
              <p>No schedules found.</p>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.parent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/parent/schedules.blade.php ENDPATH**/ ?>