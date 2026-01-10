# ============================================
# Samarth App - Render Production
# PHP 8.4 + Apache (Web Server) + Node 20
# ============================================

# 1. Use Apache base image (Fixes the "Port timeout" error)
FROM php:8.4-apache

# 2. Install System Dependencies
# We use standard apt-get (Debian) which avoids the "sqlite symbol" errors you saw in Alpine
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

# 3. Install Node.js v20 (LTS) correctly for Debian
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# 4. Clean up to keep image small
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 5. Enable Apache Rewrite Module (Required for Laravel routing)
RUN a2enmod rewrite

# 6. Configure Apache Document Root to /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 7. CRITICAL FIX: Bind Apache to Render's Dynamic Port
# Render assigns a random port (env var $PORT). We must tell Apache to listen on it.
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 8. Setup Application
WORKDIR /var/www/html

# --- Dependencies ---
COPY composer.json composer.lock* ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

COPY package*.json ./
RUN npm ci

# --- App Code & Build ---
COPY . .

# Build Vite Assets
RUN npm run build && npm prune --production

# Create .env from example (JSON storage mode)
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# --- Permissions ---
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Start Apache (Not FPM)
CMD ["apache2-foreground"]
