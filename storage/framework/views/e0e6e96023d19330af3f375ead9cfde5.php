

<?php $__env->startSection('title', 'Staff Management'); ?>
<?php $__env->startSection('page-title', 'Staff & Doctor Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h6>Total Staff</h6>
                <div class="stat-value"><?php echo e($stats['total_staff']); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card success">
                <h6>Active Staff</h6>
                <div class="stat-value"><?php echo e($stats['active_staff']); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="<?php echo e(route('admin.staff.create')); ?>" class="btn btn-primary w-100" style="height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 600;">
                <i class="bi bi-plus-circle"></i> Add New Staff
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-4" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.staff.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search by Name/Email/Username</label>
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role); ?>" <?php if(request('role') == $role): ?> selected <?php endif; ?>>
                                <?php echo e($role); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Search
                    </button>
                </div>
                <div class="col-md-12">
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="table-responsive" style="box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 8px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Schedules</th>
                    <th>Vaccines Given</th>
                    <th>Audit Logs</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($user->name); ?></strong></td>
                        <td><?php echo e($user->username); ?></td>
                        <td>
                            <?php echo e($user->email); ?>

                        </td>
                        <td>
                            <?php if($user->active): ?>
                                <span class="badge" style="background: #f0fdf4; color: #16a34a;">
                                    <i class="bi bi-check-circle"></i> Active
                                </span>
                            <?php else: ?>
                                <span class="badge" style="background: #fef2f2; color: #dc2626;">
                                    <i class="bi bi-dash-circle"></i> Inactive
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge" style="<?php if($user->role === 'Admin'): ?> background: #fee2e2; color: #dc2626; <?php elseif($user->role === 'Doctor'): ?> background: rgba(82,121,111,.12); color: #52796f; <?php else: ?> background: #f0fdf4; color: #16a34a; <?php endif; ?>">
                                <?php echo e($user->role); ?>

                            </span>
                        </td>
                        <td><span class="badge" style="background: rgba(82,121,111,.12); color: #52796f;"><?php echo e($user->schedules_count ?? 0); ?></span></td>
                        <td><span class="badge" style="background: #fef3c7; color: #b45309;"><?php echo e($user->vaccine_records_count ?? 0); ?></span></td>
                        <td><span class="badge" style="background: #f3f4f6; color: #4b5563;"><?php echo e($user->audit_logs_count ?? 0); ?></span></td>
                        <td>
                            <small class="text-muted"><?php echo e($user->created_at->format('M d, Y')); ?></small>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="<?php echo e(route('admin.staff.show', $user)); ?>" class="btn btn-sm btn-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.staff.edit', $user)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            No staff members found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <?php echo e($users->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/staff/index.blade.php ENDPATH**/ ?>