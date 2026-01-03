@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        <div class="w-1/2 bg-gradient-to-br from-blue-900 to-blue-800 text-white flex items-center justify-center p-16">
            <div class="space-y-6 text-center">
                <svg class="w-20 h-20 mx-auto text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                <h1 class="text-3xl font-bold">Create New Password</h1>
                <p class="text-lg text-blue-100">Enter your new password below. Make sure it's strong and secure.</p>
            </div>
        </div>
        <div class="w-1/2 bg-white flex items-center justify-center">
            <div class="max-w-md w-full p-8">
                <h2 class="text-2xl font-bold text-center text-blue-900 mb-8">Reset Your Password</h2>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6" id="reset-password-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->route('token') ?? '' }}">

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', request()->query('email', '')) }}" required autofocus
                            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        @error('email')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        @error('password')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-600"><a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Back to Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
