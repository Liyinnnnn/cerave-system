# 🚀 Railway + Cloudinary Deployment Guide
## Stay 100% FREE After Deployment

---

## 📋 **Pre-Deployment Checklist**

Before starting, ensure you have:
- ✅ GitHub account
- ✅ Your Laravel project pushed to GitHub
- ✅ Email address for Railway & Cloudinary signup
- ✅ NO credit card needed (both have free tiers without card)

---

## **STEP 1: Setup Cloudinary (5 minutes)**

### 1.1 Create Free Account
1. Go to https://cloudinary.com/users/register/free
2. Sign up with email (NO credit card required)
3. Verify your email address
4. Login to Cloudinary Dashboard

### 1.2 Get Your Credentials
1. Go to **Dashboard** → **Programmable Media**
2. Copy these 3 values (you'll need them later):
   ```
   Cloud Name: your_cloud_name
   API Key: your_api_key
   API Secret: your_api_secret
   ```
3. Keep these values safe!

### 1.3 Create Upload Preset (IMPORTANT!)
1. Go to **Settings** → **Upload**
2. Scroll to **Upload presets**
3. Click **Add upload preset**
4. Set **Signing Mode** to **Unsigned**
5. Set **Folder** to `cerave-products`
6. Copy the **Preset name** (e.g., `ml_default` or create your own)
7. Click **Save**

**Free Tier Limits:**
- ✅ 25 GB storage
- ✅ 25 GB bandwidth/month
- ✅ 25,000 transformations/month
- ✅ Unlimited image optimization

---

## **STEP 2: Prepare Your Laravel Project**

### 2.1 Install Cloudinary Package

Run in your terminal:
```bash
composer require cloudinary-labs/cloudinary-laravel
```

### 2.2 Publish Cloudinary Config

```bash
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"
```

### 2.3 Update .env File

Add these lines to your `.env`:
```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

Replace with your actual Cloudinary credentials from Step 1.2

---

## **STEP 3: Setup Railway (10 minutes)**

### 3.1 Create Railway Account
1. Go to https://railway.app/
2. Click **Login** → **Sign in with GitHub**
3. Authorize Railway to access GitHub
4. NO credit card required!

### 3.2 Create New Project
1. Click **New Project**
2. Select **Deploy from GitHub repo**
3. Choose your `cerave-system` repository
4. Click **Deploy**

### 3.3 Add MySQL Database
1. In your Railway project, click **+ New**
2. Select **Database** → **Add MySQL**
3. Wait for database to provision (~30 seconds)
4. Database will auto-connect to your Laravel app

### 3.4 Configure Environment Variables

1. Click on your Laravel service (not the database)
2. Go to **Variables** tab
3. Add these variables ONE BY ONE:

```env
APP_NAME=CeraVe System
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=error
```

4. Click **Add** after each variable
5. Railway will auto-redeploy after adding variables

### 3.5 Generate APP_KEY

1. In Railway project, click on your service
2. Go to **Settings** → **Deploy**
3. Add this to **Start Command**:
   ```bash
   php artisan key:generate --force && php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:$PORT -t public
   ```
4. Click **Deploy** button

---

## **STEP 4: Deploy & Test**

### 4.1 Wait for Deployment
1. Go to **Deployments** tab
2. Watch the build logs
3. Wait for ✅ **Success** status (~3-5 minutes)

### 4.2 Get Your Live URL
1. Go to **Settings** tab
2. Scroll to **Domains**
3. Click **Generate Domain**
4. Copy your URL: `https://your-app.up.railway.app`

### 4.3 Test Your App
1. Open your Railway URL in browser
2. Register a new account
3. Upload a product image to test Cloudinary
4. Check if images display correctly

---

## **STEP 5: Keep It FREE (IMPORTANT!)**

### 5.1 Enable Railway Sleep Mode
1. Go to your Railway project
2. Click on your Laravel service
3. Go to **Settings** → **Sleep Mode**
4. Enable **Sleep after 30 minutes of inactivity**
5. Click **Save**

**What this does:**
- App sleeps when no one uses it
- Wakes up instantly when someone visits
- Saves compute hours = stays within $5 credit

### 5.2 Monitor Your Usage
1. Go to Railway Dashboard
2. Check **Usage** tab regularly
3. Watch your monthly spend (should stay under $5)

**Usage breakdown:**
```
Target monthly spend: $5 (free credit)
Expected usage with sleep mode: $2-3/month
Remaining credit: $2-3 buffer
```

### 5.3 Optimize Database Queries
- Use caching for frequently accessed data
- Add database indexes for faster queries
- Minimize complex joins in reports

---

## **STEP 6: Email Setup (Optional but Recommended)**

### Gmail Setup:
1. Enable 2-Factor Authentication on your Gmail
2. Generate App Password:
   - Go to Google Account → Security
   - Click **2-Step Verification**
   - Scroll to **App passwords**
   - Select **Mail** and **Other**
   - Copy the 16-character password
3. Use this password in `MAIL_PASSWORD` variable

### Alternative Free SMTP:
- **Mailtrap** (testing only): mailtrap.io
- **SendGrid** (100 emails/day free): sendgrid.com
- **Mailgun** (100 emails/day free): mailgun.com

---

## **💰 Cost Monitoring**

### Railway Dashboard:
- Check **Usage** daily for first week
- Watch for compute hours
- Ensure MySQL stays under 500MB

### Expected Monthly Usage:
```
Compute: ~400 hours (with sleep mode) = $3
MySQL: 500MB = $0.12
Total: ~$3.12 (within $5 free credit) ✅
```

### Warning Signs:
- ⚠️ Usage approaching $5 → Reduce active hours
- ⚠️ MySQL over 500MB → Clean old data
- ⚠️ 500+ hours compute → Enable sleep mode

---

## **🔧 Troubleshooting**

### App Won't Deploy:
```bash
# Check Railway logs
# Common fix: Add to composer.json
"post-install-cmd": [
    "@php artisan key:generate --ansi",
    "@php artisan config:cache",
    "@php artisan route:cache"
]
```

### Images Not Uploading:
- Verify Cloudinary credentials in Railway variables
- Check unsigned upload preset is enabled
- Test Cloudinary URL format

### Database Connection Error:
- Ensure MySQL service is running in Railway
- Check DATABASE_URL variable is set
- Verify DB credentials match MySQL service

### Email Not Sending:
- Verify Gmail App Password (not regular password)
- Check MAIL_PORT is 587 (not 465)
- Test with Mailtrap first

---

## **📊 Success Checklist**

After deployment, verify:
- [ ] App loads at Railway URL
- [ ] User registration works
- [ ] Login/logout works
- [ ] Product images upload to Cloudinary
- [ ] Images display correctly on product pages
- [ ] Admin panel accessible
- [ ] Email notifications send
- [ ] Sleep mode enabled in Railway
- [ ] Usage tracking shows < $5/month

---

## **🎉 You're Live!**

Your CeraVe system is now:
- ✅ Hosted on Railway (FREE)
- ✅ Images on Cloudinary (FREE)
- ✅ MySQL database (FREE)
- ✅ Accessible worldwide
- ✅ Auto-scaling enabled
- ✅ HTTPS secured

**Monthly Cost: $0** (if staying within free tiers)

---

## **📞 Support Links**

- Railway Docs: https://docs.railway.app/
- Cloudinary Docs: https://cloudinary.com/documentation
- Laravel Deployment: https://laravel.com/docs/11.x/deployment

---

## **⚡ Quick Commands Reference**

```bash
# View Railway logs
railway logs

# Run migrations on Railway
railway run php artisan migrate

# Clear cache on Railway
railway run php artisan cache:clear

# SSH into Railway container
railway shell
```

---

**Remember:** Sleep mode is your friend! It keeps your app FREE by reducing compute hours while maintaining instant wake-up for users.

**Happy Deploying! 🚀**
