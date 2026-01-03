# 🚀 Quick Start - Deploy in 30 Minutes

**Goal:** Get your CeraVe system live on Railway + Cloudinary for FREE

---

## **Step 1: Install Cloudinary (2 min)**

Run this command:
```bash
setup-deployment.bat
```

This installs the Cloudinary package.

---

## **Step 2: Cloudinary Account (5 min)**

1. Go to https://cloudinary.com/users/register/free
2. Sign up (NO credit card)
3. Copy these 3 values from dashboard:
   - Cloud Name
   - API Key
   - API Secret
4. Paste them into your `.env`:
   ```env
   CLOUDINARY_CLOUD_NAME=your_cloud_name
   CLOUDINARY_API_KEY=your_api_key
   CLOUDINARY_API_SECRET=your_api_secret
   ```

---

## **Step 3: Push to GitHub (3 min)**

```bash
git add .
git commit -m "Add Railway deployment files"
git push origin main
```

---

## **Step 4: Railway Setup (10 min)**

1. Go to https://railway.app/
2. Click **Login** → **Sign in with GitHub**
3. Click **New Project** → **Deploy from GitHub repo**
4. Select your `cerave-system` repository
5. Click **+ New** → **Database** → **Add MySQL**
6. Click your Laravel service → **Variables** tab
7. Add environment variables (copy from DEPLOYMENT_GUIDE.md Step 3.4)
8. Wait for deployment (~5 min)

---

## **Step 5: Get Your Live URL (2 min)**

1. Go to **Settings** → **Domains**
2. Click **Generate Domain**
3. Copy: `https://your-app.up.railway.app`
4. Open in browser ✅

---

## **Step 6: Enable Sleep Mode (1 min)**

1. Click your service → **Settings**
2. Enable **Sleep after 30 minutes**
3. Click **Save**

**DONE! Your app is now live and FREE! 🎉**

---

## **What You Get**

✅ Live Laravel app at `https://yourapp.up.railway.app`
✅ MySQL database (500MB free)
✅ Image hosting on Cloudinary (25GB free)
✅ HTTPS enabled automatically
✅ Auto-deploys on Git push
✅ **Monthly cost: $0** (within free tiers)

---

## **Need More Help?**

📖 **Full Guide:** Read [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
✅ **Checklist:** Use [DEPLOYMENT_CHECKLIST.md](DEPLOYMENT_CHECKLIST.md)
🖼️ **Code Changes:** Check [CLOUDINARY_INTEGRATION.md](CLOUDINARY_INTEGRATION.md)

---

**Total Time:** ~30 minutes
**Total Cost:** $0/month
**Status:** Production-ready ✅
