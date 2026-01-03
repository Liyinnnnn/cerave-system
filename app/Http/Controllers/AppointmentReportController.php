<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentReportController extends Controller
{
    use ResponseHelper;

    /**
     * Display appointment statistics and reporting dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->isAdmin() && !$user->isConsultant()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        // Date range filter
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $statusFilter = $request->input('status');

        // Base query
        $baseQuery = Appointment::whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply status filter if provided
        if ($statusFilter) {
            $baseQuery->where('status', $statusFilter);
        }

        // Overall statistics
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => Appointment::where('status', 'pending')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed' => Appointment::where('status', 'completed')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        // Consultation type breakdown
        $consultationTypes = (clone $baseQuery)
            ->selectRaw('consultation_type, COUNT(*) as count')
            ->groupBy('consultation_type')
            ->get();

        // Daily appointment trend (last 30 days)
        $dailyTrend = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent appointments
        $recentAppointments = (clone $baseQuery)
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('appointments.reports', compact('stats', 'consultationTypes', 'dailyTrend', 'recentAppointments', 'startDate', 'endDate'));
    }

    /**
     * Export appointments to CSV.
     */
    public function export(Request $request)
    {
        $user = $request->user();

        if (!$user->isAdmin() && !$user->isConsultant()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $statusFilter = $request->input('status');

        $query = Appointment::with('user')
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        
        $appointments = $query->orderBy('created_at', 'desc')->get();

        $filename = 'appointments_' . $startDate . '_to_' . $endDate . ($statusFilter ? '_' . $statusFilter : '') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($appointments) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Date',
                'Time',
                'Type',
                'Status',
                'Concerns',
                'Solution',
                'AI Suggestion',
                'Consultant Notes',
                'Suggested Products',
                'Usage Instructions',
                'Purchased Products',
                'Created At',
                'Completed At',
            ]);

            // Data rows
            foreach ($appointments as $appointment) {
                fputcsv($file, [
                    $appointment->id,
                    $appointment->name,
                    $appointment->email,
                    $appointment->phone,
                    $appointment->preferred_date,
                    $appointment->preferred_time,
                    $appointment->consultation_type,
                    $appointment->status,
                    $appointment->concerns,
                    $appointment->solution,
                    $appointment->ai_suggestion,
                    $appointment->consultant_notes,
                    $appointment->suggested_products,
                    $appointment->usage_instructions,
                    $appointment->purchased_products,
                    $appointment->created_at,
                    $appointment->completed_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
