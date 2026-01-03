<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request Received</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); color: #fff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
        .header p { margin: 5px 0 0 0; font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 20px; }
        .thank-you { font-size: 16px; font-weight: 500; color: #0066cc; margin-bottom: 20px; }
        .details { background-color: #f5f5f5; border-left: 4px solid #0066cc; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .details-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; }
        .details-label { font-weight: 600; color: #666; }
        .details-value { color: #333; text-align: right; }
        .footer { background-color: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        .footer p { margin: 5px 0; }
        .btn { display: inline-block; background-color: #0066cc; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: 500; margin: 15px 0; }
        .btn:hover { background-color: #0052a3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Request Received</h1>
            <p>We've got your request and will be in touch soon</p>
        </div>

        <div class="content">
            <p class="thank-you">Hi {{ $appointment->name }},</p>
            <p>Thank you for choosing CeraVe for your skincare consultation! We've received your appointment request and will contact you shortly to confirm the details.</p>

            <div class="details">
                <div class="details-row">
                    <span class="details-label">Email:&nbsp;</span>
                    <span class="details-value">{{ $appointment->email }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Phone:&nbsp;</span>
                    <span class="details-value">{{ $appointment->phone }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Preferred Date:&nbsp;</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Preferred Time:&nbsp;</span>
                    <span class="details-value">{{ $appointment->preferred_time }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Consultation Type:&nbsp;</span>
                    <span class="details-value">{{ ucfirst($appointment->consultation_type) }}</span>
                </div>
                @if($appointment->concerns)
                <div class="details-row">
                    <span class="details-label">Your Concerns:&nbsp;</span>
                    <span class="details-value" style="text-align: right; white-space: normal; max-width: 250px;">{{ $appointment->concerns }}</span>
                </div>
                @endif
            </div>

        <div class="footer">
            <p><strong>CeraVe Skincare</strong></p>
            <p>Developed with dermatologists for healthy, beautiful skin</p>
            <p style="margin-top: 10px; border-top: 1px solid #ddd; padding-top: 10px;">© 2025 CeraVe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
