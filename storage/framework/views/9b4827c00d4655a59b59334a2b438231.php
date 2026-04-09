<?php $__env->startSection('sidebar-role', 'Doctor Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('user-initials', substr(session('doctor_name', 'DA'), 0, 1) . substr(strrchr(session('doctor_name', 'DA') . ' ', ' '), 1, 1)); ?>
<?php $__env->startSection('user-name', session('doctor_name', 'Dr. Admin')); ?>
<?php $__env->startSection('user-role', 'Pediatrician'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php $cur = request()->route()->getName(); ?>


<a href="<?php echo e(route('doctor.dashboard')); ?>"
   class="nav-item <?php echo e(str_starts_with($cur, 'doctor.dashboard') ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
      <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
    </svg>
  </span>
  <span class="nav-label">Dashboard</span>
</a>


<a href="<?php echo e(route('doctor.vaccines')); ?>"
   class="nav-item <?php echo e(str_starts_with($cur, 'doctor.vaccines') ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/>
      <path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/>
      <path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/>
    </svg>
  </span>
  <span class="nav-label">Vaccines</span>
</a>


<a href="<?php echo e(route('doctor.children')); ?>"
   class="nav-item <?php echo e(str_starts_with($cur, 'doctor.children') ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
      <circle cx="9" cy="7" r="4"/>
      <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
    </svg>
  </span>
  <span class="nav-label">Children</span>
</a>


<a href="<?php echo e(route('doctor.schedules')); ?>"
   class="nav-item <?php echo e(str_starts_with($cur, 'doctor.schedules') ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
      <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
      <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
    </svg>
  </span>
  <span class="nav-label">Schedules</span>
</a>


<a href="<?php echo e(route('doctor.payments')); ?>"
   class="nav-item <?php echo e(str_starts_with($cur, 'doctor.payments') ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <rect x="1" y="4" width="22" height="16" rx="2"/>
      <line x1="1" y1="10" x2="23" y2="10"/>
    </svg>
  </span>
  <span class="nav-label">Payments</span>
</a>


<a href="<?php echo e(route('doctor.reports')); ?>"
   class="nav-item <?php echo e(str_starts_with($cur, 'doctor.reports') ? 'active' : ''); ?>">
  <span class="icon">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
      <line x1="6" y1="20" x2="6" y2="14"/>
    </svg>
  </span>
  <span class="nav-label">Reports</span>
</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/layouts/doctor.blade.php ENDPATH**/ ?>