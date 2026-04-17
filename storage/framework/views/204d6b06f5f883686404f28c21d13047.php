<?php $__env->startSection('page-title', 'Reports'); ?>
<?php $__env->startSection('content'); ?>

<div class="section-grid">
  <!-- Generator -->
  <div class="card">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:8px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        Report Generator
      </span>
    </div>
    <div class="card-body">
      <form method="GET" action="<?php echo e(route('doctor.reports.generate')); ?>" id="report-form">
        <div class="form-group">
          <label>Report Type</label>
          <select name="type" class="form-control" id="rpt-type" onchange="togglePeriodDropdown()">
            <option value="vaccination" <?php echo e(($type??'')==='vaccination'?'selected':''); ?>>Vaccination Summary</option>
            <option value="inventory"   <?php echo e(($type??'')==='inventory'?'selected':''); ?>>Vaccine Inventory</option>
            <option value="financial"   <?php echo e(($type??'')==='financial'?'selected':''); ?>>Financial Summary</option>
            <option value="children"    <?php echo e(($type??'')==='children'?'selected':''); ?>>Children Registry</option>
          </select>
        </div>
        <div class="form-group" id="period-dropdown" style="display:none;">
          <label>Report Period</label>
          <select name="period" class="form-control" id="rpt-period" onchange="updateDateRange()">
            <option value="weekly"  <?php echo e(($period??'')==='weekly'?'selected':''); ?>>Weekly</option>
            <option value="monthly" <?php echo e(($period??'')==='monthly'?'selected':''); ?>>Monthly</option>
            <option value="yearly"  <?php echo e(($period??'')==='yearly'?'selected':''); ?>>Yearly</option>
          </select>
        </div>
        <div class="form-group" id="child-dropdown" style="display:none;">
          <label>Select Child</label>
          <select name="child_id" class="form-control" id="rpt-child">
            <option value="">— All Children —</option>
            <?php $__currentLoopData = $children ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($c->id); ?>" <?php echo e(($child_id??'')==$c->id?'selected':''); ?>><?php echo e($c->full_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Date From</label>
            <input type="date" name="from" class="form-control" id="date-from" value="<?php echo e($from ?? now()->subDays(30)->format('Y-m-d')); ?>">
          </div>
          <div class="form-group">
            <label>Date To</label>
            <input type="date" name="to" class="form-control" id="date-to" value="<?php echo e($to ?? now()->format('Y-m-d')); ?>">
          </div>
        </div>
        <div class="flex gap-2 mt-4">
          <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
            Preview Report
          </button>
          <?php if(isset($type)): ?>
            <a href="<?php echo e(route('doctor.reports.print', request()->all())); ?>" target="_blank" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:7px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
              Print Report
            </a>
          <?php endif; ?>
        </div>
      </form>
      <script>
      function togglePeriodDropdown() {
        const type = document.getElementById('rpt-type').value;
        document.getElementById('period-dropdown').style.display = type === 'financial' ? 'block' : 'none';
        document.getElementById('child-dropdown').style.display  = type === 'children'  ? 'block' : 'none';
      }
      function updateDateRange() {
        const period = document.getElementById('rpt-period').value;
        const today  = new Date();
        const from   = document.getElementById('date-from');
        const to     = document.getElementById('date-to');
        if (period === 'weekly')  { from.value = new Date(today - 7*86400000).toISOString().split('T')[0]; }
        else if (period === 'monthly') { from.value = new Date(today.getFullYear(), today.getMonth()-1, today.getDate()).toISOString().split('T')[0]; }
        else if (period === 'yearly')  { from.value = new Date(today.getFullYear()-1, today.getMonth(), today.getDate()).toISOString().split('T')[0]; }
        to.value = today.toISOString().split('T')[0];
      }
      window.addEventListener('load', togglePeriodDropdown);
      </script>
    </div>
  </div>

  <!-- Stats summary -->
  <div class="card">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:8px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Summary Info
      </span>
    </div>
    <div class="card-body" style="display:flex;flex-direction:column;gap:12px;">
      <div class="stat-card" style="padding:14px;">
        <div class="stat-icon teal">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div><div class="stat-label">Total Children</div><div class="stat-value" style="font-size:22px;"><?php echo e($stats['total_children']); ?></div></div>
      </div>
      <div class="stat-card" style="padding:14px;">
        <div class="stat-icon green">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg>
        </div>
        <div><div class="stat-label">Total Vaccinations</div><div class="stat-value" style="font-size:22px;"><?php echo e($stats['total_vaccinations']); ?></div></div>
      </div>
      <div class="stat-card" style="padding:14px;">
        <div class="stat-icon amber">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        </div>
        <div><div class="stat-label">Total Revenue</div><div class="stat-value" style="font-size:18px;">₱<?php echo e(number_format($stats['total_revenue'],2)); ?></div></div>
      </div>
    </div>
  </div>
