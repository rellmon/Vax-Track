

<?php $__env->startSection('title', 'Financial Dashboard'); ?>
<?php $__env->startSection('page-title', 'Financial Analytics & Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- KPI Row -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card success">
                <h6>Total Revenue</h6>
                <div class="stat-value">₱<?php echo e(number_format($stats['total_revenue'], 2)); ?></div>
                <small class="text-muted"><?php echo e($from->format('M d')); ?> - <?php echo e($to->format('M d, Y')); ?></small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card warning">
                <h6>Pending Amount</h6>
                <div class="stat-value">₱<?php echo e(number_format($stats['pending_amount'], 2)); ?></div>
                <small class="text-muted">Awaiting payment</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card danger">
                <h6>Unpaid Amount</h6>
                <div class="stat-value">₱<?php echo e(number_format($stats['unpaid_amount'], 2)); ?></div>
                <small class="text-muted">Outstanding</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <h6>Total Transactions</h6>
                <div class="stat-value"><?php echo e($stats['total_transactions']); ?></div>
                <small class="text-muted">Completed payments</small>
            </div>
        </div>
    </div>

    <!-- Monthly Comparison -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-body">
                    <h6 style="font-weight: 700; margin-bottom: 20px;">Monthly Comparison</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div style="padding: 15px; background: #e8ede2; border-radius: 6px;">
                                <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Current Month Revenue</p>
                                <p style="font-size: 1.5rem; font-weight: 700; color: #52796f; margin: 0;">₱<?php echo e(number_format($currentMonth, 2)); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding: 15px; background: #e8ede2; border-radius: 6px;">
                                <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Previous Month Revenue</p>
                                <p style="font-size: 1.5rem; font-weight: 700; color: #52796f; margin: 0;">₱<?php echo e(number_format($previousMonth, 2)); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding: 15px; background: <?php if($monthlyGrowth >= 0): ?>#f0fdf4 <?php else: ?> #fef2f2 <?php endif; ?>; border-radius: 6px;">
                                <p style="color: #84a98c; font-size: 0.875rem; margin: 0; margin-bottom: 5px;">Month-over-Month Growth</p>
                                <p style="font-size: 1.5rem; font-weight: 700; color: <?php if($monthlyGrowth >= 0): ?>#16a34a <?php else: ?> #dc2626 <?php endif; ?>; margin: 0;">
                                    <?php if($monthlyGrowth >= 0): ?>
                                        <i class="bi bi-arrow-up"></i>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down"></i>
                                    <?php endif; ?>
                                    <?php echo e(number_format($monthlyGrowth, 2)); ?>%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="card mb-4" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.financial.dashboard')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date" class="form-control" value="<?php echo e($from->format('Y-m-d')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" class="form-control" value="<?php echo e($to->format('Y-m-d')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
                <div class="col-md-12">
                    <a href="<?php echo e(route('admin.financial.report.download', request()->query())); ?>" class="btn btn-success">
                        <i class="bi bi-download"></i> Download Report (CSV)
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Revenue by Vaccine Type -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Revenue by Vaccine Type</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vaccine</th>
                                <th>Count</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $vaccineRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vaccine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($vaccine->name); ?></strong></td>
                                    <td><?php echo e($vaccine->count); ?></td>
                                    <td><strong>₱<?php echo e(number_format($vaccine->revenue, 2)); ?></strong></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Payment Status Breakdown</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $paymentStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="badge" style="<?php if($status->status === 'Paid'): ?> background: #dcfce7; color: #16a34a; <?php elseif($status->status === 'Pending'): ?> background: #fef3c7; color: #b45309; <?php else: ?> background: #fee2e2; color: #dc2626; <?php endif; ?>">
                                            <?php echo e($status->status); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($status->count); ?></td>
                                    <td><strong>₱<?php echo e(number_format($status->amount, 2)); ?></strong></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Outstanding Payments -->
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Outstanding Payments (Top 20)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Child Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $outstandingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <?php if($payment->child): ?>
                                            <strong><?php echo e($payment->child->first_name); ?> <?php echo e($payment->child->last_name); ?></strong>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>₱<?php echo e(number_format($payment->amount, 2)); ?></td>
                                    <td>
                                        <span class="badge" style="<?php if($payment->status === 'Pending'): ?> background: #fef3c7; color: #b45309; <?php else: ?> background: #fee2e2; color: #dc2626; <?php endif; ?>">
                                            <?php echo e($payment->status); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.financial.payment-details', $payment)); ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No outstanding payments</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recent Transactions</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Child</th>
                                <th>Vaccine</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>#<?php echo e($transaction->id); ?></td>
                                    <td>
                                        <?php if($transaction->child): ?>
                                            <?php echo e($transaction->child->first_name); ?>

                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($transaction->schedule && $transaction->schedule->vaccine): ?>
                                            <?php echo e($transaction->schedule->vaccine->name); ?>

                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>₱<?php echo e(number_format($transaction->amount, 2)); ?></td>
                                    <td>
                                        <span class="badge" style="<?php if($transaction->status === 'Paid'): ?> background: #dcfce7; color: #16a34a; <?php elseif($transaction->status === 'Pending'): ?> background: #fef3c7; color: #b45309; <?php else: ?> background: #fee2e2; color: #dc2626; <?php endif; ?>">
                                            <?php echo e($transaction->status); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($transaction->payment_date ? $transaction->payment_date->format('M d, Y') : 'N/A'); ?></td>
                                    <td><?php echo e($transaction->method); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No transactions found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer" style="background: white; border-top: 1px solid #cad2c5;">
                    <?php echo e($recentTransactions->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/financial/dashboard.blade.php ENDPATH**/ ?>