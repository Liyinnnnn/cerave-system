# 🚀 Railway Deployment Guide - Complete Setup

**This guide will get your CeraVe system running on Railway hosting successfully!**

---

## ✅ Prerequisites

- GitHub account with your code pushed
- Railway account (sign up at https://railway.app)
- 5 minutes to deploy

---

## 📋 Step 1: Prepare Your Code

### 1.1 Make sure files are committed to GitHub

```bash
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

### 1.2 Verify these files exist in your project:
- ✅ `composer.json` - Dependencies
- ✅ `nixpacks.toml` - Build configuration (already set up)
- ✅ `Procfile` - Start command (already set up)
- ✅ `.env.example` - Environment template (already updated)

---

## 🚀 Step 2: Deploy to Railway

### 2.1 Create Railway Project

1. Go to https://railway.app
2. Sign in (or create account)
3. Click "+ New Project"
4. Select "Deploy from GitHub"
5. Select your `cerave-system` repository
6. Click "Deploy"

**Railway will start building automatically!** ✅

---

## ⚙️ Step 3: Configure Environment Variables

### 3.1 Add MySQL Database

1. In Railway dashboard, click "+ Add"
2. Select "MySQL"
3. Railway will automatically create a database
4. You should see `DATABASE_URL` added to variables

### 3.2 Generate APP_KEY

In Railway dashboard terminal (or locally):

```bash
# Option 1: Locally, then copy to Railway
php artisan key:generate --show
# Copy the base64:... output

# Option 2: In Railway dashboard
```

Then add to Railway variables:
- Click "Cmd + K" or settings
- Add variable: `APP_KEY` = `base64:...` (from above)

### 3.3 Add All Required Variables

Click "Add Variable" for each of these:

| Variable | Value | Notes |
|----------|-------|-------|
| `APP_ENV` | `production` | For production |
| `APP_DEBUG` | `false` | Never true in production |
| `LOG_LEVEL` | `error` | Only log errors |
| `DB_CONNECTION` | `mysql` | Fixed |
| `SESSION_DRIVER` | `database` | Fixed |
| `CACHE_DRIVER` | `database` | Fixed |

### 3.4 Add Optional (But Recommended)

```
GOOGLE_CLIENT_ID=your-id
GOOGLE_CLIENT_SECRET=your-secret
GOOGLE_REDIRECT_URI=https://your-railway-url.railway.app/auth/google/callback

GEMINI_API_KEY=your-key

CLOUDINARY_URL=cloudinary://your-url (if using Cloudinary)
```

**IMPORTANT**: Replace `your-railway-url` with your actual Railway domain

---

## 🔗 Step 4: Get Your URL

1. In Railway dashboard, click your project
2. Look for "Domains" section
3. You'll see something like: `cerave-system-production.railway.app`
4. Update `GOOGLE_REDIRECT_URI` with this URL

---

## ✅ Step 5: Verify Deployment

### 5.1 Check Deployment Status

1. Click your project in Railway
2. Look for "Deployments" tab
3. Should show "Build successful" ✅

### 5.2 Check Logs for Errors

1. Click the "web" service
2. Go to "Logs" tab
3. Should see:
   ```
   Running migrations...
   Migration successful ✅
   Caching configuration...
   Application ready
   ```

### 5.3 Test Your App

1. Click "Open deployment" or visit: `https://your-domain.railway.app`
2. You should see your CeraVe homepage ✅

---

## 🧪 Step 6: Test Key Features

After deployment, test these:

### Test 1: Database Connection
- Go to admin panel
- Create a new product
- Verify it saves and displays

### Test 2: Dr. C Chatbot
- Go to `/dr-c`
- Type a message
- Should get Gemini AI response

### Test 3: Google Login
- Click "Sign in with Google"
- Should redirect to Google
- After approving, should login successfully

### Test 4: Appointments
- Create an appointment
- Verify it saves to database

---

## ⚠️ Common Issues & Fixes

### Issue 1: "Build Failed"
**Solution**:
- Check Logs tab for error message
- Usually missing dependencies
- Make sure `composer.json` is committed
- Push fix: `git push`
- Railway auto-redeploys

### Issue 2: "Database connection failed"
**Solution**:
- Verify MySQL addon is added
- Check `DATABASE_URL` variable exists
- Restart web service: Settings → Redeploy

### Issue 3: "APP_KEY not specified"
**Solution**:
- Generate new key locally: `php artisan key:generate --show`
- Copy value (starts with `base64:`)
- Add to Railway: `APP_KEY=base64:...`
- Redeploy

### Issue 4: "Google OAuth says invalid redirect"
**Solution**:
- Get your Railway URL from Domains
- Update in Google Cloud Console
- Update `GOOGLE_REDIRECT_URI` in Railway
- Example: `https://cerave-system.railway.app/auth/google/callback`

### Issue 5: "Session not persisting / Logout on refresh"
**Solution**:
- Set `SESSION_DRIVER=database` (already done)
- Run migrations: `php artisan migrate --force`
- Restart service

---

## 🔒 Security Checklist

Before going live, verify:

- ✅ `APP_DEBUG=false` (never true in production)
- ✅ `APP_ENV=production`
- ✅ All secrets added to Railway (not in code)
- ✅ `.env` NOT committed to git
- ✅ Google OAuth verified for production
- ✅ Gemini API key is valid
- ✅ Database migrations ran successfully

---

## 📊 Monitoring Your App

### Check Status
1. Go to Railway dashboard
2. Click your project
3. See "Usage" and "Health" tabs

### View Logs
1. Click "web" service
2. "Logs" tab shows real-time output
3. Check for errors or crashes

### Restart Service
1. Click "web" service
2. Click "..." menu
3. Select "Restart"

---

## 🆙 Deployment Updates

### To Deploy New Changes

1. Make changes locally
2. Test locally: `php artisan serve`
3. Commit: `git add . && git commit -m "Update" && git push`
4. Railway auto-deploys (3-5 minutes)
5. Check logs to confirm success

---

## 🎯 Production Best Practices

### Daily Operations
1. Check logs weekly for errors
2. Monitor database usage
3. Backup important data regularly

### Performance
- Railway MySQL has limits
- For high traffic: Upgrade plan
- Check "Usage" tab for limits

### Updates
- Test locally first
- Deploy during low-traffic time
- Keep backups

---

## 📞 Getting Help

### If Deployment Fails:
1. Check Logs tab (most errors shown there)
2. Google the error message
3. Check Railway docs: https://docs.railway.app

### Common Resources:
- Laravel docs: https://laravel.com/docs
- Railway docs: https://docs.railway.app
- Troubleshooting: https://railway.app/support

---

## 🎉 Success!

Your CeraVe system is now live on Railway! 🚀

**Your app URL**: `https://your-domain.railway.app`

### What's Included:
- ✅ MySQL Database
- ✅ Automatic migrations
- ✅ Dr. C with Gemini AI
- ✅ Google OAuth login
- ✅ All features working

### Next Steps:
1. Test all features
2. Share URL with users
3. Monitor performance
4. Make updates as needed

---

## 📋 Quick Reference

### Important Railway URLs
- Dashboard: https://railway.app/dashboard
- Project settings: Railway → Project → Settings
- Environment variables: Railway → Project → Variables
- Logs: Railway → Project → web → Logs

### Important Commands
```bash
# Check logs locally
php artisan log:tail

# Test migrations
php artisan migrate:status

# Clear caches
php artisan cache:clear

# Check config
php artisan config:show
```

---

**Happy deploying! Your CeraVe system is production-ready!** 🎉
