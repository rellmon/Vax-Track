

<?php $__env->startSection('title', 'Audit Logs'); ?>
<?php $__env->startSection('page-title', 'Audit & Activity Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h6>Total Logs</h6>
                <div class="stat-value"><?php echo e($stats['total_logs']); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h6>Today's Activities</h6>
                <div class="stat-value"><?php echo e($stats['today_logs']); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h6>This Month</h6>
                <div class="stat-value"><?php echo e($stats['this_month_logs']); ?></div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.audit-logs')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-select">
                        <option value="">All</option>
                        <?php $__currentLoopData = $userTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php if(request('user_type') == $type): ?> selected <?php endif; ?>>
                                <?php echo e($type); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Action</label>
                    <select name="action" class="form-select">
                        <option value="">All</option>
                        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($action); ?>" <?php if(request('action') == $action): ?> selected <?php endif; ?>>
                                <?php echo e($action); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Model Type</label>
                    <select name="model_type" class="form-select">
                        <option value="">All</option>
                        <?php $__currentLoopData = $modelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php if(request('model_type') == $type): ?> selected <?php endif; ?>>
                                <?php echo e($type); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <a href="<?php echo e(route('admin.audit-logs')); ?>" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <a href="<?php echo e(route('admin.audit-logs.export', request()->query())); ?>" class="btn btn-success w-100" target="_blank">
                        <i class="bi bi-download"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="table-responsive" style="box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 8px;">
        <table class="table">
            <thead>
                <tr>
                    <th>User Type</th>
                    <th>User ID</th>
                    <th>Action</th>
                    <th>Model</th>
                    <th>Model ID</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span class="badge" style="background: #d2dcc9; color: #52796f;">
                                <?php echo e($log->user_type); ?>

                            </span>
                        </td>
                        <td><?php echo e($log->user_id); ?></td>
                        <td>
                            <span class="badge" style="<?php if($log->action === 'Created'): ?> background: #dcfce7; color: #16a34a; <?php elseif($log->action === 'Updated'): ?> background: #fef3c7; color: #b45309; <?php else: ?> background: #fee2e2; color: #dc2626; <?php endif; ?>">
                                <?php echo e($log->action); ?>

                            </span>
                        </td>
                        <td><?php echo e($log->model_type); ?></td>
                        <td><?php echo e($log->model_id); ?></td>
                        <td>
                            <small class="text-muted"><?php echo e($log->ip_address); ?></small>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo e($log->created_at->format('M d, Y H:i')); ?></small>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.audit-logs.show', $log)); ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            No audit logs found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <?php echo e($logs->links('pagination::bootstrap-5')); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/audit-logs/index.blade.php ENDPATH**/ ?>