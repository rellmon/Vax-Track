<?php $__env->startSection('page-title', 'Edit Child'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:680px;">
  <a href="<?php echo e(route('doctor.children.show', $child)); ?>" class="btn btn-secondary mb-4" style="display:inline-flex;align-items:center;gap:7px;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Profile
  </a>
  <div class="card">
    <div class="card-header">
      <span class="card-title" style="display:flex;align-items:center;gap:8px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
        Edit — <?php echo e($child->full_name); ?>

      </span>
    </div>
    <div class="card-body">
      <form action="<?php echo e(route('doctor.children.update', $child)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-row">
          <div class="form-group"><label>First Name</label><input type="text" name="first_name" class="form-control" value="<?php echo e($child->first_name); ?>" maxlength="50" required></div>
          <div class="form-group"><label>Last Name</label><input type="text" name="last_name" class="form-control" value="<?php echo e($child->last_name); ?>" maxlength="50" required></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" class="form-control" value="<?php echo e($child->dob); ?>" required></div>
          <div class="form-group"><label>Gender</label>
            <select name="gender" class="form-control" required>
              <option value="">— Select —</option>
              <option value="Male" <?php echo e($child->gender==='Male'?'selected':''); ?>>Male</option>
              <option value="Female" <?php echo e($child->gender==='Female'?'selected':''); ?>>Female</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Blood Type</label>
            <select name="blood_type" class="form-control">
              <option value="">Unknown</option>
              <?php $__currentLoopData = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php echo e($child->blood_type===$bt?'selected':''); ?>><?php echo e($bt); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div class="form-group"><label>Address</label><input type="text" name="address" class="form-control" value="<?php echo e($child->address); ?>" maxlength="255"></div>
        </div>
        <div class="form-group"><label>Notes / Allergies</label><textarea name="notes" class="form-control" rows="3" maxlength="500"><?php echo e($child->notes); ?></textarea></div>
        <div class="flex gap-2 mt-4">
          <a href="<?php echo e(route('doctor.children.show', $child)); ?>" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.doctor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/doctor/children-edit.blade.php ENDPATH**/ ?>