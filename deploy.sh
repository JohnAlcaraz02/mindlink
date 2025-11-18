#!/bin/bash

# MindLink Deployment Helper Script
# This script helps prepare your application for deployment

echo "🚀 MindLink Deployment Helper"
echo "=============================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ .env file not found!"
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo "✅ .env file created. Please configure it before deploying."
    exit 1
fi

# Check if APP_KEY is set
if grep -q "APP_KEY=$" .env || ! grep -q "APP_KEY=" .env; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate
    echo "✅ APP_KEY generated"
else
    echo "✅ APP_KEY already set"
fi

# Install dependencies
echo ""
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction
echo "✅ Dependencies installed"

# Clear and cache config
echo ""
echo "⚙️  Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Application optimized"

# Check database connection
echo ""
echo "🗄️  Checking database connection..."
php artisan migrate:status
if [ $? -eq 0 ]; then
    echo "✅ Database connection successful"

    read -p "Run migrations? (y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        php artisan migrate --force
        echo "✅ Migrations completed"
    fi
else
    echo "❌ Database connection failed. Please check your .env database settings."
fi

echo ""
echo "=============================="
echo "✅ Deployment preparation complete!"
echo ""
echo "Next steps:"
echo "1. Commit your changes: git add . && git commit -m 'Prepare for deployment'"
echo "2. Push to your repository: git push origin main"
echo "3. Follow the DEPLOYMENT.md guide for your chosen platform"
echo ""
