@extends('layouts.guest')
@php use Illuminate\Support\Str; @endphp

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40 dark:bg-slate-900 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-3 text-sm py-3 text-gray-800 dark:text-gray-200">
            <a href="{{ route('appointments.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">All Appointments</a>
            <span>&gt;</span>
            <span class="text-gray-500 dark:text-gray-400">Manage</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-cyan-100 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 dark:text-white">Appointment Management</h1>
            <p class="text-gray-600 dark:text-blue-200">Review, approve, and manage all appointments</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1 dark:text-yellow-400">{{ $pendingCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center dark:bg-yellow-900">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Confirmed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1 dark:text-green-400">{{ $confirmedCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center dark:bg-green-900">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Completed</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1 dark:text-blue-400">{{ $completedCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center dark:bg-blue-900">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Cancelled</p>
                        <p class="text-2xl font-bold text-red-600 mt-1 dark:text-red-400">{{ $cancelledCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center dark:bg-red-900">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Total</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1 dark:text-purple-400">{{ $totalCount }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center dark:bg-purple-900">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form with Date Range, Status, and Search -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <form method="GET" action="{{ route('appointments.manage') }}" id="filterForm" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Search</label>
                    <input type="text" name="search" placeholder="Search by name, ID, or email..." value="{{ request('search') ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') ?? now()->subDays(30)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') ?? now()->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">All Statuses</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmed</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium dark:bg-blue-700 dark:hover:bg-blue-800">
                        Search
                    </button>
                </div>
            </form>
        </div>



        <!-- Analytics Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Consultation Type Breakdown -->
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <h2 class="text-xl font-bold text-gray-800 mb-6 dark:text-white">Consultation Type Breakdown</h2>
                <div class="space-y-5">
                    @foreach($consultationTypes as $type)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-700 dark:text-blue-200">{{ ucfirst($type->consultation_type) }}</span>
                                <span class="text-sm font-bold text-primary dark:text-blue-300">{{ $type->count }} ({{ $totalCount > 0 ? round(($type->count / $totalCount) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-slate-700 overflow-hidden">
                                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 h-4 rounded-full dark:from-cyan-400 dark:to-blue-500 transition-all duration-500" style="width: {{ $totalCount > 0 ? ($type->count / $totalCount) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Daily Trend Chart with Chart.js -->
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <h2 class="text-xl font-bold text-gray-800 mb-6 dark:text-white">Daily Appointment Trend</h2>
                <div style="position: relative; height: 300px;">
                    <canvas id="appointmentTrendChart"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('appointmentTrendChart');
                if (ctx) {
                    const data = @json($dailyTrend ?? []);
                    const labels = data.map(d => new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                    const counts = data.map(d => d.count);
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Appointments',
                                data: counts,
                                borderColor: '#0ea5e9',
                                backgroundColor: 'rgba(6, 182, 212, 0.15)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 6,
                                pointBackgroundColor: '#0ea5e9',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 8,
                                pointHoverBackgroundColor: '#06b6d4',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(100, 116, 139, 0.3)' : 'rgba(96, 165, 250, 0.3)',
                                    },
                                    ticks: {
                                        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#cbd5e1' : '#1e40af',
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false,
                                    },
                                    ticks: {
                                        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#cbd5e1' : '#1e40af',
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>

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

        <!-- Appointments List -->
        @if($appointments->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Date & Time</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($appointments as $appointment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">#{{ $appointment->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $appointment->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-blue-300">{{ Str::limit($appointment->concerns, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $appointment->email }}</div>
                                        <div class="text-sm text-gray-500 dark:text-blue-300">{{ $appointment->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500 dark:text-blue-300">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-blue-300">
                                        {{ ucfirst($appointment->consultation_type) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($appointment->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="text-primary hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                                            @if($appointment->status === 'pending')
                                                <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">Confirm</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $appointments->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 dark:text-white">No Appointments Found</h3>
                <p class="text-gray-600 dark:text-blue-200">There are no appointments matching your filter.</p>
            </div>
        @endif
    </div>
</div>
@endsection
