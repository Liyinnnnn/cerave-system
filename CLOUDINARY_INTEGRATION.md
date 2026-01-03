# 🖼️ Cloudinary Integration Guide

## Code Changes Required for File Uploads

After deploying to Railway, your current file upload system (using `public/images`) won't work because Railway has **ephemeral storage**. This guide shows you what code changes are needed to use Cloudinary instead.

---

## **Installation Steps**

### 1. Install Cloudinary Package

```bash
composer require cloudinary-labs/cloudinary-laravel
```

### 2. Publish Config

```bash
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"
```

This creates `config/cloudinary.php`

### 3. Update .env

Add these to your `.env`:
```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

---

## **Code Modifications Needed**

### File 1: ProductController.php - store() method

**Current code (local storage):**
```php
// Retailer logos upload
if ($request->hasFile('retailer_logos')) {
    foreach ($request->file('retailer_logos') as $index => $logo) {
        if ($logo) {
            $logoPath = $logo->store('retailer_logos', 'public');
            $retailerLogos[] = $logoPath;
        }
    }
}
```

**New code (Cloudinary):**
```php
// Retailer logos upload to Cloudinary
if ($request->hasFile('retailer_logos')) {
    foreach ($request->file('retailer_logos') as $index => $logo) {
        if ($logo) {
            $uploadedFileUrl = cloudinary()->upload($logo->getRealPath(), [
                'folder' => 'cerave/retailer_logos',
                'transformation' => [
                    'width' => 300,
                    'height' => 100,
                    'crop' => 'fit'
                ]
            ])->getSecurePath();
            $retailerLogos[] = $uploadedFileUrl;
        }
    }
}
```

### File 2: ProductController.php - update() method

**Add this for logo updates:**
```php
// Update retailer logos
if ($request->hasFile('retailer_logos')) {
    $newLogos = [];
    foreach ($request->file('retailer_logos') as $index => $logo) {
        if ($logo) {
            $uploadedFileUrl = cloudinary()->upload($logo->getRealPath(), [
                'folder' => 'cerave/retailer_logos'
            ])->getSecurePath();
            $newLogos[] = $uploadedFileUrl;
        } else if (isset($existingLogos[$index])) {
            $newLogos[] = $existingLogos[$index];
        }
    }
    $retailerLogos = array_merge($existingLogos, $newLogos);
}
```

---

## **Image Display**

### Current (local paths):
```blade
<img src="{{ asset('storage/' . $logo) }}" alt="Logo">
```

### New (Cloudinary URLs):
```blade
<img src="{{ $logo }}" alt="Logo">
```

Cloudinary returns full HTTPS URLs, so no `asset()` helper needed!

---

## **Benefits of Cloudinary**

✅ **Automatic image optimization** - Faster loading
✅ **CDN delivery** - Images served from nearest location
✅ **Transformations** - Resize/crop on-the-fly
✅ **Persistent storage** - Never lose files on Railway redeploy
✅ **Free tier** - 25GB storage + bandwidth

---

## **Image Transformations**

Cloudinary allows URL-based transformations:

```blade
{{-- Original image --}}
<img src="{{ $product->image }}" alt="Product">

{{-- Thumbnail (200x200) --}}
<img src="{{ cloudinary()->getImage($product->image)
    ->resize(Resize::fill()->width(200)->height(200)) }}" 
    alt="Thumbnail">

{{-- Optimized for web --}}
<img src="{{ cloudinary()->getImage($product->image)
    ->format('auto')
    ->quality('auto') }}" 
    alt="Optimized">
```

---

## **Migration Strategy**

### For existing local images:

1. **Upload to Cloudinary programmatically:**

```php
// Run this once to migrate existing images
php artisan tinker

Product::all()->each(function ($product) {
    if ($product->images) {
        $newImages = [];
        foreach ($product->images as $imagePath) {
            $localPath = public_path($imagePath);
            if (file_exists($localPath)) {
                $uploaded = cloudinary()->upload($localPath, [
                    'folder' => 'cerave/products'
                ]);
                $newImages[] = $uploaded->getSecurePath();
            }
        }
        $product->update(['images' => $newImages]);
    }
});
```

2. **Or manually re-upload via admin panel**

---

## **Testing Cloudinary Integration**

1. Create a test product with image
2. Check Railway logs for upload success
3. Verify image URL starts with `https://res.cloudinary.com`
4. Test image displays correctly on frontend

---

## **Troubleshooting**

### Images not uploading:
- Check Cloudinary credentials in .env
- Verify unsigned preset is enabled
- Check file size limits (10MB default)

### Images not displaying:
- Verify URL is HTTPS not HTTP
- Check browser console for CORS errors
- Test URL directly in browser

---

## **Free Tier Limits**

Monitor usage at: https://cloudinary.com/console

```
Storage: 25 GB (plenty for 1000+ products)
Bandwidth: 25 GB/month (10,000+ pageviews)
Transformations: 25,000/month
```

You'll be well within free limits! 🎉

---

## **After Installation**

Once you've made these code changes:

1. Test locally first
2. Commit to GitHub
3. Railway will auto-deploy
4. Test image uploads on live site

---

**Need help?** Check the full deployment guide in `DEPLOYMENT_GUIDE.md`
