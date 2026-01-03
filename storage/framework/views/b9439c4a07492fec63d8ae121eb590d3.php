<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CeraVe Skincare Consultation Report - <?php echo e($session->user->name ?? 'Guest'); ?></title>
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
            min-width: 220px;
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: #cbd5e1;
        }
        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
        }
        .product-image-placeholder {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 48px;
            border-bottom: 1px solid #cbd5e1;
        }
        .product-info {
            padding: 20px;
        }
        .product-name {
            font-weight: 700;
            margin-bottom: 10px;
            color: #0f172a;
            font-size: 16px;
            line-height: 1.4;
            font-family: 'Segoe UI', sans-serif;
        }
        .product-category {
            font-size: 12px;
            color: #64748b;
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .product-description {
            font-size: 13px;
            color: #475569;
            line-height: 1.6;
            margin-top: 10px;
        }
        .routine-box {
            background: #f8fafc;
            border-radius: 8px;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        .routine-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Georgia', serif;
        }
        .routine-list {
            margin: 15px 0;
            padding-left: 28px;
            font-family: 'Segoe UI', sans-serif;
        }
        .routine-list li {
            margin-bottom: 12px;
            color: #334155;
            line-height: 1.7;
        }
        .routine-list strong {
            color: #1e40af;
            font-weight: 600;
        }
        .important-notice {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 25px;
            border-radius: 0 6px 6px 0;
            margin-top: 25px;
        }
        .important-notice h4 {
            color: #92400e;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .important-notice ul {
            margin: 10px 0;
            padding-left: 24px;
        }
        .important-notice li {
            margin-bottom: 10px;
            color: #78350f;
            line-height: 1.7;
        }
        .wellness-box {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-left: 4px solid #10b981;
            padding: 25px;
            border-radius: 0 6px 6px 0;
        }
        .wellness-box ul {
            padding-left: 24px;
            line-height: 2;
        }
        .wellness-box li {
            color: #065f46;
            margin-bottom: 10px;
        }
        .wellness-box strong {
            color: #047857;
        }
        .footer {
            background: #f8fafc;
            padding: 40px 60px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            border-top: 3px solid #e2e8f0;
            font-family: 'Segoe UI', sans-serif;
        }
        .footer strong { 
            color: #334155; 
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }
        .footer .divider {
            margin: 15px auto;
            width: 60px;
            height: 2px;
            background: #cbd5e1;
        }
        @media screen {
            .container { 
                margin: 30px auto; 
                box-shadow: 0 0 50px rgba(0,0,0,0.08);
                border-radius: 12px;
                overflow: hidden;
            }
        }
        @media print {
            .product-card { break-inside: avoid; }
        }
    </style>
</head>
<body>
    <a href="<?php echo e(route('dr-c.chat')); ?>" class="back-button no-print">← Back to Dr. C</a>
    <button onclick="window.print()" class="print-button no-print">🖨️ Print Report</button>
    
    <div class="container">
        <div class="header">
            <div class="logo">CeraVe Skincare</div>
            <div class="subtitle">Consultation Report</div>
        </div>

        <div class="report-meta">
            <strong>Report ID:</strong> <?php echo e($session->session_token); ?> &nbsp;|&nbsp; 
            <strong>Generated:</strong> <?php echo e(now()->format('F d, Y \a\t h:i A')); ?>

        </div>

        <div class="content">
            <!-- Patient Information -->
            <div Consultation Information -->
            <div class="section">
                <div class="section-title">Consultation Information</div>
                <div class="info-list">
                    <div class="info-list-item">
                        <span class="info-label">Name</span>
                        <span class="info-value"><?php echo e($session->user->name ?? 'Guest'); ?></span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Consultation Date</span>
                        <span class="info-value"><?php echo e($session->created_at->format('F d, Y')); ?></span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Consultation Time</span>
                        <span class="info-value"><?php echo e($session->created_at->format('h:i A')); ?></span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Consultant</span>
                        <span class="info-value">Dr. C - AI Skincare Advisor</span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Consultation Method</span>
                        <span class="info-value">Digital Health Platform (Chat-Based)</span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Session Status</span>
                        <span class="info-value" style="text-transform: capitalize;"><?php echo e($session->status); ?></span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Total Messages Exchanged</span>
                        <span class="info-value"><?php echo e($session->message_count); ?> messages</span>
                    </div>
                    <div class="info-list-item">
                        <span class="info-label">Session Duration</span>
                        <span class="info-value">
                            <?php if($session->updated_at && $session->created_at): ?>
                                <?php echo e($session->created_at->diffForHumans($session->updated_at, true)); ?>

                            <?php else: ?>
                                Ongoing
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Skin Assessment -->
            <div class="section">
                <div class="section-title">Skin Assessment</div>
                <?php if($session->concerns): ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 12px; font-size: 16px; font-family: 'Segoe UI', sans-serif;">Primary Skin Concerns:</h3>
                    <div class="assessment-box"><?php echo e($session->concerns); ?></div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Skincare Recommendations -->
            <?php if($session->report): ?>
            <div class="section">
                <div class="section-title">Skincare Recommendations</div>
                <div class="recommendations-box"><?php echo nl2br(e($session->report)); ?></div>
            </div>
            <?php endif; ?>

            <!-- Product Recommendations -->
            <?php if($recommendedProducts && $recommendedProducts->count() > 0): ?>
            <div class="section">
                <div class="section-title">Recommended CeraVe Products</div>
                <p style="color: #475569; margin-bottom: 25px; font-family: 'Segoe UI', sans-serif; font-size: 14px; line-height: 1.7;">
                    The following CeraVe products have been specifically selected based on your skin assessment. 
                    These products contain proven ingredients formulated to address your specific skin concerns.
                </p>
                <div class="products-grid">
                    <?php $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-card">
                            <?php if($product->image_url): ?>
                                <img src="<?php echo e(asset($product->image_url)); ?>" alt="<?php echo e($product->name); ?>" class="product-image" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="product-image-placeholder" style="display: none;">📦</div>
                            <?php elseif($product->images && is_array($product->images) && count($product->images) > 0): ?>
                                <img src="<?php echo e(asset($product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="product-image" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="product-image-placeholder" style="display: none;">📦</div>
                            <?php else: ?>
                                <div class="product-image-placeholder">📦</div>
                            <?php endif; ?>
                            <div class="product-info">
                                <div class="product-category"><?php echo e($product->category ?? 'Skincare'); ?></div>
                                <div class="product-name"><?php echo e($product->name); ?></div>
                                <?php if($product->key_benefits): ?>
                                    <div class="product-description"><?php echo e(Str::limit($product->key_benefits, 120)); ?></div>
                                <?php elseif($product->benefits): ?>
                                    <div class="product-description"><?php echo e(Str::limit($product->benefits, 120)); ?></div>
                                <?php elseif($product->description): ?>
                                    <div class="product-description"><?php echo e(Str::limit($product->description, 120)); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Recommended Skincare Routine -->
            <div class="section">
                <div class="section-title">Recommended Skincare Routine</div>
                <div class="routine-box">
                    <div class="routine-title">☀️ Morning Regimen (AM)</div>
                    <ol class="routine-list">
                        <li><strong>Cleanse:</strong> Use a gentle, non-foaming hydrating cleanser with lukewarm water</li>
                        <li><strong>Tone:</strong> Apply pH-balancing toner if prescribed (for specific skin types only)</li>
                        <li><strong>Treat:</strong> Apply Vitamin C serum or targeted treatment as prescribed</li>
                        <li><strong>Hydrate Eyes:</strong> Gently pat eye cream around orbital area</li>
                        <li><strong>Moisturize:</strong> Apply ceramide-enriched lightweight moisturizer</li>
                        <li><strong>Protect:</strong> <strong style="color: #dc2626;">MANDATORY</strong> - Broad-spectrum SPF 30+ sunscreen (reapply every 2 hours)</li>
                    </ol>

                    <div class="routine-title" style="margin-top: 35px;">🌙 Evening Regimen (PM)</div>
                    <ol class="routine-list">
                        <li><strong>Pre-Cleanse:</strong> Remove makeup/sunscreen with oil-based cleanser or micellar water</li>
                        <li><strong>Deep Cleanse:</strong> Follow with gentle foaming cleanser (double cleanse method)</li>
                        <li><strong>Exfoliate/Tone:</strong> Apply chemical exfoliant (AHA/BHA) or hydrating toner as prescribed</li>
                        <li><strong>Treatment:</strong> Apply prescribed active ingredients (Retinol, Niacinamide, etc.)</li>
                        <li><strong>Eye Care:</strong> Apply nourishing eye cream with gentle tapping motions</li>
                        <li><strong>Night Moisturizer:</strong> Apply rich, barrier-repairing night cream or sleeping mask</li>
                    </ol>

                    <div class="important-notice">
                        <h4>⚠️ Critical Treatment Guidelines</h4>
                        <ul>
                            <li><strong>Product Layering:</strong> Apply products from thinnest to thickest consistency</li>
                            <li><strong>Absorption Time:</strong> Wait 60-90 seconds between each layer for optimal penetration</li>
                            <li><strong>Consistency:</strong> Strict adherence to routine required - visible results in 4-6 weeks minimum</li>
                            <li><strong>Patch Testing:</strong> MANDATORY 24-48 hour patch test for all new products</li>
                            <li><strong>Active Ingredients:</strong> Introduce ONE new active ingredient at a time (7-14 day intervals)</li>
                            <li><strong>Sun Protection:</strong> Non-negotiable daily application, even indoors/cloudy weather</li>
                            <li><strong>Hydration:</strong> Minimum 8-10 glasses (2-2.5L) water daily</li>
                            <li><strong>Adverse Reactions:</strong> Discontinue immediately if irritation occurs - consult dermatologist</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Lifestyle & Wellness Tips -->
            <div class="section">
                <div class="section-title">Lifestyle & Wellness Tips</div>
                <div class="wellness-box">
                    <ul>
                        <li><strong>Hydration Protocol:</strong> Consume 8-10 glasses of filtered water daily (minimum 2L)</li>
                        <li><strong>Sleep Hygiene:</strong> Maintain 7-9 hours quality sleep; skin regenerates 23:00-04:00</li>
                        <li><strong>Nutritional Support:</strong> Increase intake of Omega-3 fatty acids, Vitamins A, C, E, and Zinc</li>
                        <li><strong>Stress Management:</strong> Practice mindfulness, meditation, or yoga (cortisol impacts skin barrier)</li>
                        <li><strong>Physical Activity:</strong> 30 minutes moderate exercise 5x/week improves microcirculation</li>
                        <li><strong>Contraindicated Habits:</strong> Eliminate smoking, limit alcohol consumption, avoid frequent face touching</li>
                        <li><strong>Environmental Protection:</strong> Minimize pollution exposure, use air purifier if necessary</li>
                        <li><strong>Pillow Hygiene:</strong> Change pillowcases every 2-3 days (reduces bacterial transfer)</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="footer">
            <strong>CeraVe Skincare System</strong>
            <div class="divider"></div>
            <p style="margin-bottom: 10px; font-size: 13px; line-height: 1.6;">
                This consultation report has been prepared for <strong><?php echo e($session->user->name ?? 'you'); ?></strong>.
            </p>
            <p style="margin-bottom: 10px; line-height: 1.7;">
                The information provided is for educational and informational purposes only. Dr. C is an AI-powered skincare advisor 
                providing general skincare guidance based on CeraVe products.
            </p>
            <p style="margin-bottom: 15px; line-height: 1.7;">
                <strong style="color: #dc2626; font-size: 12px;">Disclaimer:</strong> For severe, persistent, or worsening skin conditions, 
                please consult a licensed dermatologist or healthcare professional.
            </p>
            <div class="divider"></div>
            <p style="color: #94a3b8; margin-top: 15px;">
                Report Generated: <?php echo e(now()->format('F d, Y \a\t h:i A')); ?> &nbsp;|&nbsp; 
                Document ID: <?php echo e($session->session_token); ?> &nbsp;|&nbsp;
                © <?php echo e(now()->year); ?> CeraVe Skincare
            </p>
        </div>
    </div>
</body>
</html>
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
        .conversation-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            max-height: 500px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 16px;
            padding: 14px;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .user-message {
            background: #dbeafe;
            border-left: 4px solid #2563eb;
        }
        .assistant-message {
            background: white;
            border-left: 4px solid #10b981;
            border: 1px solid #d1fae5;
        }
        .message-label {
            font-weight: 700;
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .message-text { color: #1f2937; line-height: 1.7; }
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
        @media screen {
            .container { margin: 20px auto; box-shadow: 0 0 40px rgba(0,0,0,0.1); }
        }
    </style>
</head>
<body>
    <a href="<?php echo e(route('dr-c.chat')); ?>" class="back-button no-print">← Back to Dr. C</a>
    <button onclick="window.print()" class="print-button no-print">🖨️ Print Report</button>
    
    <div class="container">
        <div class="header">
            <div class="logo">CeraVe Skincare Consultation</div>
            <div class="subtitle">Professional Skincare Assessment Report</div>
        </div>

        <div class="content">
            <!-- Patient Information -->
            <div class="section">
                <div class="section-title">Patient Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Patient Name</div>
                        <div class="info-value"><?php echo e($session->user->name ?? 'Guest User'); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Report Date</div>
                        <div class="info-value"><?php echo e(now()->format('F d, Y')); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Consultation Date</div>
                        <div class="info-value"><?php echo e($session->created_at->format('F d, Y')); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Consultation Time</div>
                        <div class="info-value"><?php echo e($session->created_at->format('h:i A')); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Consultant</div>
                        <div class="info-value">Dr. C (AI Assistant)</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Consultation Method</div>
                        <div class="info-value">Online Chat</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Session ID</div>
                        <div class="info-value">#<?php echo e($session->id); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value" style="text-transform: capitalize;"><?php echo e($session->status); ?></div>
                    </div>
                </div>
            </div>

            <!-- Skin Assessment -->
            <div class="section">
                <div class="section-title">Skin Assessment</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Primary Concerns</div>
                        <div class="info-value"><?php echo e($session->concerns ?? 'General skincare consultation'); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Messages Exchanged</div>
                        <div class="info-value"><?php echo e($session->message_count); ?> messages</div>
                    </div>
                </div>
            </div>

            <!-- Consultation Summary -->
            <?php
                $messages = $session->messages()->orderBy('created_at', 'asc')->get();
            ?>
            <?php if($messages->count() > 0): ?>
            <div class="section">
                <div class="section-title">Consultation Transcript</div>
                <div class="conversation-box">
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="message <?php echo e($message->message_type === 'user' ? 'user-message' : 'assistant-message'); ?>">
                            <div class="message-label">
                                <?php echo e($message->message_type === 'user' ? $session->user->name ?? 'Patient' : 'Dr. C'); ?>

                                <span style="font-weight: 400; margin-left: 8px;"><?php echo e($message->created_at->format('h:i A')); ?></span>
                            </div>
                            <div class="message-text"><?php echo e($message->message); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Professional Assessment -->
            <?php if($session->report): ?>
            <div class="section">
                <div class="section-title">Professional Assessment & Recommendations</div>
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; line-height: 1.8; border: 1px solid #e5e7eb;">
                    <?php echo nl2br(e($session->report)); ?>

                </div>
            </div>
            <?php endif; ?>

            <!-- Product Recommendations -->
            <?php
                $recommendedProducts = \App\Models\Product::whereIn('id', 
                    $messages->where('message_type', 'assistant')
                        ->pluck('message')
                        ->map(function($msg) {
                            preg_match_all('/\[PRODUCT:(\d+)\]/', $msg, $matches);
                            return $matches[1] ?? [];
                        })
                        ->flatten()
                        ->unique()
                )->get();
            ?>
            <?php if($recommendedProducts->count() > 0): ?>
            <div class="section">
                <div class="section-title">Recommended CeraVe Products</div>
                <div class="products-grid">
                    <?php $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-card">
                            <div class="product-name"><?php echo e($product->name); ?></div>
                            <div class="product-category"><?php echo e($product->category); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

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

            <!-- Additional Recommendations -->
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
        </div>

        <div class="footer">
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>CeraVe Skincare System</strong></p>
            <p style="margin-bottom: 8px;">This consultation report is for informational and educational purposes only.</p>
            <p style="margin-bottom: 8px;">It does not constitute professional medical advice, diagnosis, or treatment.</p>
            <p style="margin-bottom: 15px;">For severe or persistent skin conditions, please consult a licensed dermatologist.</p>
            <p style="color: #9ca3af;">Generated on <?php echo e(now()->format('F d, Y \a\t h:i A')); ?></p>
            <p style="color: #9ca3af; margin-top: 5px;">Report ID: <?php echo e($session->session_token); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/dr-c/report.blade.php ENDPATH**/ ?>