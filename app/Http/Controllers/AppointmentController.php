<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Product;
use App\Notifications\AppointmentCreated;
use App\Notifications\AppointmentStatusChanged;
use App\Notifications\NewAppointmentForAdmin;
use App\Mail\AppointmentReceived;
use App\Mail\AppointmentConfirmed;
use App\Mail\ConsultationReportReady;
use Illuminate\Support\Facades\Mail;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    use ResponseHelper;

    /**
     * Store a new appointment.
     * Consumers and consultants can create appointments.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Appointment submission started', ['user_id' => auth()->id()]);

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email',
                'phone' => 'required|string|max:30',
                'preferred_date' => 'required|date|after_or_equal:today',
                'preferred_time' => 'required',
                'consultation_type' => 'required|in:in-store,online',
                'location' => 'nullable|string|max:255',
                'concerns' => 'nullable|string|max:1000',
            ]);

            Log::info('Validation passed', $validated);

            $validated['user_id'] = auth()->id();
            $validated['status'] = 'pending';

            $appointment = Appointment::create($validated);
            Log::info('Appointment created', ['id' => $appointment->id]);

            // Send confirmation email via Laravel's default Mail (simplest approach)
            Mail::to($validated['email'])->send(new AppointmentReceived($appointment));
            Log::info('Customer confirmation mail sent', ['email' => $validated['email']]);

            // Notify all admins about new appointment (send immediately)
            $admins = User::where('role', 'admin')->get();
            if ($admins->count() > 0) {
                Notification::sendNow($admins, new NewAppointmentForAdmin($appointment));
            }
            Log::info('Admin notifications dispatched', ['admin_count' => $admins->count()]);

            if ($request->expectsJson()) {
                return $this->success('Appointment request submitted successfully!');
            }

            // Return back to the form so guests see the success message
            return back()->with('success', 'Appointment request submitted successfully! We will contact you shortly to confirm.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Appointment validation failed', ['errors' => $e->errors()]);
            if ($request->expectsJson()) {
                return $this->validationError($e->errors());
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Appointment creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'data' => $request->all()
            ]);
            if ($request->expectsJson()) {
                return $this->error('Failed to create appointment: ' . $e->getMessage(), 'ERR_APPOINTMENT_CREATE');
            }
            return back()->with('error', 'Failed to create appointment: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Get all appointments (admin/consultant) or user's appointments (consumer).
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $status = $request->get('status');
            $allowedStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];

            $query = ($user->isAdmin() || $user->isConsultant())
                ? Appointment::query()
                : Appointment::where('user_id', $user->id);

            if (is_string($status) && in_array($status, $allowedStatuses, true)) {
                $query->where('status', $status);
            }

            $appointments = $query->latest()->paginate(15);

            return view('appointments.index', compact('appointments', 'status'));
        } catch (\Exception $e) {
            \Log::error('Appointments index failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load appointments.', 'ERR_APPOINTMENT_INDEX');
        }
    }

    /**
     * Show single appointment (with ownership check).
     */
    public function show(Appointment $appointment)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin() && !$user->isConsultant() && $appointment->user_id !== $user->id) {
                return $this->unauthorized('You cannot view this appointment.');
            }

            $consultants = User::where('role', 'consultant')->get();
            $products = Product::orderBy('name')->get();

            return view('appointments.show', compact('appointment', 'consultants', 'products'));
        } catch (\Exception $e) {
            \Log::error('Appointment show failed', ['error' => $e->getMessage()]);
            return $this->notFound();
        }
    }

    /**
     * Update appointment (admin/creator only).
     */
    public function update(Request $request, Appointment $appointment)
    {
        try {
            $user = $request->user();

            if (!$user->isAdmin() && !$user->isConsultant() && $appointment->user_id !== $user->id) {
                return redirect()->back()->with('error', 'You cannot modify this appointment.');
            }

            $validated = $request->validate([
                'preferred_date' => 'nullable|date|after_or_equal:today',
                'preferred_time' => 'nullable',
                'consultation_type' => 'nullable|in:in-store,online',
                'location' => 'nullable|string|max:255',
                'concerns' => 'nullable|string|max:1000',
                'solution' => 'nullable|string|max:2000',
                'ai_suggestion' => 'nullable|string|max:2000',
                'consultant_notes' => 'nullable|string|max:2000',
                'suggested_products' => 'nullable|string|max:2000',
                'usage_instructions' => 'nullable|string|max:2000',
                'purchased_products' => 'nullable|string|max:2000',
                'status' => 'nullable|in:pending,confirmed,completed,cancelled',
                'consultant_id' => 'nullable|exists:users,id',
            ]);

            $data = array_filter($validated, static fn($value) => $value !== null && $value !== '');

            $oldStatus = $appointment->status;
            $statusChanged = isset($data['status']) && $data['status'] !== $oldStatus;

            if (isset($data['status']) && $data['status'] === 'completed' && !$appointment->completed_at) {
                $data['completed_at'] = Carbon::now();
            }

            $appointment->update($data);
            Log::info('Appointment updated', ['id' => $appointment->id, 'changes' => $data]);

            // Send notification if status changed
            if ($statusChanged && $appointment->user) {
                $appointment->user->notify(new AppointmentStatusChanged($appointment, $oldStatus));
                Log::info('Status change notification sent', ['appointment_id' => $appointment->id]);
                
                // Send confirmation email when status changes to confirmed
                if ($data['status'] === 'confirmed') {
                    Mail::to($appointment->email)->send(new AppointmentConfirmed($appointment));
                    Log::info('Confirmation email sent', ['appointment_id' => $appointment->id, 'email' => $appointment->email]);
                }
            }

            if ($request->expectsJson()) {
                return $this->success('Appointment updated successfully!');
            }

            return redirect()->back()->with('success', 'Appointment updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Appointment update failed', ['error' => $e->getMessage()]);
            if ($request->expectsJson()) {
                return $this->error('Failed to update appointment.', 'ERR_APPOINTMENT_UPDATE');
            }
            return back()->with('error', 'Failed to update appointment.');
        }
    }

    /**
     * Delete appointment (admin only).
     */
    public function destroy(Appointment $appointment)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin()) {
                return redirect()->back()->with('error', 'Only admins can delete appointments.');
            }

            $appointment->delete();

            if (request()->expectsJson()) {
                return $this->success('Appointment deleted successfully!');
            }

            return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Appointment deletion failed', ['error' => $e->getMessage()]);
            if (request()->expectsJson()) {
                return $this->error('Failed to delete appointment.', 'ERR_APPOINTMENT_DELETE');
            }
            return back()->with('error', 'Failed to delete appointment.');
        }
    }

    /**
     * Admin management dashboard for appointments.
     */
    public function manage(Request $request)
    {
        $user = $request->user();

        if (!$user->isAdmin() && !$user->isConsultant()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $filter = $request->input('status', 'all');
        $query = Appointment::query();

        // Apply filters
        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'confirmed') {
            $query->where('status', 'confirmed');
        } elseif ($filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter === 'cancelled') {
            $query->where('status', 'cancelled');
        } elseif ($filter === 'today') {
            $query->whereDate('preferred_date', today());
        }

        $appointments = $query->latest()->paginate(20);

        // Get counts for stats
        $pendingCount = Appointment::where('status', 'pending')->count();
        $confirmedCount = Appointment::where('status', 'confirmed')->count();
        $completedCount = Appointment::where('status', 'completed')->count();
        $cancelledCount = Appointment::where('status', 'cancelled')->count();
        $todayCount = Appointment::whereDate('preferred_date', today())->count();
        $weekCount = Appointment::whereBetween('preferred_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $totalCount = Appointment::count();

        return view('appointments.manage', compact(
            'appointments',
            'filter',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount',
            'todayCount',
            'weekCount',
            'totalCount'
        ));
    }

    /**
     * Submit consultation report for admin approval (consultant only).
     */
    public function submitReport(Request $request, Appointment $appointment)
    {
        try {
            $user = $request->user();

            if (!$user->isConsultant()) {
                return redirect()->back()->with('error', 'Only consultants can submit consultation reports.');
            }

            // Validate that consultation details are filled
            if (empty($appointment->solution) || empty($appointment->consultant_notes)) {
                return redirect()->back()->with('error', 'Please fill in consultation details before submitting report.');
            }

            $appointment->update([
                'report_status' => 'pending_approval',
                'report_submitted_at' => now(),
                'report_submitted_by' => $user->id,
            ]);

            Log::info('Consultation report submitted for approval', [
                'appointment_id' => $appointment->id,
                'submitted_by' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Consultation report submitted for admin approval.');
        } catch (\Exception $e) {
            Log::error('Report submission failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to submit report.');
        }
    }

    /**
     * Approve or reject consultation report (admin only).
     */
    public function approveReport(Request $request, Appointment $appointment)
    {
        try {
            $user = $request->user();

            if (!$user->isAdmin()) {
                return redirect()->back()->with('error', 'Only admins can approve consultation reports.');
            }

            $validated = $request->validate([
                'action' => 'required|in:approve,reject',
                'admin_feedback' => 'nullable|string|max:2000',
            ]);

            $appointment->update([
                'report_status' => $validated['action'] === 'approve' ? 'approved' : 'rejected',
                'report_approved_at' => now(),
                'report_approved_by' => $user->id,
                'admin_feedback' => $validated['admin_feedback'] ?? null,
            ]);

            Log::info('Consultation report ' . $validated['action'] . 'd', [
                'appointment_id' => $appointment->id,
                'approved_by' => $user->id,
            ]);
            
            // Send email when report is approved
            if ($validated['action'] === 'approve') {
                Mail::to($appointment->email)->send(new ConsultationReportReady($appointment));
                Log::info('Consultation report email sent', ['appointment_id' => $appointment->id, 'email' => $appointment->email]);
            }

            $message = $validated['action'] === 'approve' 
                ? 'Consultation report approved successfully.' 
                : 'Consultation report rejected.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Report approval failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to process report approval.');
        }
    }

    /**
     * Generate printable consultation report for an appointment.
     */
    public function consultationReport(Appointment $appointment)
    {
        try {
            $user = auth()->user();

            // Check if user can view this report
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login to view consultation report.');
            }

            // Authorization: user owns appointment, or is consultant/admin
            if (!$user->isAdmin() && !$user->isConsultant() && $appointment->user_id !== $user->id) {
                return redirect()->back()->with('error', 'You are not authorized to view this report.');
            }

            // Extract product IDs from suggested_products JSON
            $recommendedProducts = collect();
            if ($appointment->suggested_products) {
                try {
                    $productData = is_string($appointment->suggested_products) 
                        ? json_decode($appointment->suggested_products, true) 
                        : $appointment->suggested_products;
                    
                    if (is_array($productData)) {
                        $productIds = collect($productData)->pluck('id')->filter();
                        $recommendedProducts = \App\Models\Product::whereIn('id', $productIds)->get();
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to parse suggested products', ['error' => $e->getMessage()]);
                }
            }

            // Determine consultant name
            $consultantName = $appointment->consultant 
                ? $appointment->consultant->name 
                : 'Dr. C (AI Assistant)';

            // Determine consultation method
            $consultationMethod = ucfirst($appointment->consultation_type ?? 'Online');
            if ($consultationMethod === 'In-store') {
                $consultationMethod = 'Physical (In-Store)';
            } elseif ($consultationMethod === 'Online') {
                $consultationMethod = 'Online Video Call';
            }

            return view('appointments.consultation-report', compact(
                'appointment', 
                'recommendedProducts', 
                'consultantName', 
                'consultationMethod'
            ));
        } catch (\Exception $e) {
            Log::error('Consultation report view failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate consultation report.');
        }
    }

    /**
     * Generate consultant report for appointment
     */
    public function generateReport(Request $request, Appointment $appointment)
    {
        try {
            $user = $request->user();

            if (!$user->isConsultant() && !$user->isAdmin()) {
                return redirect()->back()->with('error', 'Only consultants can generate reports.');
            }

            $validated = $request->validate([
                'skin_assessment' => 'required|string|max:5000',
                'recommended_products' => 'required|array|min:1',
                'recommended_products.*' => 'integer|exists:products,id',
                'skincare_advice' => 'required|string|max:5000',
                'lifestyle_tips' => 'nullable|string|max:5000',
            ]);

            $appointment->update([
                'skin_assessment' => $validated['skin_assessment'],
                'recommended_products' => $validated['recommended_products'],
                'skincare_advice' => $validated['skincare_advice'],
                'lifestyle_tips' => $validated['lifestyle_tips'] ?? null,
                'report_generated_at' => now(),
            ]);

            // Send notification to user
            $appointment->user->notify(new \App\Notifications\ConsultationReportCompleted(
                $appointment,
                route('appointments.report', $appointment)
            ));

            return redirect()->route('appointments.show', $appointment)
                ->with('success', 'Consultation report generated successfully!');
        } catch (\Exception $e) {
            Log::error('Report generation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    /**
     * View generated consultant report
     */
    public function viewReport(Appointment $appointment)
    {
        try {
            if (!$appointment->report_generated_at) {
                return redirect()->back()->with('error', 'No report has been generated for this appointment.');
            }

            // Get recommended products
            $recommendedProducts = \App\Models\Product::whereIn('id', $appointment->recommended_products ?? [])->get();

            return view('appointments.consultant-report', compact('appointment', 'recommendedProducts'));
        } catch (\Exception $e) {
            Log::error('Report view failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to view report.');
        }
    }
}

