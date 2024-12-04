#!/usr/bin/env bash

# Thiết lập quyền cho storage và cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cài đặt dependencies Composer
if ! composer install --no-dev --optimize-autoloader --working-dir=/var/www/html; then
    echo "Composer install failed!"
    exit 1
fi

# Cài đặt dependencies npm
if ! npm install --prefix /var/www/html; then
    echo "NPM install failed!"
    exit 1
fi

# Build assets cho production
if ! npm run build --prefix /var/www/html; then
    echo "NPM build failed!"
    exit 1
fi

# Cache cấu hình và routes
php artisan config:cache
php artisan route:cache

# Chạy migrations
if ! php artisan migrate --force; then
    echo "Database migration failed!"
    exit 1
fi

# (Tuỳ chọn) Seed database nếu cần
if ! php artisan db:seed --force; then
    echo "Database seeding failed!"
    exit 1
fi

echo "Deployment completed successfully!"
