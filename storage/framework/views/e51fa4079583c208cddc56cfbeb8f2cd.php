<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon teal">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>
    <div><div class="stat-label">Total Children</div><div class="stat-value"><?php echo e($totalChildren); ?></div><div class="stat-sub">Registered patients</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
    </div>
    <div><div class="stat-label">Available Vaccines</div><div class="stat-value"><?php echo e($availableVaccines); ?></div><div class="stat-sub">Active in inventory</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon amber">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div><div class="stat-label">Pending Schedules</div><div class="stat-value"><?php echo e($pendingSchedules); ?></div><div class="stat-sub">Upcoming appointments</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <div><div class="stat-label">Completed Today</div><div class="stat-value"><?php echo e($completedToday); ?></div><div class="stat-sub">Vaccinations done</div></div>
  </div>
</div>

<div class="section-grid-main">
  <!-- Calendar -->
  <div class="card">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:8px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Appointment Calendar
      </span>
    </div>
    <div class="card-body">
      <?php
        $monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $prevMonth = $month == 1 ? 12 : $month - 1;
        $prevYear  = $month == 1 ? $year - 1 : $year;
        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear  = $month == 12 ? $year + 1 : $year;
        $firstDay  = \Carbon\Carbon::create($year, $month, 1);
        $lastDay   = $firstDay->copy()->endOfMonth();
        $startDow  = $firstDay->dayOfWeek;
        $today     = now()->format('Y-m-d');
      ?>
      <div class="cal-nav">
        <a href="<?php echo e(route('doctor.dashboard', ['month'=>$prevMonth,'year'=>$prevYear])); ?>" class="cal-nav-btn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <span class="cal-month-label"><?php echo e($monthNames[$month-1]); ?> <?php echo e($year); ?></span>
        <a href="<?php echo e(route('doctor.dashboard', ['month'=>$nextMonth,'year'=>$nextYear])); ?>" class="cal-nav-btn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>
      <div class="calendar-grid">
        <?php $__currentLoopData = ['Su','Mo','Tu','We','Th','Fr','Sa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="cal-day-header"><?php echo e($d); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php for($i = 0; $i < $startDow; $i++): ?>
          <?php $pd = $firstDay->copy()->subDays($startDow - $i); ?>
          <a href="<?php echo e(route('doctor.schedules')); ?>" class="cal-day other-month"><?php echo e($pd->day); ?></a>
        <?php endfor; ?>
        <?php for($d = 1; $d <= $lastDay->day; $d++): ?>
          <?php
            $dateStr = \Carbon\Carbon::create($year, $month, $d)->format('Y-m-d');
            $isToday = $dateStr === $today;
            $hasEvent = isset($calendarEvents[$dateStr]);
          ?>
          <a href="<?php echo e(route('doctor.schedules')); ?>?date=<?php echo e($dateStr); ?>" class="cal-day <?php echo e($isToday ? 'today' : ''); ?> <?php echo e($hasEvent ? 'has-event' : ''); ?>"><?php echo e($d); ?></a>
        <?php endfor; ?>
        <?php $remaining = 42 - $startDow - $lastDay->day; ?>
        <?php for($d = 1; $d <= $remaining; $d++): ?>
          <a href="<?php echo e(route('doctor.schedules')); ?>" class="cal-day other-month"><?php echo e($d); ?></a>
        <?php endfor; ?>
      </div>
      <div style="margin-top:12px;display:flex;align-items:center;gap:12px;font-size:11px;color:var(--text3);">
        <span style="display:flex;align-items:center;gap:5px;">
          <span style="width:8px;height:8px;background:var(--amber);border-radius:50%;display:inline-block;"></span>
          Has appointment
        </span>
        <span>Click date to view schedules</span>
      </div>
    </div>
  </div>

  <!-- Right column -->
  <div style="display:flex;flex-direction:column;gap:20px;">
    <!-- Quick Actions -->
    <div class="card">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
          Quick Actions
        </span>
      </div>
      <div class="card-body">
        <div class="quick-actions-grid">
          <a href="<?php echo e(route('doctor.children.create')); ?>" class="quick-action">
            <span class="qa-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="16" y1="11" x2="22" y2="11"/></svg>
            </span>
            <div><div class="qa-text">Register Child</div><div class="qa-sub">Add new patient</div></div>
          </a>
          <a href="<?php echo e(route('doctor.vaccines')); ?>" class="quick-action">
            <span class="qa-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
            </span>
            <div><div class="qa-text">Add Vaccine</div><div class="qa-sub">New vaccine record</div></div>
          </a>
          <a href="<?php echo e(route('doctor.schedules')); ?>" class="quick-action">
            <span class="qa-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </span>
            <div><div class="qa-text">Create Schedule</div><div class="qa-sub">Set appointment</div></div>
          </a>
          <a href="<?php echo e(route('doctor.reports')); ?>" class="quick-action">
            <span class="qa-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </span>
            <div><div class="qa-text">Generate Report</div><div class="qa-sub">View analytics</div></div>
          </a>
        </div>
      </div>
    </div>

    <!-- Upcoming schedules -->
    <div class="card">
      <div class="card-header">
        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
          Upcoming This Week
        </span>
      </div>
      <div class="card-body" style="padding-top:8px;">
        <?php $__empty_1 = true; $__currentLoopData = $upcomingSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="schedule-item">
            <div class="sched-time"><?php echo e(\Carbon\Carbon::parse($s->appointment_time)->format('g:i A')); ?></div>
            <div style="flex:1">
              <div class="sched-name"><?php echo e($s->child?->full_name); ?></div>
              <div class="sched-vaccine"><?php echo e($s->vaccine?->name); ?> &bull; <?php echo e(\Carbon\Carbon::parse($s->appointment_date)->format('M j')); ?></div>
            </div>
            <span class="badge badge-amber">Scheduled</span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty-state">
            <div class="empty-icon">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <p>No upcoming schedules</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/doctor/dashboard.blade.php ENDPATH**/ ?>