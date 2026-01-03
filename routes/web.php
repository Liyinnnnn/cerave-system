<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DrCController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $title = \App\Models\Setting::get('front_page_title', 'Skincare Developed with Dermatologists');
    $description = \App\Models\Setting::get('front_page_description', 'Experience the power of ceramides with dermatologist-developed formulations for healthy, beautiful skin backed by science.');
    return view('welcome', compact('title', 'description'));
})->name('welcome');

// Product browsing (public) - Note: /products/create must come before /products/{product}
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Admin product create route (must be before {product} wildcard)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});

// Public product show (after /products/create to avoid route conflict)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Dr. C Chat (public access, rate-limited)
Route::get('/dr-c', [DrCController::class, 'chat'])->name('dr-c.chat');
Route::post('/dr-c/send', [DrCController::class, 'send'])->name('dr-c.send');

// Dashboard (authenticated)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Public profile view
Route::get('/user/{id}/profile', [ProfileController::class, 'publicProfile'])->name('user.profile');

// Admin routes (product edit/update/delete + settings)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/products/report', [ProductController::class, 'report'])->name('products.report');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');
    
    // Dr. C Admin management
    Route::get('/admin/dr-c/sessions', [DrCController::class, 'adminSessions'])->name('admin.dr-c.sessions');
    Route::delete('/admin/dr-c/sessions/{session}', [DrCController::class, 'deleteSession'])->name('admin.dr-c.deleteSession');
    Route::get('/admin/settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
    Route::patch('/admin/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/skincare', [ProfileController::class, 'updateSkincare'])->name('profile.skincare.update');
    // Use a distinct name to avoid collision with Breeze's auth password.update
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    // Set password without current password when prompted after OAuth login
    Route::post('/profile/password/set', [ProfileController::class, 'setPassword'])->name('profile.password.set');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Appointments (view/manage requires auth)
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/manage/dashboard', [AppointmentController::class, 'manage'])->middleware('role:admin,consultant')->name('appointments.manage');
    Route::get('/appointments/reports/analytics', [\App\Http\Controllers\AppointmentReportController::class, 'index'])->middleware('role:admin,consultant')->name('appointments.reports');
    Route::get('/appointments/reports/export', [\App\Http\Controllers\AppointmentReportController::class, 'export'])->middleware('role:admin,consultant')->name('appointments.export');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/{appointment}/consultation-report', [AppointmentController::class, 'consultationReport'])->name('appointments.consultationReport');
    Route::get('/appointments/{appointment}/report', [AppointmentController::class, 'viewReport'])->name('appointments.report');
    Route::post('/appointments/{appointment}/generate-report', [AppointmentController::class, 'generateReport'])->middleware('role:admin,consultant')->name('appointments.generateReport');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->middleware('role:admin')->name('appointments.destroy');
    Route::post('/appointments/{appointment}/submit-report', [AppointmentController::class, 'submitReport'])->middleware('role:consultant')->name('appointments.submitReport');
    Route::post('/appointments/{appointment}/approve-report', [AppointmentController::class, 'approveReport'])->middleware('role:admin')->name('appointments.approveReport');

    // Consultation Reports (comprehensive user health records)
    Route::get('/consultation-reports', [\App\Http\Controllers\ConsultationReportController::class, 'index'])->middleware('role:admin,consultant')->name('consultation-reports.index');
    Route::get('/consultation-reports/my-report', [\App\Http\Controllers\ConsultationReportController::class, 'myReport'])->name('consultation-reports.my-report');
    Route::get('/consultation-reports/{user}', [\App\Http\Controllers\ConsultationReportController::class, 'show'])->name('consultation-reports.show');
    Route::get('/consultation-reports/{user}/export-pdf', [\App\Http\Controllers\ConsultationReportController::class, 'exportPdf'])->name('consultation-reports.export-pdf');
    Route::get('/consultation-reports/{user}/data', [\App\Http\Controllers\ConsultationReportController::class, 'getData'])->name('consultation-reports.data');

    // Consultations (users can submit and view their own; admin can view all)
    Route::post('/consultation', [ConsultationController::class, 'submit'])->name('consultation.submit');
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::delete('/consultations/{consultation}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');

    // Dr. C history, sessions, and reports
    Route::get('/dr-c/history', [DrCController::class, 'history'])->name('dr-c.history');
    Route::get('/dr-c/sessions', [DrCController::class, 'sessions'])->name('dr-c.sessions');
    Route::get('/dr-c/sessions/{session}', [DrCController::class, 'viewReport'])->name('dr-c.viewReport');
    Route::post('/dr-c/sessions/{session}/end', [DrCController::class, 'endSession'])->name('dr-c.endSession');
    Route::delete('/dr-c/sessions/{session}', [DrCController::class, 'deleteSession'])->name('dr-c.deleteSession');
    Route::delete('/dr-c/messages/{message}', [DrCController::class, 'deleteMessage'])->name('dr-c.deleteMessage');

    // Reviews (consumers can create and manage; consultants/admin can reply/moderate)
    Route::get('/products/{product}/review/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Comments (authenticated users can comment; owner/admin can edit/delete)
    Route::post('/reviews/{review}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Allow appointment creation for guests and authenticated users
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

// OAuth (Google)
Route::middleware('guest')->group(function () {
    Route::get('/auth/google/redirect', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])
        ->name('oauth.google.redirect');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callback']);
});

require __DIR__ . '/auth.php';
