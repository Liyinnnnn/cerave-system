#!/bin/bash

echo "🚀 CeraVe System - Railway Deployment Setup"
echo "==========================================="
echo ""

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer not found. Please install Composer first."
    exit 1
fi

echo "📦 Installing Cloudinary package..."
composer require cloudinary-labs/cloudinary-laravel

echo ""
echo "📝 Publishing Cloudinary configuration..."
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"

echo ""
echo "✅ Setup Complete!"
echo ""
echo "📋 Next Steps:"
echo "1. Add Cloudinary credentials to your .env file:"
echo "   CLOUDINARY_CLOUD_NAME=your_cloud_name"
echo "   CLOUDINARY_API_KEY=your_api_key"
echo "   CLOUDINARY_API_SECRET=your_api_secret"
echo ""
echo "2. Read DEPLOYMENT_GUIDE.md for complete Railway setup"
echo "3. Read CLOUDINARY_INTEGRATION.md for code modifications"
echo ""
echo "Happy deploying! 🎉"
