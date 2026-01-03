@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        <div class="w-1/2 bg-gradient-to-br from-blue-900 to-blue-800 text-white flex items-center justify-center p-16">
            <div class="space-y-6 text-center">
                <svg class="w-20 h-20 mx-auto text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl font-bold">Verify Your Email</h1>
                <p class="text-lg text-blue-100">We've sent a verification link to your email. Click it to activate your account and start your skincare journey with CeraVe.</p>
            </div>
        </div>
        <div class="w-1/2 bg-white flex items-center justify-center">
            <div class="max-w-md w-full p-8">
                <h2 class="text-2xl font-bold text-center text-blue-900 mb-8">Email Verification</h2>

                @if (session('mail_error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <p class="text-red-700 font-medium">{{ session('mail_error') }}</p>
                        <p class="text-red-700 text-sm mt-2">If this keeps happening, verify your email later or contact support. You can also try resending the email below.</p>
                    </div>
                @endif

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                        <p class="text-green-700 font-medium">A new verification link has been sent to your email address.</p>
                    </div>
                @endif

                <div class="mb-8 p-5 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-blue-900 text-sm leading-relaxed">Thank you for signing up! We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.</p>
                </div>

                <form method="POST" action="{{ route('verification.send') }}" class="mb-6">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-blue-600 hover:text-blue-700 py-3 font-medium transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
