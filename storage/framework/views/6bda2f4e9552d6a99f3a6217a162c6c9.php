

<?php $__env->startSection('title', 'Edit Staff'); ?>
<?php $__env->startSection('page-title', 'Edit Staff Member: ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Staff Information</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.staff.update', $user)); ?>">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $user->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?php echo e($user->username); ?>" disabled>
                            <small class="text-muted">Username cannot be changed</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $user->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role *</label>
                            <select name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="Admin" <?php if(old('role', $user->role) == 'Admin'): ?> selected <?php endif; ?>>Admin</option>
                                <option value="Doctor" <?php if(old('role', $user->role) == 'Doctor'): ?> selected <?php endif; ?>>Doctor</option>
                                <option value="Staff" <?php if(old('role', $user->role) == 'Staff'): ?> selected <?php endif; ?>>Staff</option>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Staff
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reset Password -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Reset Password</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.staff.reset-password', $user)); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label">New Password *</label>
                            <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <small class="text-muted">Minimum 8 characters</small>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-lock"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Account Status -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 15px;">Account Status</h6>
                    <?php if($user->active): ?>
                        <div style="padding: 10px; background: #f0fdf4; border-radius: 6px; border-left: 3px solid #16a34a;">
                            <p style="margin: 0; color: #16a34a; font-weight: 600;">
                                <i class="bi bi-check-circle"></i> Active
                            </p>
                        </div>
                        <form method="POST" action="<?php echo e(route('admin.staff.deactivate', $user)); ?>" style="margin-top: 15px;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Are you sure you want to deactivate this account? They will not be able to login.')">
                                <i class="bi bi-x-circle"></i> Deactivate Account
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="padding: 10px; background: #fef2f2; border-radius: 6px; border-left: 3px solid #dc2626;">
                            <p style="margin: 0; color: #dc2626; font-weight: 600;">
                                <i class="bi bi-dash-circle"></i> Inactive
                            </p>
                        </div>
                        <form method="POST" action="<?php echo e(route('admin.staff.reactivate', $user)); ?>" style="margin-top: 15px;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle"></i> Reactivate Account
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 15px;">Quick Info</h6>
                    <div style="font-size: 0.875rem;">
                        <p style="margin-bottom: 10px;">
                            <strong>Created:</strong><br>
                            <?php echo e($user->created_at->format('M d, Y H:i')); ?>

                        </p>
                        <p style="margin-bottom: 10px;">
                            <strong>Last Updated:</strong><br>
                            <?php echo e($user->updated_at->format('M d, Y H:i')); ?>

                        </p>
                        <p>
                            <strong>Staff ID:</strong><br>
                            <?php echo e($user->id); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn btn-secondary w-100 mt-3">
                <i class="bi bi-arrow-left"></i> Back to Staff
            </a>
        </div>
    </div>
</div>

<!-- Reactivate Modal -->
<?php if(!$user->email): ?>
<div class="modal fade" id="reactivateModal" tabindex="-1" aria-labelledby="reactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.staff.reactivate', $user)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="reactivateModalLabel">Reactivate Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please enter a new email address to reactivate this account.</p>
                    <div class="mb-3">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Reactivate</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/staff/edit.blade.php ENDPATH**/ ?>