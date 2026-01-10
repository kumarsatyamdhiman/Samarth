# ============================================
# Samarth App - Render Production - FINAL FIX
# PHP 8.2 + Apache + Inline Config + Port Fix
# ============================================

FROM php:8.2-apache-bookworm

# 1. Install Dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev libpq-dev curl gnupg \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip exif pcntl gd bcmath intl mbstring xml

# 2. Install Node.js v20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# 3. Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Enable Rewrite
RUN a2enmod rewrite

# 5. CONFIGURE APACHE (The "Index.php Not Found" Fix)
# We delete the default config and write a new one pointing explicitly to /public
# We use 'echo' so we don't need external files.
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Options Indexes FollowSymLinks' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# 6. Setup App
WORKDIR /var/www/html

COPY composer.json composer.lock* ./
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

COPY package*.json ./
RUN npm ci

COPY . .

# 7. Build Assets
RUN npm run build && npm prune --production

# 8. Permissions (Corrected)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. STARTUP COMMAND (The Port Fix)
# This replaces port 80 with the Render $PORT variable right before the server starts.
CMD ["/bin/bash", "-c", "sed -i \"s/80/$PORT/g\" /etc/apache2/sites-available/000-default.conf && sed -i \"s/80/$PORT/g\" /etc/apache2/ports.conf && php artisan config:cache && apache2-foreground"]
