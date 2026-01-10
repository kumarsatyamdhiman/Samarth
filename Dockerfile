# ============================================
# Samarth App - Docker Configuration
# ============================================

# Use PHP 8.2 as base image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    zip \
    postgresql-dev \
    nodejs \
    npm \
    curl \
    && docker-php-ext-install \
    zip \
    pdo \
    pdo_pgsql \
    pcntl \
    && npm install -g npm@latest

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock* ./

# Install Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Install NPM dependencies and build assets
RUN npm ci --only=production && npm run build

# Run Laravel optimization commands
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port 9000 (PHP-FPM)
EXPOSE 9000

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start PHP-FPM
CMD ["php-fpm"]

