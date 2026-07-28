#!/bin/bash
set -e

echo "=== Starting Supply Chain Risk Platform ==="
echo "APP_ENV: $APP_ENV"
echo "DB_HOST: $DB_HOST"
echo "PORT: $PORT"

# Clear any existing caches that might be stale
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# Run migrations (non-fatal if DB not ready)
echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "WARNING: Migration failed, continuing..."

# Storage link
php artisan storage:link 2>&1 || true

echo "=== Starting PHP server on port ${PORT:-8000} ==="
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
