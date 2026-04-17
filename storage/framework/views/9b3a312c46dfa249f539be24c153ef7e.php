

<?php $__env->startSection('page-title', 'Scheduled Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 style="color: #52796f; font-weight: 600;"><i class="bi bi-calendar-event"></i> Scheduled Reports</h2>
            <p class="text-muted">Automated report delivery to email recipients</p>
        </div>
        <div class="col-lg-4 text-end">
            <a href="<?php echo e(route('admin.scheduled-reports.create')); ?>" class="btn btn-primary">New Report</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <table class="table table-hover mb-0">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="padding: 15px; font-weight: 600;">Name</th>
                    <th style="padding: 15px; font-weight: 600;">Type</th>
                    <th style="padding: 15px; font-weight: 600;">Frequency</th>
                    <th style="padding: 15px; font-weight: 600;">Next Run</th>
                    <th style="padding: 15px; font-weight: 600;">Status</th>
                    <th style="padding: 15px; font-weight: 600; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 15px;"><strong><?php echo e($report->name); ?></strong></td>
                        <td style="padding: 15px;"><span class="badge" style="background: #d2dcc9; color: #1e40af; padding: 5px 10px;"><?php echo e(ucfirst(str_replace('_', ' ', $report->report_type))); ?></span></td>
                        <td style="padding: 15px;"><?php echo e(ucfirst($report->frequency)); ?></td>
                        <td style="padding: 15px;"><small><?php echo e($report->next_run_date->format('M d, Y H:i')); ?></small></td>
                        <td style="padding: 15px;">
                            <?php if($report->active): ?>
                                <span class="badge" style="background: #dcfce7; color: #166534;">Active</span>
                            <?php else: ?>
                                <span class="badge" style="background: #fee2e2; color: #b91c1c;">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="<?php echo e(route('admin.scheduled-reports.edit', $report)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="<?php echo e(route('admin.scheduled-reports.destroy', $report)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: #9ca3af;">No scheduled reports configured.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($reports->links()); ?>

</div>

<style>
    .btn-primary {
        background: #52796f;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/scheduled-reports/index.blade.php ENDPATH**/ ?>