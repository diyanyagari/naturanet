FROM php:8.3-fpm

# Dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd intl

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

RUN cp .env.example .env || touch .env && \
    mkdir -p bootstrap/cache storage/framework/{sessions,views,cache} && \
    chmod -R 775 bootstrap/cache storage && \
    chown -R www-data:www-data bootstrap storage bootstrap/cache

RUN mkdir -p /var/www/.composer && \
    chown -R www-data:www-data /var/www/.composer

USER root

RUN COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www
