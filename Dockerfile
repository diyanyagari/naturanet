# Use FrankenPHP as the base image
FROM dunglas/frankenphp

# Install additional PHP extensions if needed
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && pecl install swoole \
    && docker-php-ext-enable swoole \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd intl pcntl

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy the entire Laravel project
COPY . .

# Set correct permissions
RUN chown -R www-data:www-data /app \
 && chmod -R 775 storage bootstrap/cache

# Install composer dependencies
RUN COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader

# Run Octane with FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=80"]
