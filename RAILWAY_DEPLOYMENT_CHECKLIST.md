# ✅ Railway Deployment Checklist

**Complete this checklist before deploying to Railway**

---

## 🔧 Pre-Deployment Setup

### Code Repository
- [ ] All code committed to GitHub
- [ ] `.env` file is in `.gitignore` (NOT committed)
- [ ] `composer.json` is committed
- [ ] `nixpacks.toml` is committed
- [ ] `package.json` is committed

### Laravel Configuration
- [ ] Run locally: `php artisan serve` (verify it works)
- [ ] Generate APP_KEY: `php artisan key:generate --show`
- [ ] Copy the output (starts with `base64:`)
- [ ] Migrations ready: `php artisan migrate:status`
- [ ] All seeders are up to date

### Dependencies
- [ ] `composer install` completes without errors
- [ ] `npm install` completes without errors
- [ ] `npm run build` completes without errors

---

## 🚀 Railway Deployment Steps

### Step 1: Connect GitHub
- [ ] Go to https://railway.app/dashboard
- [ ] Click "+ New Project"
- [ ] Select "Deploy from GitHub"
- [ ] Authorize Railway to access GitHub
- [ ] Select your `cerave-system` repository
- [ ] Click "Deploy"

### Step 2: Monitor Build
- [ ] Watch build progress in Deployments tab
- [ ] Build should show as "SUCCESS" (green)
- [ ] Check Logs tab for any warnings

### Step 3: Add Database
- [ ] In Railway dashboard, click "+ Add"
- [ ] Select "MySQL"
- [ ] Wait for it to initialize (~30 seconds)
- [ ] Verify `DATABASE_URL` appears in variables

### Step 4: Add Environment Variables

#### Critical Variables (MUST have)
- [ ] `APP_KEY` = base64:xxx (from earlier)
- [ ] `APP_ENV` = production
- [ ] `APP_DEBUG` = false
- [ ] `LOG_LEVEL` = error

#### Google OAuth (for Sign in)
- [ ] `GOOGLE_CLIENT_ID` = your-id
- [ ] `GOOGLE_CLIENT_SECRET` = your-secret
- [ ] `GOOGLE_REDIRECT_URI` = https://YOUR-RAILWAY-URL/auth/google/callback

#### Google Gemini (for Dr. C AI)
- [ ] `GEMINI_API_KEY` = your-api-key

#### Optional
- [ ] `CLOUDINARY_URL` (if using Cloudinary)
- [ ] `MAIL_MAILER` = log (for development) or SMTP

### Step 5: Get Your Railway URL
- [ ] In Railway dashboard, go to "Domains"
- [ ] Copy your railway app URL
- [ ] Update `GOOGLE_REDIRECT_URI` with this URL
- [ ] Also update Google Cloud Console OAuth redirect URIs

### Step 6: Trigger Redeploy
- [ ] After adding/updating variables, redeploy:
  - Click "web" service
  - Click "..." menu
  - Select "Redeploy"
- [ ] Watch logs for deployment success

---

## ✅ Post-Deployment Verification

### Check Deployment
- [ ] Logs show: "Migration successful" ✅
- [ ] Logs show: "Caching configuration" ✅
- [ ] Logs show: "Application started" ✅
- [ ] No errors in logs

### Test Core Features
- [ ] Visit `https://your-railway-url.railway.app`
- [ ] Homepage loads without errors
- [ ] Navigation works
- [ ] Static assets load (CSS, images)

### Test Key Features
- [ ] Go to `/dr-c` - Dr. C chatbot loads
- [ ] Send a message to Dr. C - Gets AI response
- [ ] Click "Sign in with Google" - Redirects to Google
- [ ] After Google approval - Logs in successfully
- [ ] Create a test appointment - Saves to database
- [ ] View appointments - Shows in list

### Test Admin Features
- [ ] Admin can login
- [ ] Can create a new product
- [ ] Product appears in database
- [ ] Can view appointments list
- [ ] Can manage appointments

---

## 🔒 Security Configuration

### Production Settings
- [ ] `APP_ENV=production` (NOT local/development)
- [ ] `APP_DEBUG=false` (NEVER true in production)
- [ ] `LOG_LEVEL=error` (NOT debug)
- [ ] Database credentials are in Railway (not in .env)
- [ ] All secrets are in Railway (not in code)

### OAuth Security
- [ ] Google OAuth verified for production URL
- [ ] Redirect URI matches EXACTLY in Google Console
- [ ] Client Secret is secure
- [ ] Test users added if needed

### API Keys
- [ ] Gemini API key is valid
- [ ] Google CLIENT_ID and CLIENT_SECRET are correct
- [ ] Cloudinary URL (if used) is correct
- [ ] All keys rotate periodically

---

## 📊 Monitoring & Health Checks

### Daily Checks
- [ ] Visit your app URL - Loads successfully
- [ ] Check Railway Logs - No errors
- [ ] Check Railway Usage - Within limits
- [ ] Database connection healthy

### Weekly Tasks
- [ ] Review error logs
- [ ] Check database size
- [ ] Verify backups (if enabled)
- [ ] Monitor resource usage

### Performance
- [ ] App loads in < 3 seconds
- [ ] Database queries are optimized
- [ ] No N+1 query problems
- [ ] Caching is working

---

## 🚨 Troubleshooting

### If Build Fails
- [ ] Check build logs for error
- [ ] Verify `composer.json` is valid
- [ ] Verify all dependencies are available
- [ ] Try local: `composer install`

### If App Won't Start
- [ ] Check start logs for error
- [ ] Verify `APP_KEY` is set
- [ ] Verify database is connected
- [ ] Check migrations ran successfully

### If Login Doesn't Work
- [ ] Verify Google OAuth URL is correct
- [ ] Check `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET`
- [ ] Verify app is added to Google test users (if in testing mode)
- [ ] Check Google Cloud Console settings

### If Dr. C Doesn't Respond
- [ ] Verify `GEMINI_API_KEY` is set
- [ ] Check API key is valid
- [ ] Verify not hitting rate limits
- [ ] Check logs for API errors

---

## 📝 Deployment Record

When you deploy, record:

**Deployment Date**: _______________

**Railway Project URL**: https://_______________

**Database**: MySQL (Railway)

**Key Features Tested**:
- [ ] Homepage loads
- [ ] Dr. C responds
- [ ] Google login works
- [ ] Appointments work

**Issues Found**: 
```
(Leave blank if none)
___________________________________
___________________________________
```

**Resolution**:
```
___________________________________
___________________________________
```

---

## 🎉 Deployment Complete!

If all checkboxes are checked, your CeraVe system is successfully deployed on Railway! 🚀

**Share your URL with users**: `https://your-railway-domain.railway.app`

---

## 📞 Quick Help

### Common Error Messages

| Error | Solution |
|-------|----------|
| "No application encryption key" | Add `APP_KEY` to Railway variables |
| "SQLSTATE[HY000]" | Database not connected, check MySQL addon |
| "Access blocked" (Google) | Update GOOGLE_REDIRECT_URI in Railway + Google Console |
| "502 Bad Gateway" | Check logs, might be out of memory |
| "Class not found" | Run `composer install --no-dev --optimize-autoloader` |

### Useful Commands

```bash
# Check migrations status
php artisan migrate:status

# Check config
php artisan config:show

# View logs
php artisan log:tail

# Clear all caches
php artisan cache:clear
```

---

**Everything set? You're ready to go live!** ✅🎉
