<?php $__env->startSection('content'); ?>
    <?php if(session('password_success')): ?>
        <div class="fixed top-4 right-4 z-[9999] bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-2xl max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700 font-medium">PASSWORD UPDATED SUCCESSFULLY</p>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-green-50')?.remove();
            }, 5000);
        </script>
    <?php endif; ?>

    <?php if(session('form') === 'password' && session('success')): ?>
        <div class="fixed top-4 right-4 z-[9999] bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-2xl max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700 font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelectorAll('.bg-green-50')[0]?.remove();
            }, 5000);
        </script>
    <?php endif; ?>

    <?php if(session('form') === 'password' && $errors->getBag('password')->any()): ?>
        <div class="fixed top-4 right-4 z-[9999] bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-2xl max-w-md">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <div>
                    <?php $__currentLoopData = $errors->getBag('password')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-red-700 text-sm"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelectorAll('.bg-red-50')[0]?.remove();
            }, 7000);
        </script>
    <?php endif; ?>

    <?php if(session('form') === 'skincare' && session('success')): ?>
        <div class="fixed top-4 right-4 z-50 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-lg animate-slide-in-right max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700 font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.animate-slide-in-right')?.remove();
            }, 5000);
        </script>
    <?php endif; ?>

    <!-- Success/Error Messages -->
    <?php if(session('form') === 'profile' && session('success')): ?>
        <div class="fixed top-4 right-4 z-50 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-lg animate-slide-in-right max-w-md">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700 font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.animate-slide-in-right')?.remove();
            }, 5000);
        </script>
    <?php endif; ?>

    <?php if(session('form') === 'profile' && $errors->any()): ?>
        <div class="fixed top-4 right-4 z-50 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-lg animate-slide-in-right max-w-md">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <div>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-red-700 text-sm"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.animate-slide-in-right')?.remove();
            }, 7000);
        </script>
    <?php endif; ?>

    <?php if($errors->any() && !session('form')): ?>
        <div class="fixed top-4 right-4 z-[9999] bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-2xl max-w-md">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <div>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-red-700 text-sm"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelectorAll('.bg-red-50')[0]?.remove();
            }, 7000);
        </script>
    <?php endif; ?>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
        <div class="max-w-6xl mx-auto flex bg-white shadow-2xl rounded-2xl overflow-hidden dark:bg-slate-900">
            <!-- Sidebar -->
            <aside class="w-1/4 bg-gradient-to-b from-blue-900 to-blue-800 text-white p-6 relative dark:from-slate-900 dark:to-indigo-950 dark:border-r dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-blue-800 to-transparent opacity-50"></div>
                
                <?php ($avatar = $user->profile_image_url ?? null); ?>
                <div class="flex flex-col items-center text-center space-y-3 relative z-10">
                    <div class="relative group">
                        <img src="<?php echo e($avatar ?: asset('images/default-avatar.png')); ?>"
                            class="w-28 h-28 rounded-full border-4 border-white shadow-2xl object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 rounded-full bg-black opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold dark:text-white">Hey, <?php echo e($user->nickname); ?>!</h3>
                    <p class="text-sm text-blue-100 font-medium dark:text-blue-200"><?php echo e($user->name); ?></p>
                    <p class="text-xs text-blue-200 flex items-center gap-2 dark:text-blue-300">
                        <span class="text-lg">
                            <?php if($user->gender === 'Male' || $user->gender === 'male'): ?>
                                ♂️
                            <?php else: ?>
                                ♀️
                            <?php endif; ?>
                        </span>
                        <span><?php echo e(\Carbon\Carbon::parse($user->birthday)->format('jS M Y')); ?></span>
                    </p>
                    <p class="text-xs text-blue-200 break-all px-2 dark:text-blue-300"><?php echo e($user->email); ?></p>
                </div>
                
                <nav class="mt-10 flex flex-col space-y-3 relative z-10">
                    <a href="#account" onclick="scrollToSection('account')"
                        class="py-3 px-4 rounded-lg bg-blue-800 hover:bg-blue-700 transition-all duration-300 text-center font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 dark:bg-indigo-900 dark:hover:bg-indigo-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Account
                    </a>
                    <a href="#skincare" onclick="scrollToSection('skincare')"
                        class="py-3 px-4 rounded-lg bg-blue-800 hover:bg-blue-700 transition-all duration-300 text-center font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 dark:bg-indigo-900 dark:hover:bg-indigo-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Skincare
                    </a>
                    <a href="#password" onclick="scrollToSection('password')"
                        class="py-3 px-4 rounded-lg bg-blue-800 hover:bg-blue-700 transition-all duration-300 text-center font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 dark:bg-indigo-900 dark:hover:bg-indigo-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Password
                    </a>
                    <a href="#delete" onclick="scrollToSection('delete')"
                        class="py-3 px-4 rounded-lg bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 transition-all duration-300 text-center font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 dark:from-red-700 dark:to-red-800 dark:hover:from-red-800 dark:hover:to-red-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Account
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="w-3/4 p-10 space-y-10 bg-gray-50 dark:bg-indigo-900">
                <?php if(is_null($user->password)): ?>
                    <section class="scroll-mt-4">
                        <div class="bg-yellow-50 rounded-xl shadow-lg p-6 border-2 border-yellow-200 dark:bg-indigo-900 dark:bg-opacity-60 dark:border-indigo-700">
                            <h2 class="text-xl font-bold text-yellow-800 mb-2 dark:text-blue-200">Create a password for your account</h2>
                            <p class="text-yellow-700 mb-4 dark:text-blue-300">You signed in with Google. To also sign in using your email and password, please create a password now.</p>
                            <form method="POST" action="<?php echo e(route('profile.password.set')); ?>" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-yellow-800 mb-2 dark:text-blue-200">New Password</label>
                                    <input id="password" name="password" type="password" required class="w-full border-2 border-yellow-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-yellow-800 mb-2 dark:text-blue-200">Confirm New Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full border-2 border-yellow-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md dark:bg-blue-700 dark:hover:bg-blue-800">Create Password</button>
                                    <button type="button" onclick="this.closest('section').remove();" class="px-6 py-3 bg-white border-2 border-yellow-300 rounded-lg text-yellow-800 hover:bg-yellow-100 transition dark:bg-transparent dark:text-blue-200 dark:border-indigo-700">Not now</button>
                                </div>
                            </form>
                        </div>
                    </section>
                <?php endif; ?>
                <!-- Update Profile -->
                <section id="account" class="scroll-mt-4">
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-blue-100 rounded-lg dark:bg-indigo-900 dark:border dark:border-indigo-700">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Account Settings</h2>
                        </div>

                        <div class="mb-6 p-4 rounded-lg border-2 border-blue-200 bg-blue-50 text-sm text-blue-800 dark:border-indigo-700 dark:bg-indigo-900 dark:bg-opacity-50 dark:text-blue-200">
                            <p class="font-semibold mb-1">⚠️ Changing your email requires verification</p>
                            <p>When you update your email, we'll immediately switch to the new address and send a verification link. You'll need to verify before accessing your account again.</p>
                        </div>

                        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('patch'); ?>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Profile Picture</label>
                                    <div class="relative">
                                        <input type="file" name="profile_picture" accept="image/*" 
                                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border-2 border-gray-200 rounded-lg p-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:file:bg-indigo-900 dark:file:text-blue-300">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Full Name</label>
                                    <input name="name" value="<?php echo e(old('name', $user->name)); ?>"
                                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300" required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Nickname</label>
                                    <input name="nickname" value="<?php echo e(old('nickname', $user->nickname)); ?>"
                                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300" required>
                                    <?php $__errorArgs = ['nickname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Birthday</label>
                                    <input type="date" name="birthday" value="<?php echo e(old('birthday', $user->birthday)); ?>"
                                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300" required>
                                    <?php $__errorArgs = ['birthday'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Gender</label>
                                    <select id="gender" name="gender" required
                                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
                                        <option value="">Select Gender</option>
                                        <option value="Male"
                                            <?php echo e(old('gender', strtolower($user->gender)) === 'male' ? 'selected' : ''); ?>>Male
                                        </option>
                                        <option value="Female"
                                            <?php echo e(old('gender', strtolower($user->gender)) === 'female' ? 'selected' : ''); ?>>
                                            Female</option>
                                    </select>

                                    <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-sm text-red-500 mt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Phone Number</label>
                                    <div class="flex gap-2">
                                        <select name="country_code" class="w-32 border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
                                            <option value="+60" <?php echo e(old('country_code', $user->country_code ?? '+60') === '+60' ? 'selected' : ''); ?>>🇲🇾 +60</option>
                                            <option value="+1" <?php echo e(old('country_code', $user->country_code) === '+1' ? 'selected' : ''); ?>>🇺🇸 +1</option>
                                            <option value="+44" <?php echo e(old('country_code', $user->country_code) === '+44' ? 'selected' : ''); ?>>🇬🇧 +44</option>
                                            <option value="+61" <?php echo e(old('country_code', $user->country_code) === '+61' ? 'selected' : ''); ?>>🇦🇺 +61</option>
                                            <option value="+65" <?php echo e(old('country_code', $user->country_code) === '+65' ? 'selected' : ''); ?>>🇸🇬 +65</option>
                                            <option value="+86" <?php echo e(old('country_code', $user->country_code) === '+86' ? 'selected' : ''); ?>>🇨🇳 +86</option>
                                            <option value="+91" <?php echo e(old('country_code', $user->country_code) === '+91' ? 'selected' : ''); ?>>🇮🇳 +91</option>
                                            <option value="+81" <?php echo e(old('country_code', $user->country_code) === '+81' ? 'selected' : ''); ?>>🇯🇵 +81</option>
                                            <option value="+82" <?php echo e(old('country_code', $user->country_code) === '+82' ? 'selected' : ''); ?>>🇰🇷 +82</option>
                                            <option value="+66" <?php echo e(old('country_code', $user->country_code) === '+66' ? 'selected' : ''); ?>>🇹🇭 +66</option>
                                            <option value="+84" <?php echo e(old('country_code', $user->country_code) === '+84' ? 'selected' : ''); ?>>🇻🇳 +84</option>
                                            <option value="+63" <?php echo e(old('country_code', $user->country_code) === '+63' ? 'selected' : ''); ?>>🇵🇭 +63</option>
                                            <option value="+62" <?php echo e(old('country_code', $user->country_code) === '+62' ? 'selected' : ''); ?>>🇮🇩 +62</option>
                                        </select>
                                        <input type="tel" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                                            placeholder="12 345 6789"
                                            class="flex-1 border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
                                    </div>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Email</label>
                                    <input name="email" type="email" value="<?php echo e(old('email', $user->email)); ?>"
                                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300" required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2 dark:from-blue-700 dark:to-blue-800 dark:hover:from-blue-800 dark:hover:to-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Profile
                                </button>
                            </div>
                        </form>

                        <?php if(session('status') === 'profile-updated'): ?>
                            <p class="text-sm text-green-600 mt-4">Profile updated successfully!</p>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Skincare Profile -->
                <section id="skincare" class="scroll-mt-4">
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-green-100 rounded-lg dark:bg-green-900 dark:bg-opacity-30 dark:border dark:border-green-700">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Skincare Profile</h2>
                        </div>

                        <form action="<?php echo e(route('profile.skincare.update')); ?>" method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('patch'); ?>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Skin Type</label>
                                    <select name="skin_type" class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300">
                                        <option value="">Select your skin type</option>
                                        <option value="Normal" <?php echo e(old('skin_type', $user->skin_type) === 'Normal' ? 'selected' : ''); ?>>Normal</option>
                                        <option value="Dry" <?php echo e(old('skin_type', $user->skin_type) === 'Dry' ? 'selected' : ''); ?>>Dry</option>
                                        <option value="Oily" <?php echo e(old('skin_type', $user->skin_type) === 'Oily' ? 'selected' : ''); ?>>Oily</option>
                                        <option value="Combination" <?php echo e(old('skin_type', $user->skin_type) === 'Combination' ? 'selected' : ''); ?>>Combination</option>
                                        <option value="Sensitive" <?php echo e(old('skin_type', $user->skin_type) === 'Sensitive' ? 'selected' : ''); ?>>Sensitive</option>
                                    </select>
                                    <?php $__errorArgs = ['skin_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Skin Concerns</label>
                                    <textarea name="skin_concerns" rows="3" placeholder="E.g., Acne, Dark spots, Wrinkles, Dryness..." class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300"><?php echo e(old('skin_concerns', $user->skin_concerns)); ?></textarea>
                                    <?php $__errorArgs = ['skin_concerns'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Existing Skin Conditions</label>
                                    <textarea name="skin_conditions" rows="3" placeholder="E.g., Eczema, Rosacea, Psoriasis..." class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all dark:bg-white dark:text-gray-800 dark:border-gray-200 dark:focus:border-blue-400 dark:focus:ring-blue-300"><?php echo e(old('skin_conditions', $user->skin_conditions)); ?></textarea>
                                    <?php $__errorArgs = ['skin_conditions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3 dark:text-blue-200">Products I'm Currently Using</label>
                                    <div class="grid grid-cols-2 gap-4 max-h-96 overflow-y-auto p-4 border-2 border-gray-200 rounded-lg">
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer transition-all dark:border-gray-300 dark:hover:bg-blue-100">
                                                <input type="checkbox" name="using_products[]" value="<?php echo e($product->id); ?>" 
                                                    <?php if(in_array($product->id, (array)(old('using_products') ?: $user->using_products ?: []))): ?> checked <?php endif; ?>
                                                    class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-800"><?php echo e($product->name); ?></p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-600"><?php echo e($product->category); ?></p>
                                                </div>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php $__errorArgs = ['using_products'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2 dark:from-green-700 dark:to-green-800 dark:hover:from-green-800 dark:hover:to-green-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Skincare Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Password Update -->
                <section id="password" class="scroll-mt-4">
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg dark:bg-yellow-900 dark:bg-opacity-30 dark:border dark:border-yellow-700">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Update Password</h2>
                        </div>
                        <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </section>

    

                <!-- Delete Account -->
                <section id="delete" class="scroll-mt-4">
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-red-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-red-900 dark:border-opacity-50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-red-100 rounded-lg dark:bg-red-900 dark:bg-opacity-30 dark:border dark:border-red-700">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Danger Zone</h2>
                        </div>
                        <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script>
        function scrollToSection(sectionId) {
            event.preventDefault();
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/profile/edit.blade.php ENDPATH**/ ?>