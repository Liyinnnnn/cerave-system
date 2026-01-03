@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        <div class="w-1/2 bg-blue-900 text-white flex items-center justify-center p-16 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950">
            <div class="space-y-4">
                <h1 class="text-3xl font-bold">Join CeraVe</h1>
                <p class="text-lg">Start your journey to healthier, more beautiful skin with our dermatologist-developed
                    formulations.</p>
                <ul class="text-sm space-y-2">
                    <li>✓ Science-backed Recommendations</li>
                    <li>✓ Easy Appointment Booking</li>
                    <li>✓ Track Progress Anywhere</li>
                    <li>✓ Secure & Private</li>
                </ul>
            </div>
        </div>
        <div class="w-1/2 bg-white flex items-center justify-center dark:bg-indigo-900">
            <div class="max-w-md w-full p-8">
                <h2 class="text-2xl font-bold text-center text-blue-900 mb-6 dark:text-white">Create Account</h2>
                <form method="POST" action="{{ route('register') }}" class="space-y-4" id="register-form">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium dark:text-blue-200">Full Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                            @error('name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="nickname" class="block text-sm font-medium dark:text-blue-200">Nickname</label>
                            <input id="nickname" type="text" name="nickname" value="{{ old('nickname') }}"
                                class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                            @error('nickname')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium dark:text-blue-200">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                        @error('email')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="birthday" class="block text-sm font-medium dark:text-blue-200">Birthday</label>
                            <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}"
                                class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                            @error('birthday')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium dark:text-blue-200">Gender</label>
                            <select id="gender" name="gender" required
                                class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium dark:text-blue-200">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                        @error('password')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium dark:text-blue-200">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full border p-2 rounded mt-1 block border-gray-300 focus:ring-blue-600 focus:border-blue-600 dark:bg-white dark:text-gray-800 dark:border-gray-200">
                    </div>

                    <div class="flex items-start text-sm">
                        <input type="checkbox" class="rounded mr-2 mt-1" required>
                        <p class="dark:text-blue-200">I agree to the <a href="#" class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">Terms of Service</a> and
                            <a href="#" class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">Privacy Policy</a>.
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg dark:bg-blue-700 dark:hover:bg-blue-800">
                        Create Account
                    </button>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-slate-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500 dark:bg-indigo-900 dark:text-blue-300">Or continue with</span>
                        </div>
                    </div>

                    <a href="{{ route('oauth.google.redirect') }}" class="mt-4 w-full inline-flex items-center justify-center gap-2 bg-white border-2 border-gray-200 text-gray-800 py-3 rounded-lg hover:bg-blue-50 transition-all duration-200 font-semibold shadow-md hover:shadow-lg dark:bg-slate-800 dark:border-slate-700 dark:text-white dark:hover:bg-slate-700">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Sign up with Google
                    </a>
                </div>

                <p class="text-center text-sm mt-4 dark:text-blue-200">Already have an account? <a href="{{ route('login') }}"
                        class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">Sign in here</a></p>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('register-form');
            if (!form) return;

            function showToast(message, type = 'success') {
                const isSuccess = type === 'success';
                const containerClass = isSuccess
                    ? 'fixed top-4 right-4 z-[9999] bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-2xl max-w-md animate-slide-in-right'
                    : 'fixed top-4 right-4 z-[9999] bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-2xl max-w-md animate-slide-in-right';
                const textClass = isSuccess ? 'text-green-700' : 'text-red-700';
                const iconClass = isSuccess ? 'text-green-500' : 'text-red-500';

                const toast = document.createElement('div');
                toast.className = containerClass;
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 ${iconClass} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${isSuccess
                                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'}
                        </svg>
                        <div class="${textClass} font-medium text-sm">${message}</div>
                    </div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), isSuccess ? 5000 : 7000);
            }

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json' },
                        body: formData,
                    });

                    const payload = await res.json().catch(() => ({}));

                    if (res.status === 201) {
                        showToast('Registration successful! Check your email to verify your account.', 'success');
                        setTimeout(() => window.location.href = '/login', 2500);
                    } else if (res.status === 422) {
                        const msgs = [];
                        const errors = payload?.errors || {};
                        Object.keys(errors).forEach(k => {
                            const arr = errors[k];
                            if (Array.isArray(arr)) arr.forEach(m => msgs.push(m));
                        });
                        showToast(msgs.length ? msgs.join(' ') : 'Please fix the errors.', 'error');
                    } else {
                        showToast(payload?.message || 'Registration failed. Please try again.', 'error');
                    }
                } catch (err) {
                    showToast('Network error. Please try again.', 'error');
                }
            });
        })();
    </script>
@endsection
