import os

# 1. Remove the reports route from web.php
with open('routes/web.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Remove the reports and export routes
content = content.replace("    Route::get('/appointments/reports/analytics', [\App\Http\Controllers\AppointmentReportController::class, 'index'])->middleware('role:admin,consultant')->name('appointments.reports');\n", '')
content = content.replace("    Route::get('/appointments/reports/export', [\App\Http\Controllers\AppointmentReportController::class, 'export'])->middleware('role:admin,consultant')->name('appointments.export');\n", '')

with open('routes/web.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('✓ Removed routes from web.php')

# 2. Remove the reports link from guest layout
with open('resources/views/layouts/guest.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("                    <li><a href=\"{{ route('appointments.reports') }}\" class=\"flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700\"><i class=\"ri-file-chart-line text-blue-600 dark:text-blue-400\"></i><span>Appointments Report</span></a></li>\n", '')

with open('resources/views/layouts/guest.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('✓ Removed link from navigation menu')

# 3. Update admin analytics page to use manage instead
with open('resources/views/admin/analytics.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("route('appointments.export')", "route('appointments.manage')")
content = content.replace('Export Appointments', 'Manage Appointments')
content = content.replace("route('appointments.reports')", "route('appointments.manage')")
content = content.replace('View Appointment Reports', 'View All Appointments')

with open('resources/views/admin/analytics.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('✓ Updated admin analytics page')

# 4. Delete the reports view file
reports_file = 'resources/views/appointments/reports.blade.php'
if os.path.exists(reports_file):
    os.remove(reports_file)
    print(f'✓ Deleted {reports_file}')

# 5. Delete the AppointmentReportController
controller_file = 'app/Http/Controllers/AppointmentReportController.php'
if os.path.exists(controller_file):
    os.remove(controller_file)
    print(f'✓ Deleted {controller_file}')

print('\n✅ Successfully removed appointments reports - everything now uses manage page!')
