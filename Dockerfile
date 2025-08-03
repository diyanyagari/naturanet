FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd intl

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

# Create Laravel required folders with correct permissions
RUN mkdir -p bootstrap/cache \
    storage/framework/{sessions,views,cache} \
    storage/logs \
    /tmp/composer-cache \
    && chown -R www-data:www-data bootstrap storage /tmp/composer-cache \
    && chmod -R 775 bootstrap storage /tmp/composer-cache

RUN chown -R www-data:www-data /var/www

# Switch to www-data before running Composer
USER www-data

# RUN COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader

# Switch back to root to finalize file permissions
USER root
