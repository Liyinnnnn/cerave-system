<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnalyticsController extends Controller
{
    public function index()
    {
        $metrics = [
            'totalUsers' => User::count(),
            'totalAppointments' => Appointment::count(),
            'completedAppointments' => Appointment::where('status', 'completed')->count(),
            'totalConsultations' => Consultation::count(),
        ];

        $appointmentsOverTime = Appointment::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $appointmentsLabels = $appointmentsOverTime
            ->pluck('month')
            ->map(fn ($m) => Carbon::createFromFormat('Y-m', $m)->format('M Y'));
        $appointmentsSeries = $appointmentsOverTime->pluck('total');

        $consultationTypes = Appointment::selectRaw('consultation_type, COUNT(*) as total')
            ->groupBy('consultation_type')
            ->get();

        $skinTypes = User::whereNotNull('skin_type')
            ->selectRaw('skin_type, COUNT(*) as total')
            ->groupBy('skin_type')
            ->get();

        $topProductCounts = Appointment::whereNotNull('recommended_products')
            ->get()
            ->flatMap(fn ($appointment) => $appointment->recommended_products ?? [])
            ->countBy()
            ->sortDesc()
            ->take(5);

        $topProducts = Product::whereIn('id', $topProductCounts->keys()->all())
            ->get(['id', 'name']);

        $topProductSeries = $topProducts
            ->map(function ($product) use ($topProductCounts) {
                return [
                    'name' => $product->name,
                    'count' => $topProductCounts->get($product->id, 0),
                ];
            })
            ->sortByDesc('count')
            ->values();

        return view('admin.analytics', [
            'metrics' => $metrics,
            'appointmentsLabels' => $appointmentsLabels,
            'appointmentsSeries' => $appointmentsSeries,
            'consultationTypes' => $consultationTypes,
            'skinTypes' => $skinTypes,
            'topProductSeries' => $topProductSeries,
        ]);
    }
}
