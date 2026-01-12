<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\DrCSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ConsultationReportController extends Controller
{
    /**
     * Display list of users for consultation report (Admin/Consultant only)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isConsultant()) {
            abort(403, 'Unauthorized access');
        }

        $search = $request->get('search');
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $status = $request->get('status');
        
        $users = User::where('role', 'consumer')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('id', $search);
                });
            })
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->when($status === 'active', function($query) {
                $query->where(function($q) {
                    $q->has('appointments')->orHas('drCSessions');
                });
            })
            ->when($status === 'inactive', function($query) {
                $query->doesntHave('appointments')->doesntHave('drCSessions');
            })
            ->withCount(['appointments', 'drCSessions'])
            ->latest()
            ->paginate(20);

        // Calculate statistics
        $totalUsers = User::where('role', 'consumer')->count();
        $totalAppointments = Appointment::whereIn('user_id', User::where('role', 'consumer')->pluck('id'))->count();
        $totalDrCSessions = DrCSession::whereIn('user_id', User::where('role', 'consumer')->pluck('id'))->count();
        $avgAppointments = $totalUsers > 0 ? round($totalAppointments / $totalUsers, 1) : 0;

        // Analytics data - User registration trend (last 30 days)
        $dailyUserTrend = User::where('role', 'consumer')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Engagement breakdown (users with appointments vs Dr. C only vs inactive)
        $usersWithAppointments = User::where('role', 'consumer')
            ->has('appointments')
            ->count();
        $usersWithDrCOnly = User::where('role', 'consumer')
            ->has('drCSessions')
            ->doesntHave('appointments')
            ->count();
        $inactiveUsers = User::where('role', 'consumer')
            ->doesntHave('appointments')
            ->doesntHave('drCSessions')
            ->count();

        $engagementData = [
            ['type' => 'With Appointments', 'count' => $usersWithAppointments],
            ['type' => 'Dr. C Only', 'count' => $usersWithDrCOnly],
            ['type' => 'Inactive', 'count' => $inactiveUsers],
        ];

        return view('consultation-reports.index', compact('users', 'search', 'totalUsers', 'totalAppointments', 'totalDrCSessions', 'avgAppointments', 'dailyUserTrend', 'engagementData'));
    }

    /**
     * Display comprehensive consultation report for a specific user
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();

        // Check permissions
        if (!$currentUser->isAdmin() && !$currentUser->isConsultant() && $currentUser->id !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        // Get all appointments with detailed information
        $appointments = Appointment::where('user_id', $user->id)
            ->with('consultant')
            ->orderBy('preferred_date', 'desc')
            ->get();

        // Get all Dr. C AI sessions
        $drCSessions = DrCSession::where('user_id', $user->id)
            ->with('messages')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get consultation records
        $consultations = Consultation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total_appointments' => $appointments->count(),
            'completed_appointments' => $appointments->where('status', 'completed')->count(),
            'pending_appointments' => $appointments->where('status', 'pending')->count(),
            'cancelled_appointments' => $appointments->where('status', 'cancelled')->count(),
            'total_dr_c_sessions' => $drCSessions->count(),
            'total_consultations' => $consultations->count(),
            'last_appointment_date' => $appointments->first()?->preferred_date,
            'last_dr_c_session' => $drCSessions->first()?->created_at,
        ];

        // Parse skin information
        $skinProfile = [
            'skin_type' => $user->skin_type,
            'skin_concerns' => is_string($user->skin_concerns) ? explode(',', $user->skin_concerns) : $user->skin_concerns,
            'skin_conditions' => is_string($user->skin_conditions) ? explode(',', $user->skin_conditions) : $user->skin_conditions,
            'using_products' => $user->using_products ?? [],
            'profile_updated_at' => $user->skincare_profile_updated_at,
        ];

        return view('consultation-reports.show', compact('user', 'appointments', 'drCSessions', 'consultations', 'stats', 'skinProfile'));
    }

    /**
     * Display user's own consultation report
     */
    public function myReport()
    {
        $user = Auth::user();
        return $this->show($user);
    }

    /**
     * Export consultation report as PDF
     */
    public function exportPdf(User $user)
    {
        $currentUser = Auth::user();

        // Check permissions
        if (!$currentUser->isAdmin() && !$currentUser->isConsultant() && $currentUser->id !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        // Get all data (similar to show method)
        $appointments = Appointment::where('user_id', $user->id)
            ->with('consultant')
            ->orderBy('preferred_date', 'desc')
            ->get();

        $drCSessions = DrCSession::where('user_id', $user->id)
            ->with('messages')
            ->orderBy('created_at', 'desc')
            ->get();

        $consultations = Consultation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_appointments' => $appointments->count(),
            'completed_appointments' => $appointments->where('status', 'completed')->count(),
            'pending_appointments' => $appointments->where('status', 'pending')->count(),
            'cancelled_appointments' => $appointments->where('status', 'cancelled')->count(),
            'total_dr_c_sessions' => $drCSessions->count(),
            'total_consultations' => $consultations->count(),
            'last_appointment_date' => $appointments->first()?->preferred_date,
            'last_dr_c_session' => $drCSessions->first()?->created_at,
        ];

        $skinProfile = [
            'skin_type' => $user->skin_type,
            'skin_concerns' => is_string($user->skin_concerns) ? explode(',', $user->skin_concerns) : $user->skin_concerns,
            'skin_conditions' => is_string($user->skin_conditions) ? explode(',', $user->skin_conditions) : $user->skin_conditions,
            'using_products' => $user->using_products ?? [],
            'profile_updated_at' => $user->skincare_profile_updated_at,
        ];

        return view('consultation-reports.pdf', compact('user', 'appointments', 'drCSessions', 'consultations', 'stats', 'skinProfile'));
    }

    /**
     * Get consultation report data (API endpoint)
     */
    public function getData(User $user)
    {
        $currentUser = Auth::user();

        if (!$currentUser->isAdmin() && !$currentUser->isConsultant() && $currentUser->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $appointments = Appointment::where('user_id', $user->id)
            ->with('consultant')
            ->orderBy('preferred_date', 'desc')
            ->get();

        $drCSessions = DrCSession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $consultations = Consultation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'user' => $user,
            'appointments' => $appointments,
            'dr_c_sessions' => $drCSessions,
            'consultations' => $consultations,
            'stats' => [
                'total_appointments' => $appointments->count(),
                'completed_appointments' => $appointments->where('status', 'completed')->count(),
                'total_dr_c_sessions' => $drCSessions->count(),
                'total_consultations' => $consultations->count(),
            ]
        ]);
    }
}
