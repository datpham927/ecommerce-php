#!/usr/bin/env bash

# Cài đặt Composer
echo "Running composer..."
composer install --no-dev --working-dir=/var/www/html

# Cài đặt npm dependencies
echo "Installing npm dependencies..."
npm install --prefix /var/www/html 

# Build assets với Vite hoặc Laravel Mix
echo "Building assets..."
npm run build --prefix /var/www/html  # Sửa 'buil' thành 'build'

# Cache cấu hình
echo "Caching config..."
php artisan config:cache

# Cache routes
echo "Caching routes..."
php artisan route:cache

# Thực hiện migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database
echo "Seeding the database..."
php artisan db:seed

echo "Deployment completed successfully!"
