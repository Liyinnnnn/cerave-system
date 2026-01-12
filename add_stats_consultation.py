with open('resources/views/consultation-reports/index.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

# Find where to insert stats (after the header section, before search)
insert_pos = None
for i, line in enumerate(lines):
    if 'View and manage comprehensive consultation records' in line and '</p>' in line:
        # Find the closing </div> after this line
        for j in range(i+1, len(lines)):
            if '</div>' in lines[j] and 'mb-8' not in lines[j]:
                insert_pos = j + 1
                break
        break

if insert_pos:
    stats_html = '''
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

'''
    lines.insert(insert_pos, stats_html)

with open('resources/views/consultation-reports/index.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(lines)

print('✅ Stats cards added!')
