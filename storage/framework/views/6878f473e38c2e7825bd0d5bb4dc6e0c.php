<?php $__env->startSection('page-title', 'Schedules'); ?>
<?php $__env->startSection('content'); ?>

<!-- SMS Log -->
<div class="card mb-4">
  <div class="card-header">
    <span class="card-title" style="display:flex;align-items:center;gap:8px;">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.19 6.19l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
      SMS Log
    </span>
    <span class="badge badge-teal"><?php echo e($smsLogs->count()); ?> messages</span>
    <?php if($smsLogs->count() > 0): ?>
      <form action="<?php echo e(route('doctor.schedules.sms-logs.clear')); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Clear all SMS logs? This cannot be undone.');">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-sm btn-danger" style="display:inline-flex;align-items:center;gap:5px;">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          Clear
        </button>
      </form>
    <?php endif; ?>
  </div>
  <div class="card-body">
    <div class="sms-log">
      <?php $__empty_1 = true; $__currentLoopData = $smsLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="sms-entry">
          <span class="sms-time">[<?php echo e($sms->created_at->format('M j, g:i A')); ?>]</span>
          <span class="sms-ok">✓ SMS <?php echo e(strtoupper($sms->type)); ?></span>
          <span class="sms-type">[<?php echo e($sms->type); ?>]</span>
          → <?php echo e($sms->phone); ?> — "<?php echo e(Str::limit($sms->message, 80)); ?>"
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <span style="color:var(--text3);">No SMS sent yet.</span>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="page-toolbar">
  <div class="page-toolbar-left">
    <form method="GET" action="<?php echo e(route('doctor.schedules')); ?>" style="display:flex;align-items:center;gap:8px;">
      <div class="search-bar" style="width:280px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" placeholder="Search by child name..." value="<?php echo e(request('search')); ?>">
      </div>
      <button type="submit" class="btn btn-secondary btn-sm">Search</button>
    </form>
  </div>
  <button class="btn btn-primary" onclick="document.getElementById('modal-add-schedule').classList.add('open')">+ Add Schedule</button>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr>
        <th>Child</th><th>Vaccine</th><th>Date</th><th>Time</th>
        <th>Status</th><th>SMS</th><th>Actions</th>
      </tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><strong><?php echo e($s->child?->full_name); ?></strong></td>
            <td><?php echo e($s->vaccine?->name); ?> <span class="badge badge-blue"><?php echo e($s->vaccine?->type); ?></span></td>
            <td><?php echo e(\Carbon\Carbon::parse($s->appointment_date)->format('M j, Y')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($s->appointment_time)->format('g:i A')); ?></td>
            <td>
              <form action="<?php echo e(route('doctor.schedules.status', $s)); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <select name="status" class="form-control" style="padding:4px 8px;font-size:12px;width:120px;" onchange="this.form.submit()">
                  <?php $__currentLoopData = ['Scheduled','Completed','Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e($s->status===$st?'selected':''); ?>><?php echo e($st); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </form>
            </td>
            <td><span class="badge <?php echo e($s->sms_sent?'badge-green':'badge-gray'); ?>"><?php echo e($s->sms_sent ? 'Sent' : 'Pending'); ?></span></td>
            <td>
              <div class="flex gap-2">
                <form action="<?php echo e(route('doctor.schedules.sms', $s)); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="btn btn-sm btn-success" style="display:inline-flex;align-items:center;gap:5px;" title="Send SMS Reminder">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.19 6.19l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                    SMS
                  </button>
                </form>
                <form action="<?php echo e(route('doctor.schedules.destroy', $s)); ?>" method="POST" onsubmit="return confirm('Delete this schedule?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-sm btn-danger" style="display:inline-flex;align-items:center;gap:5px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="7">
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

<!-- Add Schedule Modal -->
<div class="modal-overlay" id="modal-add-schedule" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="modal modal-lg">
    <div class="modal-header">
      <h3 class="modal-title">Create New Schedule</h3>
      <button class="modal-close" onclick="document.getElementById('modal-add-schedule').classList.remove('open')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <form action="<?php echo e(route('doctor.schedules.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="form-group">
          <label>Child / Patient</label>
          <select name="child_id" class="form-control" required>
            <option value="">— Select child —</option>
            <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>"><?php echo e($c->full_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="form-group">
          <label>Vaccine</label>
          <select name="vaccine_id" class="form-control" required>
            <option value="">— Select vaccine —</option>
            <?php $__currentLoopData = $vaccines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($v->id); ?>"><?php echo e($v->name); ?> (<?php echo e($v->type); ?>) — ₱<?php echo e(number_format($v->price,2)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="form-group">
          <label>Dose Number</label>
          <input type="number" name="dose_number" class="form-control" value="1" min="1" max="10" placeholder="1">
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Appointment Date</label>
            <input type="date" name="appointment_date" class="form-control" value="<?php echo e(request('date', today()->addDay()->format('Y-m-d'))); ?>" required>
          </div>
          <div class="form-group">
            <label>Time</label>
            <input type="time" name="appointment_time" class="form-control" value="09:00" required>
          </div>
        </div>
        <div class="form-group">
          <label>Dose Given</label>
          <input type="text" name="dose_given" class="form-control" placeholder="e.g., 0.5ml" maxlength="50">
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Route</label>
            <select name="vaccine_route" class="form-control">
              <option value="">Select Route</option>
              <option>Intramuscular (IM)</option>
              <option>Subcutaneous (SC)</option>
              <option>Oral (PO)</option>
              <option>Intradermal (ID)</option>
              <option>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Injection Site</label>
            <input type="text" name="injection_site" class="form-control" placeholder="e.g., Right thigh" maxlength="100">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Batch/Lot Number</label>
            <input type="text" name="batch_number" class="form-control" placeholder="Optional" maxlength="100">
          </div>
          <div class="form-group">
            <label>Expiration Date</label>
            <input type="date" name="vaccine_expiration" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="vaccine_status" class="form-control">
            <option>Completed</option>
            <option>Pending</option>
            <option>Missed</option>
            <option>Delayed</option>
          </select>
        </div>
        <div class="form-group">
          <label>Notes</label>
          <textarea name="notes" class="form-control" placeholder="Optional notes..." rows="2" maxlength="500"></textarea>
        </div>
        <div class="section-hint" style="display:flex;align-items:flex-start;gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.19 6.19l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
          An SMS reminder will be automatically sent to the parent when this schedule is created.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modal-add-schedule').classList.remove('open')">Cancel</button>
        <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/></svg>
          Create Schedule
        </button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/doctor/schedules.blade.php ENDPATH**/ ?>