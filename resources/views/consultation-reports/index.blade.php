@extends('layouts.guest')
@php use Illuminate\Support\Str; @endphp

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40 dark:bg-slate-900 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-3 text-sm py-3 text-gray-800 dark:text-gray-200">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
            <span>&gt;</span>
            <span class="text-gray-500 dark:text-gray-400">Consultation Reports</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-cyan-100 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 dark:text-white">Consultation Reports</h1>
            <p class="text-gray-600 dark:text-blue-200">View and manage comprehensive consultation records</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Total Users</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1 dark:text-white">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center dark:bg-blue-900">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Total Appointments</p>
                        <p class="text-2xl font-bold text-green-600 mt-1 dark:text-green-400">{{ $totalAppointments ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center dark:bg-green-900">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Dr. C Sessions</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1 dark:text-purple-400">{{ $totalDrCSessions ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center dark:bg-purple-900">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Avg Appointments</p>
                        <p class="text-2xl font-bold text-cyan-600 mt-1 dark:text-cyan-400">{{ $avgAppointments ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-cyan-100 rounded-full flex items-center justify-center dark:bg-cyan-900">
                        <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <form method="GET" action="{{ route('consultation-reports.index') }}" id="filterForm" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
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
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
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
            <!-- User Engagement Breakdown -->
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <h2 class="text-xl font-bold text-gray-800 mb-6 dark:text-white">User Engagement Breakdown</h2>
                <div class="space-y-5">
                    @foreach($engagementData as $data)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-700 dark:text-blue-200">{{ $data['type'] }}</span>
                                <span class="text-sm font-bold text-primary dark:text-blue-300">{{ $data['count'] }} ({{ $totalUsers > 0 ? round(($data['count'] / $totalUsers) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-slate-700 overflow-hidden">
                                <div class="
                                    @if($data['type'] === 'With Appointments') bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-400 dark:to-emerald-500
                                    @elseif($data['type'] === 'Dr. C Only') bg-gradient-to-r from-purple-500 to-indigo-600 dark:from-purple-400 dark:to-indigo-500
                                    @else bg-gradient-to-r from-gray-400 to-gray-600 dark:from-gray-500 dark:to-gray-700
                                    @endif
                                    h-4 rounded-full transition-all duration-500" style="width: {{ $totalUsers > 0 ? ($data['count'] / $totalUsers) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Daily User Registration Trend -->
            <div class="bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <h2 class="text-xl font-bold text-gray-800 mb-6 dark:text-white">User Registration Trend (30 Days)</h2>
                <div style="position: relative; height: 300px;">
                    <canvas id="userTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Users List Table -->
        @if($users->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Appointments</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Dr. C Sessions</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Joined</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($user->profile_picture)
                                                <img class="w-10 h-10 rounded-full object-cover" src="{{ $user->profile_image_url }}" alt="{{ $user->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                                @if($user->nickname)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->nickname }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-sm text-gray-500 dark:text-blue-300">{{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $user->appointments_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ $user->dr_c_sessions_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-blue-300">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('consultation-reports.show', $user) }}" class="text-primary hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                                            <a href="{{ route('consultation-reports.export-pdf', $user) }}" target="_blank" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">Print</a>
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
                {{ $users->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 dark:text-white">No Users Found</h3>
                <p class="text-gray-600 dark:text-blue-200">
                    @if($search)
                        No users match your search criteria.
                    @else
                        No consumer accounts registered yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('userTrendChart');
        if (ctx) {
            const data = @json($dailyUserTrend ?? []);
            const labels = data.map(d => new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
            const counts = data.map(d => d.count);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'New Users',
                        data: counts,
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.15)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#8b5cf6',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#64748b'
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
