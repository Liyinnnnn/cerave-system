<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: #fff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
        .header p { margin: 5px 0 0 0; font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 20px; }
        .status-badge { display: inline-block; background-color: #16a34a; color: #fff; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 20px; }
        .thank-you { font-size: 16px; font-weight: 500; color: #16a34a; margin-bottom: 20px; }
        .details { background-color: #f5f5f5; border-left: 4px solid #16a34a; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .details-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; }
        .details-label { font-weight: 600; color: #666; }
        .details-value { color: #333; text-align: right; }
        .note-box { background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .note-box p { margin: 5px 0; font-size: 14px; color: #92400e; }
        .footer { background-color: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        .footer p { margin: 5px 0; }
        .btn { display: inline-block; background-color: #16a34a; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: 500; margin: 15px 0; }
        .btn:hover { background-color: #15803d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✓ Appointment Confirmed</h1>
            <p>Your consultation is scheduled</p>
        </div>

        <div class="content">
            <span class="status-badge">STATUS: CONFIRMED</span>
            
            <p class="thank-you">Hi {{ $appointment->name }},</p>
            <p>Great news! Your CeraVe skincare consultation has been confirmed. We're looking forward to helping you achieve your skincare goals!</p>

            <div class="details">
                <div class="details-row">
                    <span class="details-label">Date:&nbsp;</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Time:&nbsp;</span>
                    <span class="details-value">{{ $appointment->preferred_time }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Consultation Type:&nbsp;</span>
                    <span class="details-value">{{ ucfirst($appointment->consultation_type) }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Email:&nbsp;</span>
                    <span class="details-value">{{ $appointment->email }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Phone:&nbsp;</span>
                    <span class="details-value">{{ $appointment->phone }}</span>
                </div>
            </div>

            @if($appointment->consultation_type === 'in-store')
            <div class="note-box">
                <p><strong>📍 Important Reminder:</strong></p>
                <p>• Please arrive 5-10 minutes early</p>
                <p>• Bring any skincare products you're currently using</p>
                <p>• Come with a clean, makeup-free face if possible</p>
            </div>
            @else
            <div class="note-box">
                <p><strong>💻 Video Call Instructions:</strong></p>
                <p>• You'll receive the video call link 1 hour before your appointment</p>
                <p>• Ensure you have a stable internet connection</p>
                <p>• Be in a well-lit area for better skin assessment</p>
            </div>
            @endif

            <p style="margin-top: 25px;">If you need to reschedule or have any questions, please don't hesitate to contact us.</p>
            
            <center>
                <a href="{{ url('/appointments') }}" class="btn">View My Appointments</a>
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

