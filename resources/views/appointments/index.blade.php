@extends('layouts.guest')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 dark:text-white">My Appointments</h1>
            <p class="text-gray-600 dark:text-blue-200">Manage your skincare consultation appointments</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg dark:bg-green-900 dark:bg-opacity-20 dark:border-green-400">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-green-700 font-medium dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Appointments Grid -->
        @if($appointments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($appointments as $appointment)
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800 hover:shadow-xl transition-shadow">
                        <!-- Status Badge -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($appointment->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                #{{ $appointment->id }}
                            </span>
                        </div>

                        <!-- Appointment Details -->
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-700 dark:text-blue-200">
                                <svg class="w-5 h-5 mr-3 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-semibold">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</span>
                            </div>

                            <div class="flex items-center text-gray-700 dark:text-blue-200">
                                <svg class="w-5 h-5 mr-3 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</span>
                            </div>

                            <div class="flex items-center text-gray-700 dark:text-blue-200">
                                <svg class="w-5 h-5 mr-3 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ ucfirst($appointment->consultation_type) }}</span>
                            </div>

                            @if($appointment->concerns)
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                                    <p class="text-sm text-gray-600 dark:text-blue-300 font-semibold mb-1">Concerns:</p>
                                    <p class="text-sm text-gray-700 dark:text-blue-200">{{ Str::limit($appointment->concerns, 80) }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 flex gap-2">
                            <a href="{{ route('appointments.show', $appointment) }}" 
                               class="flex-1 text-center px-3 py-1.5 bg-primary text-white rounded text-xs font-medium hover:bg-blue-700 transition dark:bg-blue-700 dark:hover:bg-blue-800">
                                View
                            </a>
                            @if($appointment->status === 'pending' && auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="w-full px-3 py-1.5 bg-green-600 text-white rounded text-xs font-medium hover:bg-green-700 transition dark:bg-green-700 dark:hover:bg-green-800">
                                        Confirm
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 dark:text-white">No Appointments Yet</h3>
                <p class="text-gray-600 mb-6 dark:text-blue-200">You haven't scheduled any consultations.</p>
                <a href="{{ url('/dashboard#appointment') }}" 
                   class="inline-block px-5 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium dark:bg-blue-700 dark:hover:bg-blue-800">
                    Book an Appointment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
