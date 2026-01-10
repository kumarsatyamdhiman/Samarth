# ============================================
# Samarth App - CEQU Labs Production (Render)
# PHP 8.4 + Laravel 12 + PostgreSQL/MySQL + Vite
# ============================================

FROM php:8.4-fpm-alpine3.20

# Install system dependencies + PHP extensions
# Use Alpine community repository for compatible Node.js version
RUN apk add --no-cache --repository=http://dl-cdn.alpinelinux.org/alpine/v3.20/community \
    git \
    unzip \
    $PHPIZE_DEPS \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    curl-dev \
    oniguruma-dev \
    postgresql-dev \
    freetype-dev \
    libxml2-dev \
    # Node.js from community repo
    nodejs \
    npm \
    sqlite \
    sqlite-dev \
    curl \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        zip \
        exif \
        pcntl \
        gd \
        curl \
        mbstring \
        xml \
        intl \
        bcmath \
    && apk del $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

# Verify installations
RUN node --version && npm --version && php --version

WORKDIR /var/www/html

# --- 1. PHP Dependencies ---
COPY composer.json composer.lock* ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# --- 2. JS Dependencies ---
COPY package*.json ./
# Only install dependencies here (using cache)
RUN npm ci

# --- 3. Copy Application Code ---
COPY . .

# --- 4. Setup Laravel ---
# Create .env from example if not exists
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Run migrations and seeders
RUN php artisan migrate --force --seed

# Clear all caches
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan cache:clear

# Build assets
RUN npm run build \
    && npm prune --production

# Recache configurations for production
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage

EXPOSE 9000

CMD ["php-fpm"]

