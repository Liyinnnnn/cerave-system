import re

with open('app/Http/Controllers/AppointmentController.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace the manage method with enhanced version
old_manage = r'''    public function manage\(Request \$request\)
    \{
        \$user = \$request->user\(\);

        if \(!\$user->isAdmin\(\) && !\$user->isConsultant\(\)\) \{
            return redirect\(\)->route\('dashboard'\)->with\('error', 'Unauthorized access\.'\);
        \}

        \$filter = \$request->input\('status', 'all'\);
        \$search = \$request->input\('search'\);
        \$query = Appointment::query\(\);

        // Apply search
        if \(\$search\) \{
            \$query->where\(function\(\$q\) use \(\$search\) \{
                \$q->where\('name', 'like', "%\{\$search\}%"\)
                  ->orWhere\('email', 'like', "%\{\$search\}%"\)
                  ->orWhere\('phone', 'like', "%\{\$search\}%"\)
                  ->orWhere\('concerns', 'like', "%\{\$search\}%"\);
            \}\);
        \}

        // Apply filters
        if \(\$filter === 'pending'\) \{
            \$query->where\('status', 'pending'\);
        \} elseif \(\$filter === 'confirmed'\) \{
            \$query->where\('status', 'confirmed'\);
        \} elseif \(\$filter === 'completed'\) \{
            \$query->where\('status', 'completed'\);
        \} elseif \(\$filter === 'cancelled'\) \{
            \$query->where\('status', 'cancelled'\);
        \} elseif \(\$filter === 'today'\) \{
            \$query->whereDate\('preferred_date', today\(\)\);
        \}

        \$appointments = \$query->latest\(\)->paginate\(20\);

        // Get counts for stats
        \$pendingCount = Appointment::where\('status', 'pending'\)->count\(\);
        \$confirmedCount = Appointment::where\('status', 'confirmed'\)->count\(\);
        \$completedCount = Appointment::where\('status', 'completed'\)->count\(\);
        \$cancelledCount = Appointment::where\('status', 'cancelled'\)->count\(\);
        \$todayCount = Appointment::whereDate\('preferred_date', today\(\)\)->count\(\);
        \$weekCount = Appointment::whereBetween\('preferred_date', \[now\(\)->startOfWeek\(\), now\(\)->endOfWeek\(\)\]\)->count\(\);
        \$totalCount = Appointment::count\(\);'''

new_manage = '''    public function manage(Request $request)
    {
        $user = $request->user();

        if (!$user->isAdmin() && !$user->isConsultant()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        // Get date range filters
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $statusFilter = $request->input('status');
        $searchQuery = $request->input('search');

        // Base query with date range
        $baseQuery = Appointment::whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply status filter if provided
        if ($statusFilter) {
            $baseQuery->where('status', $statusFilter);
        }
        
        // Apply search filter if provided (search by name or ID)
        if ($searchQuery) {
            $baseQuery->whereHas('user', function($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%")
                      ->orWhere('id', $searchQuery);
            })->orWhere('id', $searchQuery);
        }

        $appointments = (clone $baseQuery)->latest()->paginate(20);

        // Get counts for stats
        $pendingCount = (clone $baseQuery)->where('status', 'pending')->count();
        $confirmedCount = (clone $baseQuery)->where('status', 'confirmed')->count();
        $completedCount = (clone $baseQuery)->where('status', 'completed')->count();
        $cancelledCount = (clone $baseQuery)->where('status', 'cancelled')->count();
        $totalCount = (clone $baseQuery)->count();
        
        // Legacy counts for reference
        $todayCount = Appointment::whereDate('preferred_date', today())->count();
        $weekCount = Appointment::whereBetween('preferred_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
        
        $filter = $statusFilter ?? 'all';'''

content = re.sub(old_manage, new_manage, content, flags=re.DOTALL)

with open('app/Http/Controllers/AppointmentController.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('AppointmentController updated successfully')
