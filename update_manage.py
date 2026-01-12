import re

with open('resources/views/appointments/manage.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Find and replace the filter section
old_pattern = r'        <!-- Filter Tabs -->.*?        </div>\n\n        <!-- Search & Filter Bar -->.*?        </div>'

new_text = '''        <!-- Filter Form with Date Range, Status, and Search -->
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
        </div>'''

content = re.sub(old_pattern, new_text, content, flags=re.DOTALL)

# Also replace 'Quick Stats' with 'Statistics Cards'
content = content.replace('<!-- Quick Stats -->', '<!-- Statistics Cards -->')

with open('resources/views/appointments/manage.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('File updated successfully')
