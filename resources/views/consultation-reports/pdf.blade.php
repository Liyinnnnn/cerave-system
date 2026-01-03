<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Report - {{ $user->name }}</title>
    <style>
        @media print {
            .no-print { display: none !important; }
            @page { margin: 1.5cm; }
            body { background: white !important; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .print-button:hover { background: #1d4ed8; }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .logo { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
        .subtitle { font-size: 16px; opacity: 0.9; }
        .content { padding: 40px; }
        .section { margin-bottom: 35px; page-break-inside: avoid; }
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e40af;
            border-bottom: 3px solid #dbeafe;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 15px;
            background: #f9fafb;
            border-left: 4px solid #3b82f6;
            border-radius: 4px;
        }
        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .info-value {
            color: #111827;
            font-size: 16px;
            font-weight: 500;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 30px;
        }
        .stat-card {
            text-align: center;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
        }
        .appointment-item {
            margin-bottom: 20px;
            padding: 20px;
            background: #f9fafb;
            border-left: 4px solid #3b82f6;
            border-radius: 4px;
            page-break-inside: avoid;
        }
        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        .appointment-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .detail-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 15px 0;
        }
        .detail-item {
            padding: 10px;
            background: white;
            border-radius: 4px;
        }
        .detail-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .detail-value {
            font-size: 14px;
            color: #111827;
            font-weight: 500;
        }
        .concerns-box {
            background: white;
            padding: 15px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .report-box {
            background: #eff6ff;
            padding: 15px;
            border-radius: 4px;
            margin-top: 10px;
            border-left: 4px solid #3b82f6;
        }
        .tag {
            display: inline-block;
            padding: 6px 12px;
            margin: 4px;
            background: #dbeafe;
            color: #1e40af;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }
        .tag-orange { background: #fed7aa; color: #9a3412; }
        .tag-red { background: #fecaca; color: #991b1b; }
        .tag-green { background: #bbf7d0; color: #166534; }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">🖨️ Print Report</button>

    <div class="container">
        <div class="header">
            <div class="logo">CeraVe Skincare System</div>
            <div class="subtitle">Comprehensive Consultation Report</div>
        </div>

        <div class="content">
            <!-- User Profile Section -->
            <div class="section">
                <h2 class="section-title">👤 User Profile</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                    @if($user->birthday)
                        <div class="info-item">
                            <div class="info-label">Birthday</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($user->birthday)->format('M d, Y') }}</div>
                        </div>
                    @endif
                    @if($user->gender)
                        <div class="info-item">
                            <div class="info-label">Gender</div>
                            <div class="info-value">{{ $user->gender }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Overview -->
            <div class="section">
                <h2 class="section-title">📊 Statistics Overview</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ $stats['total_appointments'] }}</div>
                        <div class="stat-label">Total Appointments</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $stats['completed_appointments'] }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $stats['total_dr_c_sessions'] }}</div>
                        <div class="stat-label">Dr. C Sessions</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $stats['total_consultations'] }}</div>
                        <div class="stat-label">Consultations</div>
                    </div>
                </div>
            </div>

            <!-- Skin Profile -->
            <div class="section">
                <h2 class="section-title">🧴 Skin Profile</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Skin Type</div>
                        <div class="info-value">{{ $skinProfile['skin_type'] ? ucfirst($skinProfile['skin_type']) : 'Not specified' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Profile Last Updated</div>
                        <div class="info-value">{{ $skinProfile['profile_updated_at'] ? $skinProfile['profile_updated_at']->format('M d, Y') : 'Never' }}</div>
                    </div>
                </div>

                @if(!empty($skinProfile['skin_concerns']))
                    <div style="margin-top: 20px;">
                        <div class="info-label" style="margin-bottom: 10px;">Skin Concerns</div>
                        <div>
                            @foreach($skinProfile['skin_concerns'] as $concern)
                                @if($concern)
                                    <span class="tag tag-orange">{{ ucfirst(trim($concern)) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(!empty($skinProfile['skin_conditions']))
                    <div style="margin-top: 20px;">
                        <div class="info-label" style="margin-bottom: 10px;">Skin Conditions</div>
                        <div>
                            @foreach($skinProfile['skin_conditions'] as $condition)
                                @if($condition)
                                    <span class="tag tag-red">{{ ucfirst(trim($condition)) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(!empty($skinProfile['using_products']))
                    <div style="margin-top: 20px;">
                        <div class="info-label" style="margin-bottom: 10px;">Currently Using Products</div>
                        <div>
                            @foreach($skinProfile['using_products'] as $product)
                                @if($product)
                                    <span class="tag tag-green">{{ $product }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Appointments History -->
            @if($appointments->count() > 0)
                <div class="section">
                    <h2 class="section-title">📅 Appointment History ({{ $appointments->count() }})</h2>
                    @foreach($appointments as $appointment)
                        <div class="appointment-item">
                            <div class="appointment-header">
                                <div>
                                    <div class="appointment-title">{{ $appointment->name }}</div>
                                    <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                                        {{ $appointment->email }} • {{ $appointment->phone }}
                                    </div>
                                </div>
                                <span class="status-badge status-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>

                            <div class="detail-row">
                                <div class="detail-item">
                                    <div class="detail-label">Date & Time</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }} at {{ $appointment->preferred_time }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Type</div>
                                    <div class="detail-value">{{ ucfirst($appointment->consultation_type) }}</div>
                                </div>
                                @if($appointment->location)
                                    <div class="detail-item">
                                        <div class="detail-label">Location</div>
                                        <div class="detail-value">{{ $appointment->location }}</div>
                                    </div>
                                @endif
                            </div>

                            @if($appointment->concerns)
                                <div class="concerns-box">
                                    <div class="detail-label" style="margin-bottom: 8px;">Concerns</div>
                                    <div style="font-size: 14px; color: #374151;">{{ $appointment->concerns }}</div>
                                </div>
                            @endif

                            @if($appointment->consultant_report)
                                <div class="report-box">
                                    <div class="detail-label" style="margin-bottom: 8px; color: #1e40af;">Consultant Report</div>
                                    <div style="font-size: 14px; color: #374151;">{{ $appointment->consultant_report }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Dr. C AI Sessions -->
            @if($drCSessions->count() > 0)
                <div class="section">
                    <h2 class="section-title">🤖 Dr. C AI Sessions ({{ $drCSessions->count() }})</h2>
                    @foreach($drCSessions as $session)
                        <div class="appointment-item">
                            <div class="appointment-title">Session #{{ $session->id }}</div>
                            <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                                {{ $session->created_at->format('M d, Y g:i A') }} • {{ $session->messages->count() }} messages
                            </div>

                            @if($session->messages->count() > 0)
                                <div class="concerns-box" style="margin-top: 15px;">
                                    <div class="detail-label" style="margin-bottom: 8px;">First Message</div>
                                    <div style="font-size: 14px; color: #374151;">{{ $session->messages->first()->message }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Consultation Records -->
            @if($consultations->count() > 0)
                <div class="section">
                    <h2 class="section-title">💬 Consultation Records ({{ $consultations->count() }})</h2>
                    @foreach($consultations as $consultation)
                        <div class="appointment-item">
                            <div style="font-size: 13px; color: #6b7280; margin-bottom: 12px;">
                                {{ $consultation->created_at->format('M d, Y g:i A') }}
                            </div>

                            @if($consultation->concerns)
                                <div class="concerns-box">
                                    <div class="detail-label" style="margin-bottom: 8px;">Concerns</div>
                                    <div style="font-size: 14px; color: #374151;">{{ $consultation->concerns }}</div>
                                </div>
                            @endif

                            @if($consultation->response)
                                <div class="report-box" style="margin-top: 10px;">
                                    <div class="detail-label" style="margin-bottom: 8px; color: #1e40af;">Response</div>
                                    <div style="font-size: 14px; color: #374151;">{{ $consultation->response }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="footer">
                <p><strong>CeraVe Skincare System</strong></p>
                <p>Consultation Report Generated on {{ now()->format('F d, Y') }}</p>
                <p style="margin-top: 8px; font-size: 11px;">This is a confidential medical document</p>
            </div>
        </div>
    </div>
</body>
</html>
