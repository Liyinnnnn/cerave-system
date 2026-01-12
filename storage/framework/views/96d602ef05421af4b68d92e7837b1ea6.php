

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-cyan-100 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Actions -->
        <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-4 mb-2">
                    <a href="<?php echo e(route('consultation-reports.index')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold dark:text-blue-400 dark:hover:text-blue-300">
                        ← Back to List
                    </a>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Consultation Report</h1>
                <p class="mt-2 text-gray-600 dark:text-blue-200">Comprehensive health record for <?php echo e($user->name); ?></p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="<?php echo e(route('consultation-reports.export-pdf', $user)); ?>" 
                   target="_blank"
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition shadow-md dark:bg-gray-700 dark:hover:bg-gray-800 no-print">
                    �️ Print Report
                </a>
                <button onclick="window.print()" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md dark:bg-blue-700 dark:hover:bg-blue-800 no-print">
                    🖨️ Print Report
                </button>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <?php if($user->profile_picture): ?>
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-blue-100 dark:border-blue-900" src="<?php echo e($user->profile_image_url); ?>" alt="<?php echo e($user->name); ?>">
                    <?php else: ?>
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-100 dark:border-blue-900">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($user->name); ?></h2>
                    <?php if($user->nickname): ?>
                        <p class="text-gray-600 mt-1 dark:text-blue-300"><?php echo e($user->nickname); ?></p>
                    <?php endif; ?>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Email</p>
                            <p class="mt-1 text-gray-900 dark:text-blue-100"><?php echo e($user->email); ?></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Phone</p>
                            <p class="mt-1 text-gray-900 dark:text-blue-100"><?php echo e($user->phone ?? 'Not provided'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Member Since</p>
                            <p class="mt-1 text-gray-900 dark:text-blue-100"><?php echo e($user->created_at->format('M d, Y')); ?></p>
                        </div>
                    </div>
                    <?php if($user->birthday || $user->gender): ?>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php if($user->birthday): ?>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Birthday</p>
                                    <p class="mt-1 text-gray-900 dark:text-blue-100"><?php echo e(\Carbon\Carbon::parse($user->birthday)->format('M d, Y')); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($user->gender): ?>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Gender</p>
                                    <p class="mt-1 text-gray-900 dark:text-blue-100"><?php echo e($user->gender); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-blue-400 dark:border-r border-gray-100 dark:border-r-slate-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Total Appointments</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['total_appointments']); ?></p>
                    </div>
                    <div class="text-4xl">📅</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-green-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Completed</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['completed_appointments']); ?></p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-purple-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Dr. C Sessions</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['total_dr_c_sessions']); ?></p>
                    </div>
                    <div class="text-4xl">🤖</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-orange-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Consultations</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['total_consultations']); ?></p>
                    </div>
                    <div class="text-4xl">💬</div>
                </div>
            </div>
        </div>

        <!-- Skin Profile Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b-2 border-blue-100 dark:border-blue-900">
                🧴 Skin Profile
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2 dark:text-gray-400">Skin Type</p>
                    <?php if($skinProfile['skin_type']): ?>
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 rounded-full font-semibold">
                            <?php echo e(ucfirst($skinProfile['skin_type'])); ?>

                        </span>
                    <?php else: ?>
                        <p class="text-gray-400 italic dark:text-gray-500">Not specified</p>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2 dark:text-gray-400">Last Updated</p>
                    <p class="text-gray-900 dark:text-blue-100">
                        <?php echo e($skinProfile['profile_updated_at'] ? $skinProfile['profile_updated_at']->format('M d, Y') : 'Never updated'); ?>

                    </p>
                </div>
            </div>

            <?php if(!empty($skinProfile['skin_concerns'])): ?>
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 dark:text-gray-400">Skin Concerns</p>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $skinProfile['skin_concerns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concern): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($concern): ?>
                                <span class="px-4 py-2 bg-orange-100 text-orange-800 rounded-lg font-semibold text-sm">
                                    <?php echo e(ucfirst(trim($concern))); ?>

                                </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!empty($skinProfile['skin_conditions'])): ?>
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Skin Conditions</p>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $skinProfile['skin_conditions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($condition): ?>
                                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-semibold text-sm">
                                    <?php echo e(ucfirst(trim($condition))); ?>

                                </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!empty($skinProfile['using_products'])): ?>
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Currently Using Products</p>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $skinProfile['using_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($product): ?>
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold text-sm">
                                    <?php echo e($product); ?>

                                </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Appointments Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-blue-100">
                📅 Appointment History (<?php echo e($appointments->count()); ?>)
            </h3>
            
            <?php if($appointments->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-blue-300 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg"><?php echo e($appointment->name); ?></h4>
                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($appointment->email); ?> • <?php echo e($appointment->phone); ?></p>
                                </div>
                                <div>
                                    <?php if($appointment->status === 'completed'): ?>
                                        <span class="px-4 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">✓ Completed</span>
                                    <?php elseif($appointment->status === 'confirmed'): ?>
                                        <span class="px-4 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Confirmed</span>
                                    <?php elseif($appointment->status === 'pending'): ?>
                                        <span class="px-4 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Pending</span>
                                    <?php elseif($appointment->status === 'cancelled'): ?>
                                        <span class="px-4 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Cancelled</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Date & Time</p>
                                    <p class="text-gray-900 font-medium"><?php echo e(\Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y')); ?> at <?php echo e($appointment->preferred_time); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Type</p>
                                    <p class="text-gray-900 font-medium"><?php echo e(ucfirst($appointment->consultation_type)); ?></p>
                                </div>
                                <?php if($appointment->location): ?>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Location</p>
                                        <p class="text-gray-900 font-medium"><?php echo e($appointment->location); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if($appointment->concerns): ?>
                                <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Concerns</p>
                                    <p class="text-gray-700"><?php echo e($appointment->concerns); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if($appointment->consultant_report): ?>
                                <div class="mt-4 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                    <p class="text-xs font-semibold text-blue-700 uppercase mb-2">Consultant Report</p>
                                    <div class="text-gray-700"><?php echo nl2br(e($appointment->consultant_report)); ?></div>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4 flex gap-2">
                                <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                    View Details →
                                </a>
                                <?php if($appointment->consultant_report): ?>
                                    <a href="<?php echo e(route('appointments.consultationReport', $appointment)); ?>" target="_blank" class="text-green-600 hover:text-green-700 text-sm font-semibold">
                                        View Full Report →
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">No appointments recorded yet</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Dr. C AI Sessions -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-blue-100">
                🤖 Dr. C AI Sessions (<?php echo e($drCSessions->count()); ?>)
            </h3>

            <?php if($drCSessions->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $drCSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900">Session #<?php echo e($session->id); ?></h4>
                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($session->created_at->format('M d, Y g:i A')); ?></p>
                                </div>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    <?php echo e($session->messages->count()); ?> messages
                                </span>
                            </div>

                            <?php if($session->messages->count() > 0): ?>
                                <div class="bg-gray-50 p-4 rounded-lg mt-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">First Message</p>
                                    <p class="text-gray-700 line-clamp-2"><?php echo e($session->messages->first()->message); ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4">
                                <a href="<?php echo e(route('dr-c.viewReport', $session)); ?>" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                                    View Full Session →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">No AI consultation sessions yet</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Consultation Records -->
        <?php if($consultations->count() > 0): ?>
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-blue-100">
                    💬 Consultation Records (<?php echo e($consultations->count()); ?>)
                </h3>

                <div class="space-y-4">
                    <?php $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-5">
                            <div class="mb-3">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Date</p>
                                <p class="text-gray-900"><?php echo e($consultation->created_at->format('M d, Y g:i A')); ?></p>
                            </div>

                            <?php if($consultation->concerns): ?>
                                <div class="bg-gray-50 p-4 rounded-lg mb-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Concerns</p>
                                    <p class="text-gray-700"><?php echo e($consultation->concerns); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if($consultation->response): ?>
                                <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                    <p class="text-xs font-semibold text-blue-700 uppercase mb-2">Response</p>
                                    <div class="text-gray-700"><?php echo nl2br(e($consultation->response)); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .shadow-sm {
            box-shadow: none !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/consultation-reports/show.blade.php ENDPATH**/ ?>