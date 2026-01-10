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
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    libpq-dev \
    curl \
    apache2-utils \
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
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 644 /var/www/html/public

# Apache listens on port 80
EXPOSE 80

# Use Apache as the main process
CMD ["apache2-foreground"]
