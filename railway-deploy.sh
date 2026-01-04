#!/bin/bash
set -e

echo "🚀 Starting Railway Deployment..."

# Cache config and routes FIRST (doesn't need DB)
echo "⚙️  Caching configuration..."
php artisan config:cache

echo "🛣️  Caching routes..."
php artisan route:cache

echo "👀 Caching views..."
php artisan view:cache

echo "📦 Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Try migrations but don't fail if they can't connect yet
echo "🗄️  Running migrations (if database is ready)..."
php artisan migrate --force 2>/dev/null || echo "⚠️  Database not ready yet (this is OK, will retry on startup)"

echo "✅ Deployment preparation complete!"
