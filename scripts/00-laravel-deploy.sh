#!/usr/bin/env bash

# Cài đặt Composer
echo "Running composer..."
composer install --no-dev --working-dir=/var/www/html

# Cài đặt npm dependencies
echo "Installing npm dependencies..."
npm install --prefix /var/www/html

# Build assets cho production
echo "Building assets..."
npm run build --prefix /var/www/html

# Cache cấu hình
echo "Caching config..."
php artisan config:cache

# Cache routes
echo "Caching routes..."
php artisan route:cache

echo "Checking database connection..."
# Kiểm tra kết nối cơ sở dữ liệu và lưu lỗi vào biến
if php artisan migrate --pretend; then
    echo "Database connection is working."
else
    echo "Database connection failed!"
    # In ra thông báo lỗi trực tiếp từ stdout và stderr
    echo "Error: $(php artisan migrate --pretend 2>&1)"
    exit 1
fi
echo "Running migrations..."
php artisan migrate --force

echo "Seeding the database..."
 php artisan db:seed