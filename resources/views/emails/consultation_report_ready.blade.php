<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Report Ready</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #fff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
        .header p { margin: 5px 0 0 0; font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 20px; }
        .thank-you { font-size: 16px; font-weight: 500; color: #7c3aed; margin-bottom: 20px; }
        .section { background-color: #f5f5f5; border-left: 4px solid #7c3aed; padding: 15px; border-radius: 4px; margin-bottom: 15px; }
        .section-title { font-weight: 600; color: #7c3aed; font-size: 14px; margin-bottom: 8px; }
        .section-content { color: #333; font-size: 14px; white-space: pre-line; }
        .footer { background-color: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        .footer p { margin: 5px 0; }
        .btn { display: inline-block; background-color: #7c3aed; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: 500; margin: 15px 0; }
        .btn:hover { background-color: #6d28d9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Consultation Report Ready</h1>
            <p>Your personalized skincare plan is complete</p>
        </div>

        <div class="content">
            <p class="thank-you">Hi {{ $appointment->name }},</p>
            <p>Great news! Your consultation report has been reviewed and approved. Here's your personalized skincare plan:</p>

            @if($appointment->solution)
            <div class="section">
                <div class="section-title">Treatment Plan</div>
                <div class="section-content">{{ $appointment->solution }}</div>
            </div>
            @endif

            @if($appointment->suggested_products)
            <div class="section">
                <div class="section-title">Suggested Products</div>
                <div class="section-content">{{ $appointment->suggested_products }}</div>
            </div>
            @endif

            @if($appointment->usage_instructions)
            <div class="section">
                <div class="section-title">Usage Instructions</div>
                <div class="section-content">{{ $appointment->usage_instructions }}</div>
            </div>
            @endif

            @if($appointment->consultant_notes)
            <div class="section">
                <div class="section-title">Consultant Notes</div>
                <div class="section-content">{{ $appointment->consultant_notes }}</div>
            </div>
            @endif

            <p style="margin-top: 25px;">For the complete report and detailed recommendations, please log in to your account.</p>
            
            <center>
                <a href="{{ url('/appointments/' . $appointment->id) }}" class="btn">View Full Report</a>
            </center>
        </div>

        <div class="footer">
            <p><strong>CeraVe Skincare</strong></p>
            <p>Developed with dermatologists for healthy, beautiful skin</p>
            <p style="margin-top: 10px; border-top: 1px solid #ddd; padding-top: 10px;">© 2025 CeraVe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

