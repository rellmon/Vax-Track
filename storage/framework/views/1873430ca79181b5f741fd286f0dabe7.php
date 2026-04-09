

<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- KPIs 3x3 Grid -->
    <div class="row mb-4">
        <div class="col-md-4 col-lg-4">
            <div class="stat-card">
                <h6>Total Children</h6>
                <div class="stat-value"><?php echo e($totalChildren); ?></div>
                <small class="text-muted">Registered</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card success">
                <h6>Vaccination Coverage</h6>
                <div class="stat-value"><?php echo e($vaccinesCoveragePercent); ?>%</div>
                <small class="text-muted">Overall coverage</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card info">
                <h6>Upcoming Appointments</h6>
                <div class="stat-value"><?php echo e($upcomingAppointments); ?></div>
                <small class="text-muted">Next 7 days</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card">
                <h6>Active Staff</h6>
                <div class="stat-value"><?php echo e($activeStaff); ?></div>
                <small class="text-muted">Available</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card success">
                <h6>Monthly Revenue</h6>
                <div class="stat-value">₱<?php echo e(number_format($monthlyRevenue, 2)); ?></div>
                <small class="text-muted">This month</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card warning">
                <h6>Pending Payments</h6>
                <div class="stat-value">₱<?php echo e(number_format($pendingPaymentsAmount, 2)); ?></div>
                <small class="text-muted">Awaiting payment</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card">
                <h6>Today's Appointments</h6>
                <div class="stat-value"><?php echo e($todaySummary['appointments']); ?></div>
                <small class="text-muted">Scheduled</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card success">
                <h6>Completed Today</h6>
                <div class="stat-value"><?php echo e($todaySummary['completed_appointments']); ?></div>
                <small class="text-muted">Appointments</small>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="stat-card">
                <h6>New Registrations</h6>
                <div class="stat-value"><?php echo e($todaySummary['new_registrations']); ?></div>
                <small class="text-muted">Today</small>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row mb-4">
        <!-- Low Stock Alerts -->
        <?php if($lowStockVaccines->count() > 0): ?>
            <div class="col-md-4">
                <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #ea580c;">
                    <div class="card-header" style="background: #fef3c7; border-bottom: 2px solid #fed7aa; padding: 15px;">
                        <h6 class="mb-0" style="font-weight: 700; color: #b45309; font-size: 0.9rem;">
                            <i class="bi bi-exclamation-triangle"></i> Low Stock Vaccines (<?php echo e($lowStockVaccines->count()); ?>)
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <?php $__currentLoopData = $lowStockVaccines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vaccine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="padding: 12px 20px; border-bottom: 1px solid #cad2c5; <?php if($loop->last): ?> border-bottom: none; <?php endif; ?>">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #1e293b; font-weight: 600; font-size: 0.875rem;"><?php echo e($vaccine->name); ?></span>
                                        <span style="background: #fee2e2; color: #dc2626; padding: 4px 8px; border-radius: 4px; font-weight: 700; font-size: 0.75rem;"><?php echo e($vaccine->stock); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Overdue Vaccinations -->
        <?php if($overdueVaccinations->count() > 0): ?>
            <div class="col-md-4">
                <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #dc2626;">
                    <div class="card-header" style="background: #fef2f2; border-bottom: 2px solid #fecaca; padding: 15px;">
                        <h6 class="mb-0" style="font-weight: 700; color: #991b1b; font-size: 0.9rem;">
                            <i class="bi bi-clock-history"></i> Overdue Vaccinations (<?php echo e($overdueVaccinations->count()); ?>)
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <?php $__currentLoopData = $overdueVaccinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="padding: 12px 20px; border-bottom: 1px solid #cad2c5; <?php if($loop->last): ?> border-bottom: none; <?php endif; ?>">
                                    <div style="color: #1e293b; font-weight: 600; font-size: 0.875rem;">
                                        <?php echo e($appt->child->full_name ?? 'N/A'); ?>

                                    </div>
                                    <small style="color: #84a98c;"><?php echo e($appt->appointment_date ? $appt->appointment_date->format('M d, Y') : 'N/A'); ?></small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Pending Payments -->
        <?php if($pendingPayments->count() > 0): ?>
            <div class="col-md-4">
                <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b;">
                    <div class="card-header" style="background: #fef3c7; border-bottom: 2px solid #fed7aa; padding: 15px;">
                        <h6 class="mb-0" style="font-weight: 700; color: #b45309; font-size: 0.9rem;">
                            <i class="bi bi-cash-coin"></i> Pending Payments (<?php echo e($pendingPayments->count()); ?>)
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <?php $__currentLoopData = $pendingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="padding: 12px 20px; border-bottom: 1px solid #cad2c5; <?php if($loop->last): ?> border-bottom: none; <?php endif; ?>">
                                    <div style="color: #1e293b; font-weight: 600; font-size: 0.875rem;">
                                        <?php echo e($payment->child->full_name ?? 'N/A'); ?>

                                    </div>
                                    <small style="color: #84a98c;">₱<?php echo e(number_format($payment->amount, 2)); ?></small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Data Tables Row -->
    <div class="row mb-4">
        <!-- Recent Appointments -->
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recent Appointments</h6>
                </div>
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.875rem; margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Vaccine</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($appt->child->full_name ?? 'N/A'); ?></strong></td>
                                    <td><?php echo e($appt->vaccine->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($appt->appointment_date ? $appt->appointment_date->format('M d, Y') : 'N/A'); ?></td>
                                    <td>
                                        <span class="badge" style="<?php if($appt->status === 'Completed'): ?> background: #dcfce7; color: #16a34a; <?php elseif($appt->status === 'Scheduled'): ?> background: rgba(82,121,111,.12); color: #52796f; <?php else: ?> background: #fee2e2; color: #dc2626; <?php endif; ?>">
                                            <?php echo e($appt->status); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">No recent appointments</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recent Payments</h6>
                </div>
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.875rem; margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($payment->child->full_name ?? 'N/A'); ?></strong></td>
                                    <td>₱<?php echo e(number_format($payment->amount, 2)); ?></td>
                                    <td>
                                        <span class="badge" style="<?php if($payment->status === 'Paid'): ?> background: #dcfce7; color: #16a34a; <?php elseif($payment->status === 'Pending'): ?> background: #fef3c7; color: #b45309; <?php else: ?> background: #fee2e2; color: #dc2626; <?php endif; ?>">
                                            <?php echo e($payment->status); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">No recent payments</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- New Registrations & Recent Activities -->
    <div class="row mb-4">
        <!-- New Children Registrations -->
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">New Children Registrations</h6>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php $__empty_1 = true; $__currentLoopData = $newChildren; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="padding: 15px 20px; border-bottom: 1px solid #cad2c5; <?php if($loop->last): ?> border-bottom: none; <?php endif; ?>">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="color: #1e293b; font-weight: 600;"><?php echo e($child->full_name); ?></div>
                                    <small style="color: #84a98c;"><?php echo e($child->dob ? $child->dob->format('M d, Y') : 'No DOB'); ?></small>
                                </div>
                                <small style="color: #84a98c;"><?php echo e($child->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-3 text-muted">No new registrations</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-md-6">
            <div class="card" style="background: white; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: white; border-bottom: 2px solid #f1f5f9; padding: 20px;">
                    <h6 class="mb-0" style="font-weight: 700;">Recent System Updates</h6>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="padding: 15px 20px; border-bottom: 1px solid #cad2c5; <?php if($loop->last): ?> border-bottom: none; <?php endif; ?>">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="color: #1e293b; font-weight: 600; font-size: 0.875rem;"><?php echo e($activity->action); ?> <?php echo e($activity->model_type); ?></div>
                                    <small style="color: #84a98c;">ID: <?php echo e($activity->model_id); ?></small>
                                </div>
                                <small style="color: #84a98c;"><?php echo e($activity->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-3 text-muted">No recent activities</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-12">
            <h6 style="font-weight: 700; margin-bottom: 15px; color: #1e293b;">Quick Actions</h6>
            <div class="row g-2">
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.staff.index')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-people"></i> Manage Staff
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.financial.dashboard')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-graph-up"></i> Financial Reports
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.vaccine-inventory.dashboard')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-boxes"></i> Inventory
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.audit-logs')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-clock-history"></i> Audit Logs
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.email-notifications.index')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-envelope"></i> Email Templates
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.sms-templates.index')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-chat-dots"></i> SMS Templates
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.scheduled-reports.index')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-calendar-check"></i> Scheduled Reports
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="<?php echo e(route('admin.vaccination-coverage.dashboard')); ?>" class="btn btn-outline-primary w-100" style="border-radius: 6px;">
                        <i class="bi bi-hospital"></i> Vaccination Coverage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vacctrack\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>