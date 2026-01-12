@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 dark:from-slate-900 dark:via-indigo-950 dark:to-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Analytics</h1>
                <p class="text-gray-600 dark:text-gray-300">Overview of users, appointments, and product insights.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('appointments.manage') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:bg-slate-800 dark:border-slate-700 dark:text-white">Manage Appointments</a>
                <a href="{{ route('appointments.manage') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm text-sm font-semibold hover:bg-blue-700">View All Appointments</a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 dark:bg-slate-800 dark:border-slate-700">
                <p class="text-xs uppercase font-semibold text-gray-500">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $metrics['totalUsers'] }}</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 dark:bg-slate-800 dark:border-slate-700">
                <p class="text-xs uppercase font-semibold text-gray-500">Total Appointments</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $metrics['totalAppointments'] }}</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 dark:bg-slate-800 dark:border-slate-700">
                <p class="text-xs uppercase font-semibold text-gray-500">Completed Appointments</p>
                <p class="text-3xl font-bold text-green-600">{{ $metrics['completedAppointments'] }}</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100 dark:bg-slate-800 dark:border-slate-700">
                <p class="text-xs uppercase font-semibold text-gray-500">Consultations</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $metrics['totalConsultations'] }}</p>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 dark:bg-slate-800 dark:border-slate-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Appointments Over Time</h3>
                    <span class="text-xs text-gray-500">Last 6 months</span>
                </div>
                <canvas id="appointmentsChart" height="220"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 dark:bg-slate-800 dark:border-slate-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Top Recommended Products</h3>
                    <span class="text-xs text-gray-500">Top 5</span>
                </div>
                <canvas id="productsChart" height="220"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 dark:bg-slate-800 dark:border-slate-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Consultation Types</h3>
                </div>
                <canvas id="consultationChart" height="220"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 dark:bg-slate-800 dark:border-slate-700">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">User Skin Types</h3>
                </div>
                <canvas id="skinChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const appointmentsData = @json($appointmentsSeries);
    const appointmentsLabels = @json($appointmentsLabels);

    const productLabels = @json($topProductSeries->pluck('name'));
    const productData = @json($topProductSeries->pluck('count'));

    const consultationLabels = @json($consultationTypes->pluck('consultation_type')->map(fn($t) => ucfirst($t ?? 'Unknown')));
    const consultationData = @json($consultationTypes->pluck('total'));

    const skinLabels = @json($skinTypes->pluck('skin_type'));
    const skinData = @json($skinTypes->pluck('total'));

    const palette = ['#2563eb', '#22c55e', '#f97316', '#a855f7', '#06b6d4', '#ef4444', '#eab308'];

    new Chart(document.getElementById('appointmentsChart'), {
        type: 'line',
        data: {
            labels: appointmentsLabels,
            datasets: [{
                label: 'Appointments',
                data: appointmentsData,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.15)',
                borderWidth: 3,
                tension: 0.35,
                fill: true,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    new Chart(document.getElementById('productsChart'), {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Recommendations',
                data: productData,
                backgroundColor: palette.slice(0, productLabels.length),
                borderRadius: 6,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            indexAxis: 'y',
            scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    new Chart(document.getElementById('consultationChart'), {
        type: 'doughnut',
        data: {
            labels: consultationLabels,
            datasets: [{
                data: consultationData,
                backgroundColor: palette.slice(0, consultationLabels.length),
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });

    new Chart(document.getElementById('skinChart'), {
        type: 'pie',
        data: {
            labels: skinLabels,
            datasets: [{
                data: skinData,
                backgroundColor: palette.slice(0, skinLabels.length),
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
