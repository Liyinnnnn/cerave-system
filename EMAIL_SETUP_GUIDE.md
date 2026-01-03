# Email Configuration Guide

## Overview
CeraVe System now includes comprehensive email verification and password reset functionality with professional UI and toast notifications.

## Features Implemented

### 1. **Email Verification on Registration**
- New users must verify their email before accessing the dashboard
- Professional verification email sent automatically on registration
- Styled verification reminder page
- Resend verification link functionality

### 2. **Forgot Password Flow**
- Professional forgot password interface matching CeraVe theme
- Password reset link sent via email
- Secure token-based reset system
- AJAX-based form submission with toast feedback

### 3. **Professional UI Enhancements**
- All authentication pages styled with gradient backgrounds
- Consistent CeraVe blue theme throughout
- Toast notifications for success/error feedback
- Smooth animations and transitions
- Mobile-responsive design

## Email Configuration

### Development Setup (Using Log Driver)
By default, emails are logged to `storage/logs/laravel.log`. This is perfect for development.

**Current Configuration:**
```env
MAIL_MAILER=log
```

To view emails during development, check:
```
storage/logs/laravel.log
```

### Production Setup (Using SMTP)

For production, update your `.env` file with SMTP credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@cerave.com
MAIL_FROM_NAME="CeraVe Skincare"
```

### Popular Email Services

#### Gmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```
**Note:** Use [App Passwords](https://support.google.com/accounts/answer/185833) for Gmail

#### Mailgun
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-api-key
```

#### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

## Testing Email Functionality

### 1. Test Registration with Email Verification
```bash
# Register a new user at: http://localhost/register
# Check logs or email inbox for verification link
# Click the verification link
# Try to login - should require verification
```

### 2. Test Forgot Password
```bash
# Visit: http://localhost/forgot-password
# Enter your email address
# Check logs or email for reset link
# Click reset link and create new password
```

### 3. View Logged Emails (Development)
```bash
# On Windows
type storage\logs\laravel.log | findstr "verification"

# On Linux/Mac
tail -f storage/logs/laravel.log | grep verification
```

## User Flow

### Registration Flow
1. User fills registration form
2. User submits form (AJAX)
3. Success toast appears
4. Verification email sent
5. Redirect to login page with success message
6. User clicks verification link in email
7. Email verified, user can now log in

### Login Flow with Verification
1. User enters credentials
2. System checks email verification status
3. If not verified: Redirect to verification notice
4. If verified: Login successful, redirect to dashboard

### Password Reset Flow
1. User clicks "Forgot Password?" on login page
2. Enters email address (AJAX form)
3. Reset link sent via email
4. Success toast appears
5. User clicks reset link in email
6. Enters new password (AJAX form)
7. Success toast appears
8. Redirects to login page

## Files Modified

### Controllers
- `app/Http/Controllers/Auth/RegisteredUserController.php` - Added email verification
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` - Check verification on login
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` - JSON support
- `app/Http/Controllers/Auth/NewPasswordController.php` - JSON support

### Models
- `app/Models/User.php` - Implements MustVerifyEmail interface

### Views
- `resources/views/auth/register.blade.php` - Enhanced with AJAX and toasts
- `resources/views/auth/login.blade.php` - Improved styling and messaging
- `resources/views/auth/forgot-password.blade.php` - Complete redesign with AJAX
- `resources/views/auth/reset-password.blade.php` - Complete redesign with AJAX
- `resources/views/auth/verify-email.blade.php` - Professional styled page

## Toast Notifications

All authentication forms now include client-side toast notifications:
- **Green toast** for success (5 seconds)
- **Red toast** for errors (7 seconds)
- Top-right positioning
- Smooth slide-in animation
- Auto-dismiss functionality

## Security Features

1. **Email Verification Required** - Users cannot access dashboard until verified
2. **Secure Password Reset** - Token-based with expiration
3. **Rate Limiting** - Built-in throttling on verification resends
4. **CSRF Protection** - All forms protected
5. **Password Requirements** - Enforced via Laravel validation

## Troubleshooting

### Emails Not Sending
1. Check `.env` mail configuration
2. Verify SMTP credentials
3. Check firewall settings for SMTP ports
4. Review `storage/logs/laravel.log` for errors

### Verification Link Not Working
1. Ensure APP_URL is set correctly in `.env`
2. Check signed URL configuration
3. Verify email_verified_at column exists in users table

### Password Reset Issues
1. Check password_reset_tokens table exists
2. Verify token expiration settings
3. Ensure email matches a user account

## Next Steps

1. **Configure Production Email Service** - Choose and set up SMTP/Mailgun/SendGrid
2. **Customize Email Templates** - Edit notification mail templates as needed
3. **Test Thoroughly** - Test all flows in staging before production
4. **Monitor Logs** - Set up log monitoring for email failures
5. **Set Up Email Queue** - For better performance, use Laravel queues for emails

## Additional Resources

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Laravel Email Verification](https://laravel.com/docs/verification)
- [Laravel Password Reset](https://laravel.com/docs/passwords)
