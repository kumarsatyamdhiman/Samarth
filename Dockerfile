# ============================================
# Samarth App - Render Production
# PHP 8.4 + Apache + Runtime Port Fix
# ============================================

FROM php:8.4-apache

# 1. Install System Dependencies (Debian-based)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    libpq-dev \
    curl \
    gnupg \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        zip \
        exif \
        pcntl \
        gd \
        bcmath \
        intl \
        mbstring \
        xml

# 2. Install Node.js v20 (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# 3. Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Enable Apache Rewrite Module
RUN a2enmod rewrite

# 5. Configure Apache Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Setup Application
WORKDIR /var/www/html

COPY composer.json composer.lock* ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

COPY package*.json ./
RUN npm ci

COPY . .

# 7. Build Assets
RUN npm run build && npm prune --production

# 8. Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. THE RUNTIME FIX
# We use a shell command to replace port 80 with $PORT (10000) RIGHT NOW as the app starts.
# Then we start Apache.
CMD ["/bin/bash", "-c", "sed -i \"s/80/$PORT/g\" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && php artisan config:cache && apache2-foreground"]
