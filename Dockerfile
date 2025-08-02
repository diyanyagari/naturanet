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

RUN mkdir -p bootstrap/cache && \
    mkdir -p storage/framework/{sessions,views,cache} && \
    chmod -R 775 bootstrap/cache storage

RUN cp .env.example .env

# Install Laravel deps
RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:clear

# Set permissions (opsional, tergantung config kamu)
RUN chown -R www-data:www-data /var/www
