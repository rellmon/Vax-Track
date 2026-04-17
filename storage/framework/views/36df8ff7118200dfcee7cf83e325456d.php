<?php $__env->startSection('sidebar-role', 'Parent Portal'); ?>
<?php $__env->startSection('page-title', 'My Children'); ?>
<?php $__env->startSection('user-initials', substr(session('parent_name', 'PA'), 0, 1) . substr(strrchr(session('parent_name', 'PA') . ' ', ' '), 1, 1)); ?>
<?php $__env->startSection('user-name', session('parent_name', 'Parent')); ?>
<?php $__env->startSection('user-role', 'Parent / Guardian'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php $cur = request()->route()->getName(); ?>


<a href="<?php echo e(route('parent.dashboard')); ?>"
   class="nav-item <?php echo e($cur === 'parent.dashboard' ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
      <circle cx="9" cy="7" r="4"/>
      <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
    </svg>
  </span>
  <span class="nav-label">My Children</span>
</a>


<a href="<?php echo e(route('parent.schedules')); ?>"
   class="nav-item <?php echo e($cur === 'parent.schedules' ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
      <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
      <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
    </svg>
  </span>
  <span class="nav-label">Schedules</span>
</a>


<a href="<?php echo e(route('parent.records')); ?>"
   class="nav-item <?php echo e($cur === 'parent.records' ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
      <polyline points="14 2 14 8 20 8"/>
      <line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/>
      <polyline points="9 9 10 9 11 9"/>
    </svg>
  </span>
  <span class="nav-label">Records</span>
</a>


<a href="<?php echo e(route('parent.payments')); ?>"
   class="nav-item <?php echo e($cur === 'parent.payments' ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="1" y="4" width="22" height="16" rx="2"/>
      <line x1="1" y1="10" x2="23" y2="10"/>
    </svg>
  </span>
  <span class="nav-label">Payments</span>
</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/layouts/parent.blade.php ENDPATH**/ ?>