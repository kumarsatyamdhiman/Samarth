# ============================================
# Samarth App - CEQU Labs Production (Render)
# PHP 8.4 + Laravel 12 + JSON File Storage + Vite + Apache
# ============================================

FROM php:8.4-apache-alpine3.20

# Install system dependencies + PHP extensions + Apache
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
    sqlite-libs \
    sqlite-dev \
    curl \
    apache2-utils \
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

# Enable Apache mod_rewrite and PHP modules
RUN a2enmod rewrite \
    && a2enmod php8 \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/httpd.conf \
    && sed -i 's|DocumentRoot "/var/www/html"|DocumentRoot "/var/www/html/public"|g' /etc/apache2/httpd.conf \
    && echo "<Directory \"/var/www/html/public\">" >> /etc/apache2/httpd.conf \
    && echo "    Options Indexes FollowSymLinks" >> /etc/apache2/httpd.conf \
    && echo "    AllowOverride All" >> /etc/apache2/httpd.conf \
    && echo "    Require all granted" >> /etc/apache2/httpd.conf \
    && echo "</Directory>" >> /etc/apache2/httpd.conf

# Verify installations
RUN node --version && npm --version && php --version && apachectl -v

WORKDIR /var/www/html

# --- 1. PHP Dependencies ---
COPY composer.json composer.lock* ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# --- 2. JS Dependencies ---
COPY package*.json ./
RUN npm ci

# --- 3. Copy Application Code ---
COPY . .

# --- 4. Setup Laravel ---
# Create .env from example if not exists
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Note: No database migrations needed - app uses JSON file storage
# Note: Skipping php artisan cache commands as they require database connection

# Build assets
RUN npm run build \
    && npm prune --production

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 644 /var/www/html/public

# Apache listens on port 80
EXPOSE 80

# Use Apache as the main process
CMD ["apache2-foreground"]
