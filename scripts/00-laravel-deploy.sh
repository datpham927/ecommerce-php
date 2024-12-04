
# Copy source code vào container
COPY . /var/www/html
# Cài đặt quyền cho storage và cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cài đặt dependencies Composer
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

# Cài đặt Node.js và npm (tuỳ chọn, nếu cần)
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Cài đặt dependencies npm và build assets
RUN npm install --prefix /var/www/html
RUN npm run build --prefix /var/www/html

# Cache cấu hình và routes
RUN php /var/www/html/artisan config:cache
RUN php /var/www/html/artisan route:cache

# Chạy migrations (cần kiểm tra DB connection)
RUN php /var/www/html/artisan migrate --force

# Expose cổng cho Apache
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
