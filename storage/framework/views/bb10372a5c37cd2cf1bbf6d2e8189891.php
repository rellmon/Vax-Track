<?php $__env->startSection('page-title', 'Children'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-toolbar">
  <div class="page-toolbar-left">
    <form method="GET" action="<?php echo e(route('doctor.children')); ?>" style="display:flex;align-items:center;gap:8px;">
      <div class="search-bar" style="width:280px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" placeholder="Search children..." value="<?php echo e(request('search')); ?>">
      </div>
      <button type="submit" class="btn btn-secondary btn-sm">Search</button>
    </form>
  </div>
  <div class="flex gap-2">
    <a href="<?php echo e(route('doctor.children.create-existing')); ?>" class="btn btn-secondary" style="display:flex;align-items:center;gap:7px;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Existing Parent
    </a>
    <a href="<?php echo e(route('doctor.children.create')); ?>" class="btn btn-primary">+ Register New Child</a>
  </div>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr>
        <th>Child Name</th><th>Date of Birth</th><th>Age</th><th>Gender</th>
        <th>Blood Type</th><th>Parent / Guardian</th><th>Actions</th>
      </tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><strong><?php echo e($c->full_name); ?></strong></td>
            <td><?php echo e(\Carbon\Carbon::parse($c->dob)->format('M j, Y')); ?></td>
            <td><span class="badge badge-blue"><?php echo e($c->age); ?></span></td>
            <td><?php echo e($c->gender); ?></td>
            <td><?php echo e($c->blood_type ?: '—'); ?></td>
            <td><?php echo e($c->parent ? $c->parent->full_name : '—'); ?></td>
            <td>
              <div class="flex gap-2">
                <a href="<?php echo e(route('doctor.children.show', $c)); ?>" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                  View
                </a>
                <a href="<?php echo e(route('doctor.children.edit', $c)); ?>" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                  Edit
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="7">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
              <p>No children registered yet.</p>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/doctor/children.blade.php ENDPATH**/ ?>