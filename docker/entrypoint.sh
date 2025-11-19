#!/bin/bash
set -e

echo "Starting MindLink deployment..."

# Wait for database to be ready
echo "Waiting for database connection..."
max_attempts=30
attempt=0

until php artisan migrate:status 2>/dev/null || [ $attempt -eq $max_attempts ]; do
    attempt=$((attempt + 1))
    echo "Attempt $attempt/$max_attempts: Database not ready, waiting..."
    sleep 2
done

if [ $attempt -eq $max_attempts ]; then
    echo "Warning: Could not connect to database after $max_attempts attempts"
    echo "App will start but may not function correctly"
else
    echo "Database connection successful!"

    # Run migrations
    echo "Running database migrations..."
    php artisan migrate --force --no-interaction

    # Cache configuration
    echo "Caching configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Starting Apache server..."
exec apache2-foreground
