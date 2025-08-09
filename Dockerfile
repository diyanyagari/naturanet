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

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Make sure Laravel cache & storage directories exist (during build)
RUN mkdir -p bootstrap/cache storage \
    && chmod -R 775 bootstrap/cache storage \
    && cp .env.example .env || true

# Validate and Install composer dependencies
RUN composer validate --no-check-publish && \
    COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --optimize-autoloader

# Use entrypoint script first
ENTRYPOINT ["/entrypoint.sh"]

# Run Octane with FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=80"]
