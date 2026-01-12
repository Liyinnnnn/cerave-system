# 🔧 Fix Google OAuth "Access Blocked" Issue

## Problem
When users click "Sign in with Google", they see **"Access blocked: This app's request is invalid"**

## Root Causes
1. ❌ Missing or incorrect `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET`
2. ❌ Wrong redirect URI in Google Console
3. ❌ OAuth consent screen not configured
4. ❌ App not published/verified in Google Console

---

## ✅ Complete Fix (Step-by-Step)

### **Step 1: Get Google OAuth Credentials**

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project (or select existing):
   - Click "Select a project" → "New Project"
   - Name: `CeraVe System` → Click "Create"

3. Enable Google+ API:
   - Go to "APIs & Services" → "Library"
   - Search for "Google+ API"
   - Click "Enable"

4. Create OAuth Credentials:
   - Go to "APIs & Services" → "Credentials"
   - Click "+ CREATE CREDENTIALS" → "OAuth client ID"
   - If prompted, click "CONFIGURE CONSENT SCREEN"

### **Step 2: Configure OAuth Consent Screen**

1. Choose **"External"** (for public users) → Click "Create"

2. **App Information**:
   - App name: `CeraVe Skincare System`
   - User support email: Your email
   - Developer contact: Your email
   - Click "Save and Continue"

3. **Scopes** (Click "Add or Remove Scopes"):
   - Select these scopes:
     - `userinfo.email`
     - `userinfo.profile`
     - `openid`
   - Click "Update" → "Save and Continue"

4. **Test Users** (Important!):
   - Click "+ ADD USERS"
   - Add your email and any test user emails
   - Click "Save and Continue"

5. **Summary**:
   - Review and click "Back to Dashboard"

### **Step 3: Create OAuth Client ID**

1. Go back to "Credentials" → "+ CREATE CREDENTIALS" → "OAuth client ID"

2. Configure:
   - Application type: **Web application**
   - Name: `CeraVe Web Client`

3. **Authorized redirect URIs** (CRITICAL!):
   ```
   For Local Development:
   http://localhost:8000/auth/google/callback
   http://127.0.0.1:8000/auth/google/callback
   
   For Production (add your deployed URL):
   https://your-domain.com/auth/google/callback
   ```
   
4. Click "Create"

5. **COPY** your credentials:
   - Client ID: `xxxxx.apps.googleusercontent.com`
   - Client Secret: `xxxxxx`

### **Step 4: Update Your `.env` File**

Add these to your `.env` file:

```env
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**For production**, change to:
```env
GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback
```

### **Step 5: Clear Cache**

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 🧪 Test the Fix

1. Start your server: `php artisan serve`
2. Go to login page
3. Click "Sign in with Google"
4. Should redirect to Google consent screen
5. After allowing, should redirect back and log you in

---

## ⚠️ Common Issues & Solutions

### Issue: "Access blocked: This app's request is invalid"
**Solution**: 
- Double-check redirect URI matches EXACTLY in Google Console
- Make sure OAuth consent screen is configured
- Add yourself as a test user

### Issue: "Error 400: redirect_uri_mismatch"
**Solution**:
- Your `.env` redirect URI doesn't match Google Console
- Check for trailing slashes, http vs https
- Update both to match exactly

### Issue: "This app isn't verified"
**Solution**: 
- Normal for development! Click "Advanced" → "Go to [app name] (unsafe)"
- For production, submit for verification (takes 2-3 weeks)
- OR keep it in testing mode with test users

---

## 📋 Production Deployment Checklist

When deploying to production:

1. ✅ Update `APP_URL` in `.env`
2. ✅ Update `GOOGLE_REDIRECT_URI` to production URL
3. ✅ Add production redirect URI in Google Console
4. ✅ Either:
   - Submit app for verification (recommended)
   - OR add all users as test users (limit 100 users)
5. ✅ Clear all caches after deploying

---

## 🔒 Security Notes

- ⚠️ Never commit `.env` file to git
- ⚠️ Keep `GOOGLE_CLIENT_SECRET` private
- ⚠️ Use environment variables in production
- ✅ Verify redirect URIs are HTTPS in production

---

## 🆘 Still Having Issues?

Check these:
1. Is Google+ API enabled?
2. Are you added as a test user?
3. Do redirect URIs match EXACTLY?
4. Did you clear Laravel cache?
5. Is Socialite package installed? (`composer require laravel/socialite`)

---

**Need Help?** Check logs at `storage/logs/laravel.log` for detailed error messages.
