FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd intl

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

# Set up Laravel required directories
RUN cp .env.example .env || touch .env && \
    mkdir -p bootstrap/cache \
    storage/framework/{sessions,views,cache} \
    storage/logs \
    && chown -R www-data:www-data bootstrap storage \
    && chmod -R 775 bootstrap storage

# Set writable cache directory for composer (optional, to avoid warnings)
RUN mkdir -p /var/www/.composer && \
    chown -R www-data:www-data /var/www/.composer

# Use correct user and run composer install
USER www-data

RUN COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader

# Ensure Laravel has proper ownership
USER root
RUN chown -R www-data:www-data /var/www