</div>

<!-- Preview -->
<div class="card">
  <div class="card-header">
    <span class="card-title" style="display:flex;align-items:center;gap:8px;">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/></svg>
      Report Preview
    </span>
  </div>
  <div class="card-body">
    <?php if(!isset($type)): ?>
      <div class="empty-state">
        <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
        <p>Select a report type and click "Preview Report" to generate.</p>
      </div>
    <?php else: ?>
      <div class="report-preview">
        <div class="report-header">
          <h1>VaxTrack</h1>
          <p>
            <?php $typeLabels = ['vaccination'=>'Vaccination Summary','inventory'=>'Vaccine Inventory','financial'=>'Financial Summary','children'=>'Children Registry']; ?>
            <?php echo e($typeLabels[$type] ?? $type); ?>

            <?php if($type === 'children' && $child_id): ?>
              — <?php echo e(\App\Models\Child::find($child_id)?->full_name); ?>

            <?php endif; ?>
            <br>
            Period: <?php echo e(\Carbon\Carbon::parse($from)->format('M j, Y')); ?> — <?php echo e(\Carbon\Carbon::parse($to)->format('M j, Y')); ?><br>
            Generated: <?php echo e(now()->format('F j, Y g:i A')); ?>

          </p>
        </div>

        <?php if($type === 'vaccination'): ?>
          <div class="report-section">
            <h3>Vaccination Records (<?php echo e($data->count()); ?> total)</h3>
            <table><thead><tr><th>Child</th><th>Vaccine</th><th>Category</th><th>Date Given</th><th>Dose</th><th>Administered By</th></tr></thead><tbody>
              <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr><td><?php echo e($r->child?->full_name); ?></td><td><?php echo e($r->vaccine?->name); ?></td><td><?php echo e($r->vaccine?->type); ?></td><td><?php echo e(\Carbon\Carbon::parse($r->date_given)->format('M j, Y')); ?></td><td><?php echo e($r->dose_number); ?></td><td><?php echo e($r->administered_by); ?></td></tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center;color:var(--text3);">No records in this period.</td></tr>
              <?php endif; ?>
            </tbody></table>
          </div>

        <?php elseif($type === 'inventory'): ?>
          <div class="report-section">
            <h3>Vaccine Inventory (<?php echo e($data->count()); ?> vaccines)</h3>
            <table><thead><tr><th>Vaccine</th><th>Category</th><th>Stock</th><th>Price</th><th>Manufacturer</th><th>Status</th></tr></thead><tbody>
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr><td><?php echo e($v->name); ?></td><td><?php echo e($v->type); ?></td><td><?php echo e($v->stock); ?></td><td>₱<?php echo e(number_format($v->price,2)); ?></td><td><?php echo e($v->manufacturer); ?></td><td><?php echo e($v->active?'Active':'Inactive'); ?></td></tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody></table>
          </div>

        <?php elseif($type === 'financial'): ?>
          <div class="report-section">
            <h3>Financial Records (<?php echo e($data->count()); ?> payments)</h3>
            <table><thead><tr><th>Child</th><th>Vaccine</th><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead><tbody>
              <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr><td><?php echo e($p->child?->full_name); ?></td><td><?php echo e($p->schedule?->vaccine?->name ?? $p->notes ?? '—'); ?></td><td><?php echo e(\Carbon\Carbon::parse($p->payment_date)->format('M j, Y')); ?></td><td>₱<?php echo e(number_format($p->amount,2)); ?></td><td>Cash</td><td><?php echo e($p->status); ?></td></tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center;color:var(--text3);">No payments in this period.</td></tr>
              <?php endif; ?>
            </tbody></table>
            <p style="margin-top:12px;font-size:16px;font-weight:700;color:var(--forest);">Total: ₱<?php echo e(number_format($data->where('status','Paid')->sum('amount'),2)); ?></p>
          </div>

        <?php elseif($type === 'children'): ?>
          <div class="report-section">
            <h3><?php echo e($child_id ? 'Child Profile' : 'Children Registry'); ?> (<?php echo e($data->count()); ?> <?php echo e($data->count() === 1 ? 'patient' : 'patients'); ?>)</h3>
            <table><thead><tr><th>Name</th><th>DOB</th><th>Age</th><th>Gender</th><th>Blood Type</th><th>Parent</th></tr></thead><tbody>
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr><td><?php echo e($c->full_name); ?></td><td><?php echo e(\Carbon\Carbon::parse($c->dob)->format('M j, Y')); ?></td><td><?php echo e($c->age); ?></td><td><?php echo e($c->gender); ?></td><td><?php echo e($c->blood_type ?: '—'); ?></td><td><?php echo e($c->parent?->full_name ?? '—'); ?></td></tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody></table>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/doctor/reports.blade.php ENDPATH**/ ?>