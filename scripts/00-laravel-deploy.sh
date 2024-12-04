#!/usr/bin/env bash

# Cài đặt dependencies Composer
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

# Cài đặt dependencies npm
npm install --prefix /var/www/html

# Build assets cho production
npm run build --prefix /var/www/html

# Cache cấu hình và routes
php artisan config:cache
php artisan route:cache

# Chạy migrations
php artisan migrate --force

# (Tuỳ chọn) Seed database nếu cần
php artisan db:seed --force

echo "Deployment completed successfully!"
