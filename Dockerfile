FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && pecl install swoole \
    && docker-php-ext-enable swoole \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd intl

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source code
COPY . .

RUN chown -R www-data:www-data /var/www

# Switch to www-data before running Composer
USER www-data

RUN mkdir -p bootstrap/cache storage/framework/sessions
RUN mkdir -p bootstrap/cache storage/framework/views
RUN mkdir -p bootstrap/cache storage/framework/cache
RUN chmod -R 775 bootstrap/cache storage
RUN chown -R www-data:www-data bootstrap storage bootstrap/cache

RUN COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader

# Install Octane
RUN php artisan octane:install --no-interaction

# Switch back to root to finalize file permissions
USER root
