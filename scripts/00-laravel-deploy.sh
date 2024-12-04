#!/usr/bin/env bash

# Cài đặt Composer
echo "Running composer..."
composer install --no-dev --working-dir=/var/www/html

# Cài đặt npm dependencies
echo "Installing npm dependencies..."
npm install --prefix /var/www/html 
echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force 


echo "Seeding the database..."
 php artisan db:seed