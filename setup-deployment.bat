@echo off
echo ============================================
echo   CeraVe System - Railway Deployment Setup
echo ============================================
echo.

REM Check if composer is installed
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Composer not found. Please install Composer first.
    pause
    exit /b 1
)

echo [1/2] Installing Cloudinary package...
call composer require cloudinary-labs/cloudinary-laravel

echo.
echo [2/2] Publishing Cloudinary configuration...
call php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"

echo.
echo ============================================
echo   Setup Complete!
echo ============================================
echo.
echo Next Steps:
echo.
echo 1. Add Cloudinary credentials to your .env file:
echo    CLOUDINARY_CLOUD_NAME=your_cloud_name
echo    CLOUDINARY_API_KEY=your_api_key
echo    CLOUDINARY_API_SECRET=your_api_secret
echo.
echo 2. Read DEPLOYMENT_GUIDE.md for complete Railway setup
echo 3. Read CLOUDINARY_INTEGRATION.md for code modifications
echo.
echo Happy deploying!
echo.
pause
