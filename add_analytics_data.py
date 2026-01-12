import re

with open('app/Http/Controllers/AppointmentController.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Find and update the manage method to add analytics data
old_return = '''        return view('appointments.manage', compact(
            'appointments',
            'filter',
            'search',
            'startDate',
            'endDate',
            'statusFilter',
            'searchQuery',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount',
            'todayCount',
            'weekCount',
            'totalCount'
        ));'''

new_return = '''        // Analytics data
        $consultationTypes = (clone $baseQuery)
            ->selectRaw('consultation_type, COUNT(*) as count')
            ->groupBy('consultation_type')
            ->get();

        $dailyTrend = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('appointments.manage', compact(
            'appointments',
            'filter',
            'search',
            'startDate',
            'endDate',
            'statusFilter',
            'searchQuery',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount',
            'todayCount',
            'weekCount',
            'totalCount',
            'consultationTypes',
            'dailyTrend'
        ));'''

content = content.replace(old_return, new_return)

with open('app/Http/Controllers/AppointmentController.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('AppointmentController updated with analytics data')
