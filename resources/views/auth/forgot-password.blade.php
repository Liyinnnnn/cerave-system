@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        <div class="w-1/2 bg-gradient-to-br from-blue-900 to-blue-800 text-white flex items-center justify-center p-16">
            <div class="space-y-6 text-center">
                <svg class="w-20 h-20 mx-auto text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <h1 class="text-3xl font-bold">Forgot Your Password?</h1>
                <p class="text-lg text-blue-100">No worries! We'll help you reset it. Just enter your email address and we'll send you a password reset link.</p>
            </div>
        </div>
        <div class="w-1/2 bg-white flex items-center justify-center">
            <div class="max-w-md w-full p-8">
                <h2 class="text-2xl font-bold text-center text-blue-900 mb-8">Reset Password</h2>
                
                @if(session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                        <p class="text-green-700 font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                @if($errors->has('email'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <p class="text-red-700 font-medium">{{ $errors->first('email') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Reset Link
                    </button>
                </form>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-600">Remember your password? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
                        Object.keys(errors).forEach(k => {
                            const arr = errors[k];
                            if (Array.isArray(arr)) arr.forEach(m => msgs.push(m));
                        });
                        showToast(msgs.length ? msgs.join(', ') : 'Please check the form errors.', 'error');
                    } else {
                        showToast(payload?.message || 'Unexpected error. Please try again.', 'error');
                    }
                } catch (err) {
                    showToast('Network error. Please try again.', 'error');
                }
            });
        })();
    </script>
@endsection
