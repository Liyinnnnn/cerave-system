with open('app/Http/Controllers/ConsultationReportController.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Update the index method to add statistics
old_return = "return view('consultation-reports.index', compact('users', 'search'));"

new_return = """// Calculate statistics
        \$totalUsers = User::where('role', 'consumer')->count();
        \$totalAppointments = Appointment::whereIn('user_id', User::where('role', 'consumer')->pluck('id'))->count();
        \$totalDrCSessions = DrCSession::whereIn('user_id', User::where('role', 'consumer')->pluck('id'))->count();
        \$avgAppointments = \$totalUsers > 0 ? round(\$totalAppointments / \$totalUsers, 1) : 0;

        return view('consultation-reports.index', compact('users', 'search', 'totalUsers', 'totalAppointments', 'totalDrCSessions', 'avgAppointments'));"""

content = content.replace(old_return, new_return)

with open('app/Http/Controllers/ConsultationReportController.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Controller updated!')
