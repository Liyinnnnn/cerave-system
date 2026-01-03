@extends('layouts.guest')
@php use Illuminate\Support\Str; @endphp

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40 dark:bg-slate-900 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-3 text-sm py-3 text-gray-800 dark:text-gray-200">
            <a href="{{ route('appointments.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">All Appointments</a>
            <span>&gt;</span>
            <span class="text-gray-500 dark:text-gray-400">Appointment #{{ $appointment->id }}</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Appointment Details Card -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4 dark:from-blue-800 dark:to-indigo-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-white mb-1">Appointment #{{ $appointment->id }}</h1>
                        <p class="text-sm text-blue-100">{{ $appointment->name }}</p>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                        @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($appointment->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-6">
                <!-- Schedule Info -->
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center dark:text-white">
                        <svg class="w-5 h-5 mr-2 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Schedule
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-start p-3 bg-blue-50 rounded-lg dark:bg-indigo-900 dark:bg-opacity-30 dark:border dark:border-indigo-700">
                            <svg class="w-4 h-4 mr-2 text-primary mt-0.5 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600 font-semibold dark:text-blue-300">Date</p>
                                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('l, F d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start p-3 bg-blue-50 rounded-lg dark:bg-indigo-900 dark:bg-opacity-30 dark:border dark:border-indigo-700">
                            <svg class="w-4 h-4 mr-2 text-primary mt-0.5 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600 font-semibold dark:text-blue-300">Time</p>
                                <p class="text-sm font-bold text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center dark:text-white">
                        <svg class="w-5 h-5 mr-2 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Contact Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg dark:border-slate-700">
                            <svg class="w-4 h-4 mr-2 text-gray-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-blue-300">Email</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $appointment->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg dark:border-slate-700">
                            <svg class="w-4 h-4 mr-2 text-gray-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-blue-300">Phone</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $appointment->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consultation Type -->
                <div>
                    <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center dark:text-white">
                        <svg class="w-5 h-5 mr-2 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Consultation Type
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <p class="px-3 py-2 bg-blue-100 text-blue-800 rounded-lg inline-block text-sm font-semibold dark:bg-blue-900 dark:text-blue-200">
                            {{ ucfirst($appointment->consultation_type) }} Consultation
                        </p>
                        @if($appointment->consultation_type === 'in-store' && $appointment->location)
                            <p class="px-3 py-2 bg-blue-100 text-blue-800 rounded-lg inline-block text-sm font-semibold dark:bg-blue-900 dark:text-blue-200">
                                Location: {{ $appointment->location }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Consultant Assignment (Admin & Consultant Only) -->
                @if(auth()->user()->isAdmin() || auth()->user()->isConsultant())
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200 p-4 dark:from-slate-800 dark:to-slate-700 dark:border-purple-600">
                        <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center dark:text-white">
                            <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM4.318 20H4a2 2 0 01-2-2v-2a6 6 0 0112 0v2a2 2 0 01-2 2h-.682"></path>
                            </svg>
                            Assigned Consultant
                        </h2>
                        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="flex flex-col md:flex-row gap-3 items-end">
                            @csrf
                            @method('PATCH')
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-700 mb-2 dark:text-blue-300">Select Consultant</label>
                                <select name="consultant_id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition bg-white dark:bg-slate-900 dark:border-slate-600 dark:text-white">
                                    <option value="">-- No Consultant Assigned --</option>
                                    @foreach($consultants as $consultant)
                                        <option value="{{ $consultant->id }}" @selected(old('consultant_id', $appointment->consultant_id) === $consultant->id)>
                                            {{ $consultant->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition font-semibold shadow">
                                Assign
                            </button>
                        </form>
                        @if($appointment->consultant)
                            <div class="mt-3 p-2 bg-purple-100 rounded border-l-2 border-purple-600 dark:bg-slate-900 dark:border-purple-400">
                                <p class="text-xs text-purple-700 dark:text-purple-300">
                                    <strong>Currently assigned to:</strong> {{ $appointment->consultant->name }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Skin Concerns -->
                @if($appointment->concerns)
                    <div>
                        <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center dark:text-white">
                            <svg class="w-5 h-5 mr-2 text-primary dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Skin Concerns
                        </h2>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 dark:bg-slate-800 dark:bg-opacity-50 dark:border-slate-700">
                            <p class="text-sm text-gray-700 leading-relaxed dark:text-blue-200">{{ $appointment->concerns }}</p>
                        </div>
                    </div>
                @endif

                <!-- Consultation Report Section -->
                @if(auth()->user()->isAdmin() || auth()->user()->isConsultant())
                    <div class="border-t border-gray-200 pt-4 dark:border-slate-700">
                        <!-- Generate Consultant Report Button -->
                        @if((auth()->user()->isConsultant() || auth()->user()->isAdmin()) && !$appointment->report_generated_at)
                            <div class="mb-6 bg-gradient-to-r from-green-50 to-teal-50 border border-green-200 rounded-lg p-4 dark:from-slate-800 dark:to-slate-700 dark:border-green-700">
                                <h2 class="text-lg font-bold text-green-900 mb-2 flex items-center dark:text-white">
                                    <svg class="w-6 h-6 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Generate Consultation Report
                                </h2>
                                <p class="text-sm text-gray-700 mb-4 dark:text-gray-300">Create a professional consultation report with skincare recommendations for this client.</p>
                                <button onclick="document.getElementById('reportFormModal').classList.remove('hidden')" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow-md flex items-center gap-2 dark:bg-green-700 dark:hover:bg-green-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Generate Report
                                </button>
                            </div>
                        @elseif($appointment->report_generated_at)
                            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 dark:from-slate-800 dark:to-slate-700 dark:border-blue-700">
                                <h2 class="text-lg font-bold text-blue-900 mb-2 flex items-center dark:text-white">
                                    <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Consultation Report Available
                                </h2>
                                <p class="text-sm text-gray-700 mb-3 dark:text-gray-300">
                                    Report generated {{ $appointment->report_generated_at->diffForHumans() }} by {{ $appointment->consultant->name ?? 'Consultant' }}
                                </p>
                                <a href="{{ route('appointments.report', $appointment) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-md dark:bg-blue-700 dark:hover:bg-blue-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View & Print Report
                                </a>
                            </div>
                        @endif

                        <!-- Report Status Badge -->
                        @if($appointment->report_status !== 'draft')
                            <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-3 dark:from-slate-800 dark:to-slate-700 dark:border-blue-700">
                                <div class="flex items-center gap-3 flex-wrap text-sm">
                                    <span class="px-3 py-1 rounded text-xs font-semibold
                                        @if($appointment->report_status === 'pending_approval') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($appointment->report_status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($appointment->report_status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $appointment->report_status)) }}
                                    </span>
                                    @if($appointment->report_submitted_at)
                                        <span class="text-xs text-gray-600 dark:text-gray-300">
                                            Submitted {{ $appointment->report_submitted_at->diffForHumans() }} by {{ $appointment->reportSubmitter->name ?? 'Unknown' }}
                                        </span>
                                    @endif
                                    @if($appointment->report_approved_at && $appointment->report_status === 'approved')
                                        <span class="text-xs text-gray-600 dark:text-gray-300">
                                            | Approved {{ $appointment->report_approved_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                                @if($appointment->admin_feedback)
                                    <div class="mt-2 p-2 bg-white rounded border-l-2 border-blue-500 dark:bg-slate-800 dark:border-blue-400">
                                        <p class="text-xs font-semibold text-gray-700 dark:text-blue-200">Admin Feedback:</p>
                                        <p class="text-xs text-gray-700 dark:text-gray-300">{{ $appointment->admin_feedback }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <h2 class="text-lg font-bold text-blue-900 mb-3 dark:text-white">Consultation Report</h2>

                        <form id="appointmentForm" method="POST" action="{{ route('appointments.update', $appointment) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" id="formAction" name="form_action" value="save">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Solution / Plan -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 dark:text-blue-200">Treatment Plan</label>
                                    <textarea name="solution" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-900 dark:border-slate-700 dark:text-white" placeholder="Describe treatment plan..." @if($appointment->report_status === 'approved') readonly @endif>{{ old('solution', $appointment->solution) }}</textarea>
                                </div>

                                <!-- AI Suggestion -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 dark:text-blue-200">AI Suggestion</label>
                                    <textarea name="ai_suggestion" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-blue-50 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-800 dark:border-slate-700 dark:text-white" placeholder="AI suggestions..." @if($appointment->report_status === 'approved') readonly @endif>{{ old('ai_suggestion', $appointment->ai_suggestion) }}</textarea>
                                </div>

                                <!-- Consultant Notes -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 dark:text-blue-200">Consultant Notes</label>
                                    <textarea name="consultant_notes" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-900 dark:border-slate-700 dark:text-white" placeholder="Add detailed notes..." @if($appointment->report_status === 'approved') readonly @endif>{{ old('consultant_notes', $appointment->consultant_notes) }}</textarea>
                                </div>

                                <!-- Suggested Products -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 dark:text-blue-200">Suggested Products</label>
                                    <select class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition bg-white mb-1 dark:bg-slate-900 dark:border-slate-700 dark:text-white" onchange="addProduct(this)" @if($appointment->report_status === 'approved') disabled @endif>
                                        <option value="">-- Select product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <textarea name="suggested_products" id="suggested_products" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-900 dark:border-slate-700 dark:text-white" placeholder="- Product 1&#10;- Product 2" @if($appointment->report_status === 'approved') readonly @endif>{{ old('suggested_products', $appointment->suggested_products) }}</textarea>
                                </div>

                                <!-- Usage Instructions -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 dark:text-blue-200">Usage Instructions</label>
                                    <div class="flex gap-1 mb-1">
                                        <button type="button" onclick="insertTemplate('morning')" class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-medium hover:bg-blue-200 transition dark:bg-blue-900 dark:text-blue-200" @if($appointment->report_status === 'approved') disabled @endif>Morning</button>
                                        <button type="button" onclick="insertTemplate('night')" class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-[10px] font-medium hover:bg-indigo-200 transition dark:bg-indigo-900 dark:text-indigo-200" @if($appointment->report_status === 'approved') disabled @endif>Night</button>
                                        <button type="button" onclick="insertTemplate('weekly')" class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-[10px] font-medium hover:bg-purple-200 transition dark:bg-purple-900 dark:text-purple-200" @if($appointment->report_status === 'approved') disabled @endif>Weekly</button>
                                    </div>
                                    <textarea name="usage_instructions" id="usage_instructions" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-900 dark:border-slate-700 dark:text-white" placeholder="Usage steps..." @if($appointment->report_status === 'approved') readonly @endif>{{ old('usage_instructions', $appointment->usage_instructions) }}</textarea>
                                </div>

                                <!-- Purchased Products -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1 dark:text-blue-200">Purchased Products</label>
                                    <div class="flex gap-2 mb-1">
                                        <select class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white" onchange="addPurchasedProduct(this)" @if($appointment->report_status === 'approved') disabled @endif>
                                            <option value="">-- Select purchased --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->name }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" id="product_quantity" min="1" value="1" class="w-16 px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-900 dark:border-slate-700 dark:text-white" @if($appointment->report_status === 'approved') disabled @endif>
                                    </div>
                                    <textarea name="purchased_products" id="purchased_products" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-slate-900 dark:border-slate-700 dark:text-white" placeholder="- Product (x1)&#10;- Product (x2)" @if($appointment->report_status === 'approved') readonly @endif>{{ old('purchased_products', $appointment->purchased_products) }}</textarea>
                                </div>
                            </div>

                            @if($appointment->report_status !== 'approved')
                                <div class="border-t border-gray-200 pt-4 dark:border-slate-700">
                                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2 dark:bg-blue-700 dark:hover:bg-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Save All Changes
                                    </button>
                                </div>
                            @endif
                        </form>

<script>
// Add product to suggested products list
function addProduct(select) {
    if (select.value) {
        const textarea = document.getElementById('suggested_products');
        const currentValue = textarea.value.trim();
        const newProduct = '- ' + select.value;
        
        if (currentValue) {
            textarea.value = currentValue + '\n' + newProduct;
        } else {
            textarea.value = newProduct;
        }
        
        select.selectedIndex = 0;
        textarea.focus();
    }
}

// Add purchased product with quantity
function addPurchasedProduct(select) {
    if (select.value) {
        const textarea = document.getElementById('purchased_products');
        const quantity = document.getElementById('product_quantity').value;
        const currentValue = textarea.value.trim();
        const newProduct = '- ' + select.value + ' (x' + quantity + ')';
        
        if (currentValue) {
            textarea.value = currentValue + '\n' + newProduct;
        } else {
            textarea.value = newProduct;
        }
        
        select.selectedIndex = 0;
        document.getElementById('product_quantity').value = 1;
        textarea.focus();
    }
}

// Insert routine templates
function insertTemplate(type) {
    const textarea = document.getElementById('usage_instructions');
    let template = '';
    
    switch(type) {
        case 'morning':
            template = `Morning Routine:
1. Cleanse with gentle cleanser
2. Apply toner (if recommended)
3. Apply serum or treatment
4. Moisturizer
5. Sunscreen (SPF 30+)`;
            break;
        case 'night':
            template = `Night Routine:
1. Remove makeup/cleanse
2. Double cleanse (if needed)
3. Apply toner
4. Apply treatment/serum
5. Eye cream
6. Night moisturizer/cream`;
            break;
        case 'weekly':
            template = `Weekly Care:
- Exfoliate 1-2x per week
- Face mask 1x per week
- Deep moisturizing treatment as needed`;
            break;
    }
    
    const currentValue = textarea.value.trim();
    if (currentValue) {
        textarea.value = currentValue + '\n\n' + template;
    } else {
        textarea.value = template;
    }
    textarea.focus();
}
</script>

                        <!-- Secondary Actions Section -->
                        <div class="border-t border-gray-200 pt-4 dark:border-slate-700">
                            <div class="flex gap-2 flex-wrap">
                                <!-- Submit Report (Consultants) -->
                                @if(auth()->user()->isConsultant() && $appointment->report_status === 'draft')
                                    <form method="POST" action="{{ route('appointments.submitReport', $appointment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 transition dark:bg-purple-700 dark:hover:bg-purple-800">
                                            Submit Report
                                        </button>
                                    </form>
                                @endif

                                <!-- Approve/Reject Report (Admins) -->
                                @if(auth()->user()->isAdmin() && $appointment->report_status === 'pending_approval')
                                    <form method="POST" action="{{ route('appointments.approveReport', $appointment) }}" class="inline" onsubmit="return confirm('Approve this report?');">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition dark:bg-green-700 dark:hover:bg-green-800">
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition dark:bg-red-700 dark:hover:bg-red-800">
                                        Reject
                                    </button>
                                @endif

                                <!-- Quick Status Buttons -->
                                @if($appointment->status === 'pending')
                                    <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition dark:bg-green-700 dark:hover:bg-green-800">
                                            Confirm Appointment
                                        </button>
                                    </form>
                                @endif

                                @if($appointment->status === 'confirmed')
                                    <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition dark:bg-blue-700 dark:hover:bg-blue-800">
                                            Mark Completed
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete (Admin Only) -->
                                @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" class="inline" onsubmit="return confirm('Delete this appointment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition dark:bg-red-700 dark:hover:bg-red-800">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Report Modal -->
@if(auth()->user()->isAdmin() && $appointment->report_status === 'pending_approval')
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full dark:bg-slate-900">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 dark:text-white">Reject Consultation Report</h3>
            <form method="POST" action="{{ route('appointments.approveReport', $appointment) }}">
                @csrf
                <input type="hidden" name="action" value="reject">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Feedback (Required)</label>
                    <textarea name="admin_feedback" rows="4" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-800 dark:border-slate-700 dark:text-white" placeholder="Explain why this report is being rejected..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">Reject Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Generate Consultant Report Modal -->
@if((auth()->user()->isConsultant() || auth()->user()->isAdmin()) && !$appointment->report_generated_at)
<div id="reportFormModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full my-8 dark:bg-slate-900">
        <form method="POST" action="{{ route('appointments.generateReport', $appointment) }}">
            @csrf
            <div class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Generate Consultation Report</h3>
                    <button type="button" onclick="document.getElementById('reportFormModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Skin Assessment -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">
                            <span class="text-red-600">*</span> Skin Assessment
                        </label>
                        <textarea name="skin_assessment" rows="4" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none dark:bg-slate-800 dark:border-slate-700 dark:text-white" placeholder="Describe the client's skin condition, concerns observed, and overall assessment...">{{ old('skin_assessment') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Be detailed and professional. This will appear in the report.</p>
                    </div>

                    <!-- Recommended Products -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">
                            <span class="text-red-600">*</span> Recommended Products
                        </label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-3 border border-gray-200 rounded-lg dark:border-slate-700">
                            @foreach($products as $product)
                                <label class="flex items-start gap-3 p-2 hover:bg-blue-50 rounded cursor-pointer dark:hover:bg-slate-800">
                                    <input type="checkbox" name="recommended_products[]" value="{{ $product->id }}" class="mt-1 w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->category }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Select all products you recommend for this client.</p>
                    </div>

                    <!-- Skincare Advice -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">
                            <span class="text-red-600">*</span> Skincare Recommendations
                        </label>
                        <textarea name="skincare_advice" rows="5" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none dark:bg-slate-800 dark:border-slate-700 dark:text-white" placeholder="Provide detailed skincare routine recommendations, application instructions, and professional advice...">{{ old('skincare_advice') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Include morning/night routines, frequency, and specific instructions.</p>
                    </div>

                    <!-- Lifestyle Tips -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">
                            Lifestyle & Wellness Tips (Optional)
                        </label>
                        <textarea name="lifestyle_tips" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none dark:bg-slate-800 dark:border-slate-700 dark:text-white" placeholder="Add lifestyle recommendations (diet, hydration, sleep, sun protection, etc.)">{{ old('lifestyle_tips') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex gap-3 dark:bg-slate-800 dark:border-slate-700">
                <button type="button" onclick="document.getElementById('reportFormModal').classList.add('hidden')" class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold dark:bg-slate-700 dark:text-white dark:hover:bg-slate-600">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow-md flex items-center justify-center gap-2 dark:bg-green-700 dark:hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
