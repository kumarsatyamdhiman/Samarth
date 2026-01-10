# ============================================
# Samarth App - CEQU Labs Production (Render)
# PHP 8.2 + Laravel 12 + JSON File Storage + Vite + Apache
# ============================================

FROM php:8.2-apache-bookworm

# Install system dependencies + PHP extensions + Apache
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
    apache2-utils \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
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

# Install Node.js v20 (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite and configure Document Root to /public
# Note: PHP module is already enabled by default in php:8.2-apache image
RUN a2enmod rewrite

# Copy custom Apache configuration
COPY docker/apache2.conf /etc/apache2/apache2.conf

# Set proper permissions
RUN chmod 644 /etc/apache2/apache2.conf

# Verify installations
RUN node --version && npm --version && php --version && apachectl -v

# Setup Application
WORKDIR /var/www/html

# Install PHP dependencies
COPY composer.json composer.lock* ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Install JS dependencies
COPY package*.json ./
RUN npm ci

# Copy application code
COPY . .

# Build assets
RUN npm run build && npm prune --production

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 644 /var/www/html/public

# Apache listens on port 80
EXPOSE 80

# Use Apache as the main process
CMD ["apache2-foreground"]

