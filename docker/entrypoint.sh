#!/bin/bash
set -e

echo "Starting MindLink deployment..."

# Simple database connection check with timeout
echo "Testing database connection..."
timeout=60
elapsed=0

while [ $elapsed -lt $timeout ]; do
    if php -r "
        try {
            \$pdo = new PDO(
                'pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; then
        echo "✓ Database connection successful!"
        break
    fi

    echo "Waiting for database... (${elapsed}s/${timeout}s)"
    sleep 3
    elapsed=$((elapsed + 3))
done

if [ $elapsed -ge $timeout ]; then
    echo "⚠ Warning: Database connection timeout. Starting anyway..."
fi

# Run migrations (will create migrations table if it doesn't exist)
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Cache configuration
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✓ Application ready!"
echo "Starting Apache server..."
exec apache2-foreground
