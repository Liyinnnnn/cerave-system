<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Report - {{ $appointment->name }}</title>
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
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .print-button:hover { background: #1d4ed8; }
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 12px 24px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
        }
        .back-button:hover { background: #4b5563; }
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
        .details-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            line-height: 1.8;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }
        .product-card {
            border: 1px solid #e5e7eb;
            padding: 16px;
            border-radius: 8px;
            background: #fff;
            transition: all 0.2s;
        }
        .product-card:hover { box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .product-name {
            font-weight: 600;
            margin-bottom: 6px;
            color: #111827;
            font-size: 15px;
        }
        .product-category {
            font-size: 12px;
            color: #6b7280;
            background: #f3f4f6;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        .routine-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }
        .routine-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .routine-list {
            margin: 12px 0;
            padding-left: 24px;
        }
        .routine-list li {
            margin-bottom: 8px;
            color: #374151;
        }
        .note-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .note-box ul {
            margin: 10px 0;
            padding-left: 24px;
        }
        .note-box li {
            margin-bottom: 8px;
            color: #92400e;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            border-top: 2px solid #e5e7eb;
        }
        .footer strong { color: #374151; }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-pending { background: #fef3c7; color: #92400e; }
        @media screen {
            .container { margin: 20px auto; box-shadow: 0 0 40px rgba(0,0,0,0.1); }
        }
    </style>
</head>
<body>
    <a href="{{ route('appointments.show', $appointment) }}" class="back-button no-print">← Back to Appointment</a>
    <button onclick="window.print()" class="print-button no-print">🖨️ Print Report</button>
    
    <div class="container">
        <div class="header">
            <div class="logo">CeraVe Skincare Consultation</div>
            <div class="subtitle">Professional Consultation Report</div>
        </div>

        <div class="content">
            <!-- Patient Information -->
            <div class="section">
                <div class="section-title">Patient Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Patient Name</div>
                        <div class="info-value">{{ $appointment->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $appointment->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $appointment->phone }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Report Date</div>
                        <div class="info-value">{{ now()->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Consultation Details -->
            <div class="section">
                <div class="section-title">Consultation Details</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Appointment Date</div>
                        <div class="info-value">{{ $appointment->preferred_date ? $appointment->preferred_date->format('F d, Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Appointment Time</div>
                        <div class="info-value">{{ $appointment->preferred_time ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Consultant</div>
                        <div class="info-value">{{ $consultantName }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Consultation Method</div>
                        <div class="info-value">{{ $consultationMethod }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Appointment ID</div>
                        <div class="info-value">#{{ $appointment->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skin Assessment -->
            @if($appointment->concerns || $appointment->solution)
            <div class="section">
                <div class="section-title">Skin Assessment</div>
                @if($appointment->concerns)
                <div style="margin-bottom: 20px;">
                    <h3 style="font-weight: 600; color: #374151; margin-bottom: 10px;">Primary Concerns:</h3>
                    <div class="details-box">{{ $appointment->concerns }}</div>
                </div>
                @endif
                
                @if($appointment->solution)
                <div style="margin-bottom: 20px;">
                    <h3 style="font-weight: 600; color: #374151; margin-bottom: 10px;">Diagnosed Skin Condition:</h3>
                    <div class="details-box">{{ $appointment->solution }}</div>
                </div>
                @endif
            </div>
            @endif

            <!-- AI Suggestions -->
            @if($appointment->ai_suggestion)
            <div class="section">
                <div class="section-title">AI-Powered Initial Assessment</div>
                <div class="details-box">{{ $appointment->ai_suggestion }}</div>
            </div>
            @endif

            <!-- Consultant Notes & Recommendations -->
            @if($appointment->consultant_notes)
            <div class="section">
                <div class="section-title">Professional Assessment & Recommendations</div>
                <div class="details-box">{!! nl2br(e($appointment->consultant_notes)) !!}</div>
            </div>
            @endif

            <!-- Usage Instructions -->
            @if($appointment->usage_instructions)
            <div class="section">
                <div class="section-title">Product Usage Instructions</div>
                <div class="details-box">{!! nl2br(e($appointment->usage_instructions)) !!}</div>
            </div>
            @endif

            <!-- Product Recommendations -->
            @if($recommendedProducts->count() > 0)
            <div class="section">
                <div class="section-title">Recommended CeraVe Products</div>
                <div class="products-grid">
                    @foreach($recommendedProducts as $product)
                        <div class="product-card">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-category">{{ $product->category }}</div>
                            @if($product->key_benefits)
                            <p style="font-size: 12px; color: #6b7280; margin-top: 8px; line-height: 1.4;">
                                {{ Str::limit($product->key_benefits, 80) }}
                            </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Skincare Routine -->
            <div class="section">
                <div class="section-title">Recommended Skincare Routine</div>
                <div class="routine-box">
                    <div class="routine-title">☀️ Morning Routine</div>
                    <ol class="routine-list">
                        <li><strong>Cleanser:</strong> Gentle foaming or hydrating cleanser</li>
                        <li><strong>Toner:</strong> Balancing toner (if needed for your skin type)</li>
                        <li><strong>Serum:</strong> Vitamin C or targeted treatment serum</li>
                        <li><strong>Eye Cream:</strong> Hydrating eye treatment</li>
                        <li><strong>Moisturizer:</strong> Lightweight day cream with ceramides</li>
                        <li><strong>Sunscreen:</strong> Broad-spectrum SPF 30+ (ESSENTIAL)</li>
                    </ol>

                    <div class="routine-title" style="margin-top: 25px;">🌙 Evening Routine</div>
                    <ol class="routine-list">
                        <li><strong>Makeup Remover:</strong> Oil-based or micellar water</li>
                        <li><strong>Cleanser:</strong> Gentle foaming cleanser (double cleanse)</li>
                        <li><strong>Toner:</strong> Hydrating or exfoliating toner</li>
                        <li><strong>Treatment:</strong> Retinol, AHA/BHA, or targeted serum</li>
                        <li><strong>Eye Cream:</strong> Nourishing night eye cream</li>
                        <li><strong>Moisturizer:</strong> Rich night cream or sleeping mask</li>
                    </ol>

                    <div class="note-box">
                        <strong style="color: #92400e; font-size: 14px;">⚠️ Important Skincare Guidelines:</strong>
                        <ul>
                            <li>Apply products from thinnest to thickest consistency</li>
                            <li>Wait 1-2 minutes between layers for better absorption</li>
                            <li>Consistency is key - follow routine daily for 4-6 weeks</li>
                            <li>Always patch test new products before full application</li>
                            <li>Introduce new active ingredients gradually (one at a time)</li>
                            <li>Never skip sunscreen, even on cloudy days</li>
                            <li>Stay hydrated - drink at least 8 glasses of water daily</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Lifestyle & Wellness Tips -->
            <div class="section">
                <div class="section-title">Lifestyle & Wellness Tips</div>
                <div style="background: #f0f9ff; padding: 20px; border-radius: 8px; border-left: 4px solid #0ea5e9;">
                    <ul style="padding-left: 24px; line-height: 2;">
                        <li><strong>Hydration:</strong> Drink 8-10 glasses of water daily</li>
                        <li><strong>Sleep:</strong> Aim for 7-9 hours of quality sleep</li>
                        <li><strong>Diet:</strong> Include omega-3s, vitamins A, C, E for skin health</li>
                        <li><strong>Stress Management:</strong> Practice meditation or yoga</li>
                        <li><strong>Exercise:</strong> Regular physical activity improves circulation</li>
                        <li><strong>Avoid:</strong> Smoking, excessive alcohol, touching face frequently</li>
                    </ul>
                </div>
            </div>

            <!-- Follow-up Information -->
            @if($appointment->location && $appointment->consultation_type === 'in-store')
            <div class="section">
                <div class="section-title">Consultation Location</div>
                <div class="details-box">{{ $appointment->location }}</div>
            </div>
            @endif
        </div>

        <div class="footer">
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>CeraVe Skincare System</strong></p>
            <p style="margin-bottom: 8px;">This consultation report is for informational and educational purposes only.</p>
            <p style="margin-bottom: 8px;">It does not constitute professional medical advice, diagnosis, or treatment.</p>
            <p style="margin-bottom: 15px;">For severe or persistent skin conditions, please consult a licensed dermatologist.</p>
            <p style="color: #9ca3af;">Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
            <p style="color: #9ca3af; margin-top: 5px;">Appointment ID: #{{ $appointment->id }}</p>
        </div>
    </div>
</body>
</html>
