# ✅ Railway + Cloudinary Deployment Checklist

Use this checklist to ensure your deployment stays **100% FREE**!

---

## **BEFORE DEPLOYMENT**

### Local Setup:
- [ ] Run `setup-deployment.bat` (Windows) or `setup-deployment.sh` (Mac/Linux)
- [ ] Verify `config/cloudinary.php` was created
- [ ] Add Cloudinary credentials to `.env`
- [ ] Test locally that images upload work
- [ ] Commit all changes to GitHub
- [ ] Push to GitHub repository

### Accounts Created:
- [ ] Cloudinary account created (no credit card)
- [ ] Railway account created (no credit card)
- [ ] GitHub repository is public or Railway has access

---

## **CLOUDINARY SETUP**

- [ ] Signed up at cloudinary.com (FREE, no card)
- [ ] Verified email address
- [ ] Copied Cloud Name from dashboard
- [ ] Copied API Key from dashboard
- [ ] Copied API Secret from dashboard
- [ ] Created unsigned upload preset
- [ ] Upload preset folder set to `cerave-products`
- [ ] Saved preset name for later

**Free Tier Confirmed:**
- [ ] 25 GB storage available
- [ ] 25 GB bandwidth/month available
- [ ] No credit card required

---

## **RAILWAY SETUP**

### Project Creation:
- [ ] Signed in to Railway with GitHub
- [ ] Created new project from GitHub repo
- [ ] Selected correct repository
- [ ] Initial deployment started

### Database Setup:
- [ ] Added MySQL database service
- [ ] Database provisioned successfully
- [ ] Database auto-connected to Laravel app
- [ ] Verified database environment variables

### Environment Variables Added:
- [ ] APP_NAME
- [ ] APP_ENV=production
- [ ] APP_DEBUG=false
- [ ] APP_URL (Railway domain)
- [ ] All DB_* variables (auto-filled by MySQL)
- [ ] CLOUDINARY_CLOUD_NAME
- [ ] CLOUDINARY_API_KEY
- [ ] CLOUDINARY_API_SECRET
- [ ] CLOUDINARY_URL
- [ ] MAIL_* variables (if using email)
- [ ] SESSION_DRIVER=database
- [ ] CACHE_DRIVER=database

### Domain Setup:
- [ ] Generated Railway domain
- [ ] Copied domain URL
- [ ] Updated APP_URL in Railway variables
- [ ] Domain is HTTPS enabled

---

## **DEPLOYMENT VERIFICATION**

### Build & Deploy:
- [ ] Deployment logs show success
- [ ] No errors in build logs
- [ ] Migrations ran successfully
- [ ] App is accessible at Railway URL

### Functionality Tests:
- [ ] Homepage loads correctly
- [ ] Can register new account
- [ ] Can login successfully
- [ ] Can create new product
- [ ] **Can upload product image (tests Cloudinary)**
- [ ] Uploaded image displays correctly
- [ ] Images load from Cloudinary URL (https://res.cloudinary.com/...)
- [ ] Admin panel accessible
- [ ] All routes working

### Performance:
- [ ] Page load time < 3 seconds
- [ ] Images load quickly (CDN)
- [ ] No console errors in browser
- [ ] Mobile responsive

---

## **KEEP IT FREE - CRITICAL!**

### Sleep Mode Enabled:
- [ ] Railway Settings → Sleep Mode enabled
- [ ] Sleep after 30 minutes of inactivity
- [ ] App wakes up automatically when visited

### Usage Monitoring:
- [ ] Railway Usage tab checked
- [ ] Current usage < $5/month
- [ ] Compute hours reasonable (~400/month)
- [ ] MySQL storage < 500MB

### Optimization Applied:
- [ ] Database queries optimized
- [ ] Caching enabled (config, routes, views)
- [ ] Unnecessary cron jobs disabled
- [ ] Log level set to 'error' only

---

## **COST BREAKDOWN VERIFIED**

```
Railway:
  Compute: $3/month (with sleep mode)
  MySQL: $0.12/month (500MB)
  Total: $3.12/month

Cloudinary:
  Storage: $0/month (25GB free)
  Bandwidth: $0/month (25GB free)
  Total: $0/month

GRAND TOTAL: $3.12/month (within $5 free credit) ✅
```

---

## **POST-DEPLOYMENT TASKS**

### Week 1:
- [ ] Check Railway usage daily
- [ ] Verify sleep mode working
- [ ] Test app from different devices
- [ ] Monitor Cloudinary bandwidth usage

### Week 2-4:
- [ ] Check Railway usage 2x per week
- [ ] Ensure staying under $5/month
- [ ] Test all features working
- [ ] Collect user feedback

### Monthly:
- [ ] Review Railway billing
- [ ] Check Cloudinary usage stats
- [ ] Clean up unused images (if any)
- [ ] Optimize database if growing large

---

## **TROUBLESHOOTING CHECKLIST**

If something goes wrong:

### App Won't Deploy:
- [ ] Check Railway build logs for errors
- [ ] Verify all environment variables set
- [ ] Ensure GitHub repo has latest code
- [ ] Check `nixpacks.toml` and `Procfile` are committed

### Images Not Uploading:
- [ ] Verify Cloudinary credentials in Railway
- [ ] Check unsigned upload preset enabled
- [ ] Test Cloudinary URL format correct
- [ ] Check file size < 10MB

### Database Errors:
- [ ] Verify MySQL service running
- [ ] Check DB credentials match
- [ ] Run migrations manually: `railway run php artisan migrate`
- [ ] Check database disk space

### Exceeding Free Tier:
- [ ] Enable sleep mode immediately
- [ ] Reduce active hours
- [ ] Optimize database queries
- [ ] Clean old logs
- [ ] Check for infinite loops or background jobs

---

## **SUCCESS METRICS**

Your deployment is successful when:

- ✅ App accessible 24/7
- ✅ Users can upload images
- ✅ Images load from Cloudinary
- ✅ Email notifications work
- ✅ Railway usage < $5/month
- ✅ Cloudinary usage < 25GB
- ✅ No errors in production logs
- ✅ Sleep mode active and working

---

## **EMERGENCY CONTACTS**

- Railway Status: https://status.railway.app/
- Cloudinary Support: https://support.cloudinary.com/
- Laravel Docs: https://laravel.com/docs/11.x

---

## **FINAL CHECKLIST**

Before marking deployment complete:

- [ ] All items above checked
- [ ] App tested by 3+ users
- [ ] Images upload successfully
- [ ] Railway usage monitored for 1 week
- [ ] Staying within free tier
- [ ] Documentation saved
- [ ] Backup plan ready (if exceeding limits)

---

**🎉 CONGRATULATIONS!**

You now have a fully deployed, production-ready Laravel app running **completely FREE** on Railway + Cloudinary!

**Share your live URL:** https://your-app.up.railway.app

---

*Date Completed: __________*
*Railway URL: __________*
*Notes: __________*
