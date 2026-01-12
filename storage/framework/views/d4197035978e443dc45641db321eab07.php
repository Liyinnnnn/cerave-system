<?php ($pwdErrors = $errors->getBag('password')); ?>

<form method="POST" action="<?php echo e(route('profile.password.update')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div>
        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Current Password</label>
        <input id="current_password" name="current_password" type="password" required
            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
        <?php $__errorArgs = ['current_password', 'password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-500 mt-1 dark:text-red-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">New Password</label>
        <input id="password" name="password" type="password" required
            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
        <?php $__errorArgs = ['password', 'password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-500 mt-1 dark:text-red-400"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Confirm New Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
    </div>

    <div class="flex justify-end pt-4">
        <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center gap-2 dark:bg-blue-700 dark:hover:bg-blue-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Update Password
        </button>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>