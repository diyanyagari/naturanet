#!/bin/sh
set -e

echo "🔧 Checking Laravel cache & storage directories..."
mkdir -p bootstrap/cache storage
chmod -R 775 bootstrap/cache storage

# Optional: cache config & routes for better performance
if [ -f artisan ]; then
    echo "⚡ Running Laravel config & route cache..."
    php artisan config:cache || true
    php artisan route:cache || true
fi

echo "✅ Laravel is ready."

exec "$@"
