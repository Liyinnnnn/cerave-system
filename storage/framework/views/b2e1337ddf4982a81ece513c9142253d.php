

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb Navigation -->
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40 dark:bg-slate-900 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-3 text-sm py-3 text-gray-800 dark:text-gray-200">
            <a href="<?php echo e(route('appointments.index')); ?>" class="hover:text-blue-600 dark:hover:text-blue-400">All Appointments</a>
            <span>&gt;</span>
            <span class="text-gray-500 dark:text-gray-400">Reports</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 dark:text-white">Appointment Reports</h1>
            <p class="text-gray-600 dark:text-blue-200">Analytics and insights for appointments</p>
        </div>

        <!-- Date Range & Status Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <form method="GET" action="<?php echo e(route('appointments.reports')); ?>" id="filterForm" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Start Date</label>
                    <input type="date" name="start_date" value="<?php echo e($startDate); ?>" onchange="document.getElementById('filterForm').submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">End Date</label>
                    <input type="date" name="end_date" value="<?php echo e($endDate); ?>" onchange="document.getElementById('filterForm').submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Status</label>
                    <select name="status" onchange="document.getElementById('filterForm').submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>">Pending</option>
                        <option value="confirmed" <?php if(request('status') === 'confirmed'): echo 'selected'; endif; ?>">Confirmed</option>
                        <option value="completed" <?php if(request('status') === 'completed'): echo 'selected'; endif; ?>">Completed</option>
                        <option value="cancelled" <?php if(request('status') === 'cancelled'): echo 'selected'; endif; ?>">Cancelled</option>
                    </select>
                </div>
                <a href="<?php echo e(route('appointments.export', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => request('status')])); ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium dark:bg-green-700 dark:hover:bg-green-800">
                    Export
                </a>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold dark:text-blue-300">Total</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2 dark:text-white"><?php echo e($stats['total']); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center dark:bg-blue-900">
                        <svg class="w-6 h-6 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold dark:text-blue-300">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2 dark:text-yellow-400"><?php echo e($stats['pending']); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center dark:bg-yellow-900">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold dark:text-blue-300">Confirmed</p>
                        <p class="text-3xl font-bold text-green-600 mt-2 dark:text-green-400"><?php echo e($stats['confirmed']); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold dark:text-blue-300">Completed</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2 dark:text-blue-400"><?php echo e($stats['completed']); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center dark:bg-blue-900">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold dark:text-blue-300">Cancelled</p>
                        <p class="text-3xl font-bold text-red-600 mt-2 dark:text-red-400"><?php echo e($stats['cancelled']); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center dark:bg-red-900">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consultation Type Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <h2 class="text-xl font-bold text-gray-800 mb-4 dark:text-white">Consultation Type Breakdown</h2>
                <div class="space-y-4">
                    <?php $__currentLoopData = $consultationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-semibold dark:text-blue-200"><?php echo e(ucfirst($type->consultation_type)); ?></span>
                                <span class="text-gray-600 dark:text-blue-300"><?php echo e($type->count); ?> (<?php echo e($stats['total'] > 0 ? round(($type->count / $stats['total']) * 100, 1) : 0); ?>%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-slate-700">
                                <div class="bg-primary h-3 rounded-full dark:bg-blue-600" style="width: <?php echo e($stats['total'] > 0 ? ($type->count / $stats['total']) * 100 : 0); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Daily Trend Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <h2 class="text-xl font-bold text-gray-800 mb-4 dark:text-white">Daily Appointment Trend</h2>
                <div class="h-64 flex items-end justify-around gap-2">
                    <?php
                        $maxCount = $dailyTrend->max('count') ?: 1;
                    ?>
                    <?php $__currentLoopData = $dailyTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-primary rounded-t hover:bg-blue-700 transition dark:bg-blue-600 dark:hover:bg-blue-700" 
                                 style="height: <?php echo e(($day->count / $maxCount) * 100); ?>%"
                                 title="<?php echo e($day->date); ?>: <?php echo e($day->count); ?>">
                            </div>
                            <span class="text-xs text-gray-500 mt-2 dark:text-gray-400"><?php echo e(\Carbon\Carbon::parse($day->date)->format('M d')); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Recent Appointments Table -->
        <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <h2 class="text-xl font-bold text-gray-800 mb-4 dark:text-white">Recent Appointments</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-blue-200">ID</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-blue-200">Name</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-blue-200">Date</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-blue-200">Type</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-blue-200">Status</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-blue-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-slate-800 dark:hover:bg-slate-800">
                                <td class="py-3 px-4 text-gray-800 dark:text-white">#<?php echo e($appointment->id); ?></td>
                                <td class="py-3 px-4 text-gray-800 dark:text-white"><?php echo e($appointment->name); ?></td>
                                <td class="py-3 px-4 text-gray-600 dark:text-blue-200"><?php echo e(\Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y')); ?></td>
                                <td class="py-3 px-4 text-gray-600 dark:text-blue-200"><?php echo e(ucfirst($appointment->consultation_type)); ?></td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        <?php if($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        <?php elseif($appointment->status === 'confirmed'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        <?php elseif($appointment->status === 'completed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($appointment->status)); ?>

                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="text-primary hover:underline dark:text-blue-400">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">No appointments found for this date range.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/appointments/reports.blade.php ENDPATH**/ ?>