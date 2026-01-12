@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-cyan-100 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Actions -->
        <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-4 mb-2">
                    <a href="{{ route('consultation-reports.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold dark:text-blue-400 dark:hover:text-blue-300">
                        ← Back to List
                    </a>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Consultation Report</h1>
                <p class="mt-2 text-gray-600 dark:text-blue-200">Comprehensive health record for {{ $user->name }}</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('consultation-reports.export-pdf', $user) }}" 
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
                    @if($user->profile_picture)
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-blue-100 dark:border-blue-900" src="{{ $user->profile_image_url }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-100 dark:border-blue-900">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    @if($user->nickname)
                        <p class="text-gray-600 mt-1 dark:text-blue-300">{{ $user->nickname }}</p>
                    @endif
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Email</p>
                            <p class="mt-1 text-gray-900 dark:text-blue-100">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Phone</p>
                            <p class="mt-1 text-gray-900 dark:text-blue-100">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Member Since</p>
                            <p class="mt-1 text-gray-900 dark:text-blue-100">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @if($user->birthday || $user->gender)
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($user->birthday)
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Birthday</p>
                                    <p class="mt-1 text-gray-900 dark:text-blue-100">{{ \Carbon\Carbon::parse($user->birthday)->format('M d, Y') }}</p>
                                </div>
                            @endif
                            @if($user->gender)
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide dark:text-gray-400">Gender</p>
                                    <p class="mt-1 text-gray-900 dark:text-blue-100">{{ $user->gender }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-blue-400 dark:border-r border-gray-100 dark:border-r-slate-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Total Appointments</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_appointments'] }}</p>
                    </div>
                    <div class="text-4xl">📅</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-green-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Completed</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['completed_appointments'] }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-purple-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Dr. C Sessions</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_dr_c_sessions'] }}</p>
                    </div>
                    <div class="text-4xl">🤖</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-orange-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Consultations</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_consultations'] }}</p>
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
                    @if($skinProfile['skin_type'])
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 rounded-full font-semibold">
                            {{ ucfirst($skinProfile['skin_type']) }}
                        </span>
                    @else
                        <p class="text-gray-400 italic dark:text-gray-500">Not specified</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2 dark:text-gray-400">Last Updated</p>
                    <p class="text-gray-900 dark:text-blue-100">
                        {{ $skinProfile['profile_updated_at'] ? $skinProfile['profile_updated_at']->format('M d, Y') : 'Never updated' }}
                    </p>
                </div>
            </div>

            @if(!empty($skinProfile['skin_concerns']))
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 dark:text-gray-400">Skin Concerns</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($skinProfile['skin_concerns'] as $concern)
                            @if($concern)
                                <span class="px-4 py-2 bg-orange-100 text-orange-800 rounded-lg font-semibold text-sm">
                                    {{ ucfirst(trim($concern)) }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($skinProfile['skin_conditions']))
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Skin Conditions</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($skinProfile['skin_conditions'] as $condition)
                            @if($condition)
                                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-semibold text-sm">
                                    {{ ucfirst(trim($condition)) }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($skinProfile['using_products']))
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Currently Using Products</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($skinProfile['using_products'] as $product)
                            @if($product)
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold text-sm">
                                    {{ $product }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Appointments Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-blue-100">
                📅 Appointment History ({{ $appointments->count() }})
            </h3>
            
            @if($appointments->count() > 0)
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-blue-300 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">{{ $appointment->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $appointment->email }} • {{ $appointment->phone }}</p>
                                </div>
                                <div>
                                    @if($appointment->status === 'completed')
                                        <span class="px-4 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">✓ Completed</span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="px-4 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Confirmed</span>
                                    @elseif($appointment->status === 'pending')
                                        <span class="px-4 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Pending</span>
                                    @elseif($appointment->status === 'cancelled')
                                        <span class="px-4 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Cancelled</span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Date & Time</p>
                                    <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }} at {{ $appointment->preferred_time }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Type</p>
                                    <p class="text-gray-900 font-medium">{{ ucfirst($appointment->consultation_type) }}</p>
                                </div>
                                @if($appointment->location)
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Location</p>
                                        <p class="text-gray-900 font-medium">{{ $appointment->location }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($appointment->concerns)
                                <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Concerns</p>
                                    <p class="text-gray-700">{{ $appointment->concerns }}</p>
                                </div>
                            @endif

                            @if($appointment->consultant_report)
                                <div class="mt-4 bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                    <p class="text-xs font-semibold text-blue-700 uppercase mb-2">Consultant Report</p>
                                    <div class="text-gray-700">{!! nl2br(e($appointment->consultant_report)) !!}</div>
                                </div>
                            @endif

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                    View Details →
                                </a>
                                @if($appointment->consultant_report)
                                    <a href="{{ route('appointments.consultationReport', $appointment) }}" target="_blank" class="text-green-600 hover:text-green-700 text-sm font-semibold">
                                        View Full Report →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">No appointments recorded yet</p>
                </div>
            @endif
        </div>

        <!-- Dr. C AI Sessions -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-blue-100">
                🤖 Dr. C AI Sessions ({{ $drCSessions->count() }})
            </h3>

            @if($drCSessions->count() > 0)
                <div class="space-y-4">
                    @foreach($drCSessions as $session)
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-purple-300 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900">Session #{{ $session->id }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $session->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    {{ $session->messages->count() }} messages
                                </span>
                            </div>

                            @if($session->messages->count() > 0)
                                <div class="bg-gray-50 p-4 rounded-lg mt-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">First Message</p>
                                    <p class="text-gray-700 line-clamp-2">{{ $session->messages->first()->message }}</p>
                                </div>
                            @endif

                            <div class="mt-4">
                                <a href="{{ route('dr-c.viewReport', $session) }}" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                                    View Full Session →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">No AI consultation sessions yet</p>
                </div>
            @endif
        </div>

        <!-- Consultation Records -->
        @if($consultations->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-blue-100">
                    💬 Consultation Records ({{ $consultations->count() }})
                </h3>

                <div class="space-y-4">
                    @foreach($consultations as $consultation)
                        <div class="border border-gray-200 rounded-lg p-5">
                            <div class="mb-3">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Date</p>
                                <p class="text-gray-900">{{ $consultation->created_at->format('M d, Y g:i A') }}</p>
                            </div>

                            @if($consultation->concerns)
                                <div class="bg-gray-50 p-4 rounded-lg mb-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Concerns</p>
                                    <p class="text-gray-700">{{ $consultation->concerns }}</p>
                                </div>
                            @endif

                            @if($consultation->response)
                                <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                    <p class="text-xs font-semibold text-blue-700 uppercase mb-2">Response</p>
                                    <div class="text-gray-700">{!! nl2br(e($consultation->response)) !!}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
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
@endsection
