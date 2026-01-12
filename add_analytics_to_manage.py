import re

with open('resources/views/appointments/manage.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Find the position right after the filter form and before the Success Message section
charts_section = '''
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

'''

# Insert charts section before the success message
content = content.replace('        <!-- Success Message -->', charts_section + '        <!-- Success Message -->')

with open('resources/views/appointments/manage.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Analytics dashboard added to manage page successfully')
