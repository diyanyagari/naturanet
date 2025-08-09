# Use FrankenPHP as the base image
FROM dunglas/frankenphp

# Install additional PHP extensions if needed
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && pecl install swoole \
    && docker-php-ext-enable swoole \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd intl pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first (for caching dependencies)
COPY composer.json composer.lock ./

# Prepare cache & storage directories before composer install
RUN mkdir -p bootstrap/cache storage \
    && chown -R www-data:www-data bootstrap/cache storage \
    && chmod -R 775 bootstrap/cache storage

# Install dependencies without running artisan scripts
RUN composer validate --no-check-publish && \
    COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the Laravel application
COPY . .

# Set correct permissions again (in case files are overwritten)
RUN chown -R www-data:www-data bootstrap/cache storage \
    && chmod -R 775 bootstrap/cache storage

# Run artisan commands now that all files exist
# RUN php artisan package:discover --ansi

# Run Octane with FrankenPHP
ENTRYPOINT ["sh", "-c", "php artisan package:discover --ansi && php artisan octane:frankenphp --host=0.0.0.0 --port=80"]