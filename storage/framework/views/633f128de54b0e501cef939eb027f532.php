<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-blue-900 text-white flex flex-col items-center justify-center px-4 text-center">
    <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-4"><?php echo e($title ?? 'Skincare Developed with Dermatologists'); ?></h1>
    <p class="max-w-xl text-lg mb-8"><?php echo e($description ?? 'Experience the power of ceramides with dermatologist-developed formulations for healthy, beautiful skin backed by science.'); ?></p>
    <div class="space-x-4">
        <a href="<?php echo e(route('register', [], false)); ?>" class="inline-block bg-white text-blue-800 font-semibold px-6 py-3 rounded-full shadow hover:bg-blue-100">Create Account</a>
        <a href="<?php echo e(route('login', [], false)); ?>" class="inline-block bg-transparent border border-white px-6 py-3 rounded-full text-white font-semibold hover:bg-white hover:text-blue-900">Get Started</a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/welcome.blade.php ENDPATH**/ ?>