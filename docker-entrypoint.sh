#!/bin/bash
set -e

echo "=== Starting Supply Chain Risk Platform ==="

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration warning (non-fatal)"

# Cache config, routes, views
echo "Caching config..."
php artisan config:cache || echo "Config cache warning"
php artisan route:cache || echo "Route cache warning"
php artisan view:cache || echo "View cache warning"

# Set storage link
php artisan storage:link || echo "Storage link warning"

echo "=== Starting PHP server on port ${PORT:-8000} ==="
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
