<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CeraVe Skincare Consultation Report - {{ $appointment->user->name }}</title>
    <style>
        @media print {
            .no-print { display: none !important; }
            @page { margin: 2cm; size: A4; }
            body { background: white !important; }
            .container { box-shadow: none !important; margin: 0 !important; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            line-height: 1.8;
            color: #1a1a1a;
            background: #f8f9fa;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 14px 28px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(30,64,175,0.3);
            z-index: 1000;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.3s;
        }
        .print-button:hover { 
            background: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30,64,175,0.4);
        }
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 14px 28px;
            background: #475569;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.3s;
        }
        .back-button:hover { 
            background: #334155;
            transform: translateY(-2px);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
            color: white;
            padding: 50px 60px;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }
        .logo { 
            font-size: 32px; 
            font-weight: 700; 
            margin-bottom: 12px;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }
        .subtitle { 
            font-size: 18px; 
            opacity: 0.95;
            font-weight: 300;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }
        .report-meta {
            background: #f8fafc;
            padding: 20px 60px;
            border-bottom: 1px solid #e2e8f0;
            font-family: 'Segoe UI', sans-serif;
            font-size: 13px;
            color: #64748b;
        }
        .report-meta strong { color: #334155; }
        .content { padding: 50px 60px; }
        .section { 
            margin-bottom: 45px; 
            page-break-inside: avoid;
            border-left: 4px solid #e0e7ff;
            padding-left: 30px;
        }
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 25px;
            font-family: 'Georgia', serif;
            position: relative;
            padding-bottom: 12px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #3b82f6;
        }
        .info-list {
            background: #f8fafc;
            border-left: 3px solid #3b82f6;
            padding: 20px 25px;
            border-radius: 0 6px 6px 0;
            font-family: 'Segoe UI', sans-serif;
            line-height: 1.9;
        }
        .info-list-item {
            display: flex;
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-list-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #475569;
            font-size: 13px;
            min-width: 180px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            color: #0f172a;
            font-size: 14px;
            font-weight: 500;
            flex: 1;
        }
        .assessment-box {
            background: #fefce8;
            border-left: 4px solid #eab308;
            padding: 25px;
            border-radius: 0 6px 6px 0;
            line-height: 1.9;
            font-size: 15px;
            color: #422006;
        }
        .recommendations-box {
            background: #f0f9ff;
            border-left: 4px solid #0284c7;
            padding: 25px;
            border-radius: 0 6px 6px 0;
            line-height: 1.9;
            font-size: 15px;
            color: #0c4a6e;
            white-space: pre-wrap;
        }
        .products-section {
            margin-top: 30px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        .product-card {
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
            page-break-inside: avoid;
        }
        .product-card:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59,130,246,0.15);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f8fafc;
        }
        .product-info {
            padding: 20px;
        }
        .product-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 8px;
            font-family: 'Segoe UI', sans-serif;
            line-height: 1.4;
        }
        .product-category {
            font-size: 12px;
            color: #64748b;
            font-family: 'Segoe UI', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .footer {
            background: #f8fafc;
            padding: 40px 60px;
            border-top: 3px solid #e2e8f0;
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
            color: #64748b;
            font-size: 13px;
            line-height: 1.8;
        }
        .footer-logo {
            font-size: 20px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <a href="{{ route('appointments.show', $appointment) }}" class="back-button no-print">← Back to Appointment</a>
    <button onclick="window.print()" class="print-button no-print">🖨 Print Report</button>
    
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">CeraVe Skincare</div>
            <div class="subtitle">Consultation Report</div>
        </div>

        <!-- Report Meta -->
        <div class="report-meta">
            <strong>Report ID:</strong> APP-{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }} &nbsp;|&nbsp; 
            <strong>Generated:</strong> {{ $appointment->report_generated_at->format('F d, Y \a\t g:i A') }}
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Consultation Information -->
            <div class="section">
                <h2 class="section-title">Consultation Information</h2>
                <div class="info-list">
                    <div class="info-list-item">
                        <div class="info-label">Name</div>
                        <div class="info-value">{{ $appointment->user->name }}</div>
                    </div>
                    <div class="info-list-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $appointment->user->email }}</div>
                    </div>
                    <div class="info-list-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $appointment->phone }}</div>
                    </div>
                    <div class="info-list-item">
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="info-list-item">
                        <div class="info-label">Consultant</div>
                        <div class="info-value">{{ $appointment->consultant->name ?? 'CeraVe Skincare Consultant' }}</div>
                    </div>
                    <div class="info-list-item">
                        <div class="info-label">Consultation Type</div>
                        <div class="info-value">{{ ucfirst($appointment->consultation_type) }}</div>
                    </div>
                </div>
            </div>

            <!-- Skin Assessment -->
            <div class="section">
                <h2 class="section-title">Skin Assessment</h2>
                <div class="assessment-box">
                    {{ $appointment->skin_assessment }}
                </div>
            </div>

            <!-- Primary Concerns -->
            @if($appointment->concerns)
            <div class="section">
                <h2 class="section-title">Primary Skin Concerns</h2>
                <div class="assessment-box">
                    {{ $appointment->concerns }}
                </div>
            </div>
            @endif

            <!-- Recommended Products -->
            @if($recommendedProducts->count() > 0)
            <div class="section products-section">
                <h2 class="section-title">Recommended CeraVe Products</h2>
                <p style="margin-bottom: 20px; color: #64748b; font-family: 'Segoe UI', sans-serif; font-size: 14px;">
                    The following products have been carefully selected based on your skin assessment and specific needs. Each product contains proven ingredients formulated to address your concerns effectively.
                </p>
                <div class="products-grid">
                    @foreach($recommendedProducts as $product)
                        <div class="product-card">
                            @php
                                $imageUrl = $product->image_url ?? ($product->images[0] ?? asset('images/product-placeholder.png'));
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-image" onerror="this.src='{{ asset('images/product-placeholder.png') }}'">
                            <div class="product-info">
                                <div class="product-category">{{ $product->category }}</div>
                                <div class="product-name">{{ $product->name }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Skincare Recommendations -->
            <div class="section">
                <h2 class="section-title">Skincare Recommendations</h2>
                <div class="recommendations-box">{{ $appointment->skincare_advice }}</div>
            </div>

            <!-- Lifestyle Tips -->
            @if($appointment->lifestyle_tips)
            <div class="section">
                <h2 class="section-title">Lifestyle & Wellness Tips</h2>
                <div class="recommendations-box">{{ $appointment->lifestyle_tips }}</div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">CeraVe Skincare System</div>
            <p>
                This consultation report provides personalized skincare recommendations based on your specific needs and concerns.
                For best results, follow the recommended routine consistently and reach out if you have any questions.
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: #94a3b8;">
                <strong>Note:</strong> This report is for skincare guidance purposes. If you have medical skin conditions, please consult a dermatologist.
            </p>
        </div>
    </div>

    <script>
        // Auto-focus on load for better print preview
        document.addEventListener('DOMContentLoaded', function() {
            document.body.focus();
        });
    </script>
</body>
</html>
