#!/bin/bash
# SAMARTH Application - Server Setup Script
# Server: 103.133.214.97:9825
# Target: /home/udyogastra/public_html/Samarth
# URL: http://udyogastra.cequ.in

set -e
APP_DIR="/home/udyogastra/public_html/Samarth"
DB_DIR="$APP_DIR/database"

echo "Setting up SAMARTH application..."

# Create directories
mkdir -p "$APP_DIR"/{app,bootstrap,config,database,public,resources,routes,storage/framework/{sessions,views,cache},storage/logs,storage/app/public,vendor}
chmod -R 755 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"

# Create SQLite database
mkdir -p "$DB_DIR"
touch "$DB_DIR/database.sqlite"
chmod 666 "$DB_DIR/database.sqlite"

# Create .env file
cat > "$APP_DIR/.env" << 'ENV'
APP_NAME=SAMARTH
APP_ENV=production
APP_DEBUG=false
APP_URL=http://udyogastra.cequ.in
APP_KEY=base64:YourGeneratedKeyHere
DB_CONNECTION=sqlite
DB_DATABASE=/home/udyogastra/public_html/Samarth/database/database.sqlite
SESSION_DRIVER=file
CACHE_DRIVER=file
TIMEZONE=Asia/Kolkata
LOCALE=hi
ENV
chmod 640 "$APP_DIR/.env"

# Create .htaccess
cat > "$APP_DIR/public/.htaccess" << 'HTACCESS'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
<IfModule mod_autoindex.c>
    Options -Indexes
</IfModule>
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>
HTACCESS

echo "Setup complete!"
echo "Next steps after uploading files:"
echo "  cd $APP_DIR"
echo "  composer install --no-dev"
echo "  php artisan migrate --force"
echo "  php artisan db:seed --force"
echo "  php artisan config:cache"
