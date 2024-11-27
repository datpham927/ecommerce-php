# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy the current directory contents into the container
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader --prefer-dist

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]
