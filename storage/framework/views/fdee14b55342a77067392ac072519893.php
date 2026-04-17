<?php $__env->startSection('page-title', 'Vaccines'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-toolbar">
  <div class="page-toolbar-left">
    <form method="GET" action="<?php echo e(route('doctor.vaccines')); ?>" style="display:flex;align-items:center;gap:8px;">
      <div class="search-bar" style="width:280px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" placeholder="Search vaccines..." value="<?php echo e(request('search')); ?>">
      </div>
      <button type="submit" class="btn btn-secondary btn-sm">Search</button>
    </form>
  </div>
  <button class="btn btn-primary" onclick="document.getElementById('modal-add').classList.add('open')">+ Add Vaccine</button>
</div>

<div class="card">
  <div class="table-wrapper">
    <table>
      <thead><tr>
        <th>Vaccine Name</th><th>Category</th><th>Stock</th><th>Price</th>
        <th>Manufacturer</th><th>Status</th><th>Actions</th>
      </tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $vaccines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td>
              <strong><?php echo e($v->name); ?></strong>
              <?php if($v->description): ?>
                <div class="text-sm text-muted"><?php echo e(Str::limit($v->description, 55)); ?></div>
              <?php endif; ?>
            </td>
            <td><span class="badge badge-blue"><?php echo e($v->type); ?></span></td>
            <td><?php echo e($v->stock); ?> units</td>
            <td>₱<?php echo e(number_format($v->price, 2)); ?></td>
            <td><?php echo e($v->manufacturer); ?></td>
            <td><span class="badge <?php echo e($v->active ? 'badge-green' : 'badge-gray'); ?>"><?php echo e($v->active ? 'Active' : 'Inactive'); ?></span></td>
            <td>
              <div class="flex gap-2">
                <a href="<?php echo e(route('doctor.vaccines.edit', $v)); ?>" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:5px;">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                  Edit
                </a>
                <form action="<?php echo e(route('doctor.vaccines.destroy', $v)); ?>" method="POST" onsubmit="return confirm('Delete this vaccine?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-sm btn-danger" style="display:inline-flex;align-items:center;gap:5px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="7">
            <div class="empty-state">
              <div class="empty-icon"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" style="opacity:.4"><path d="M11 11 9.26 13.74a2.31 2.31 0 0 0 3.27 3.27L15 15"/><path d="m14 3-3.5 3.5"/><path d="M15 2l-1.5 1.5L17 7l1.5-1.5a2.12 2.12 0 0 0-3-3Z"/><path d="m3 21 6.5-6.5"/><path d="m7 7 10 10"/></svg></div>
              <p>No vaccines found. Add your first vaccine!</p>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Vaccine Modal -->
<div class="modal-overlay" id="modal-add" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="modal modal-md">
    <div class="modal-header">
      <h3 class="modal-title">Add New Vaccine</h3>
      <button class="modal-close" onclick="document.getElementById('modal-add').classList.remove('open')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <form action="<?php echo e(route('doctor.vaccines.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label>Vaccine Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. BCG" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" maxlength="100" required>
          </div>
          <div class="form-group">
            <label>Category / Type</label>
            <select name="type" class="form-control" required>
              <?php $__currentLoopData = ['Birth','6 weeks','10 weeks','14 weeks','9 months','12 months']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option><?php echo e($t); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock" class="form-control" placeholder="0" inputmode="numeric" min="0" max="99999" required pattern="[0-9]+" onkeypress="return /[0-9]/.test(String.fromCharCode(event.which))">
          </div>
          <div class="form-group">
            <label>Price (₱)</label>
            <input type="number" name="price" class="form-control" placeholder="0.00" inputmode="decimal" min="0" step="0.01" max="999999.99" required pattern="[0-9]+(\.[0-9]{1,2})?" onkeypress="return /[0-9.]/.test(String.fromCharCode(event.which))">
          </div>
        </div>
        <div class="form-group">
          <label>Manufacturer</label>
          <input type="text" name="manufacturer" class="form-control" placeholder="e.g. Sanofi Pasteur" pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed" maxlength="100" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" placeholder="Brief description..." rows="3" maxlength="500"></textarea>
        </div>
        <div class="toggle-wrap">
          <input type="checkbox" name="active" id="toggle-active" class="toggle-input" checked>
          <label for="toggle-active" class="toggle-label-ui"></label>
          <span style="font-size:13px;font-weight:500;color:var(--text2);">Active (Available for use)</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modal-add').classList.remove('open')">Cancel</button>
        <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Add Vaccine
        </button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/doctor/vaccines.blade.php ENDPATH**/ ?>