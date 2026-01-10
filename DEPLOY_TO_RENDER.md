# Deploy Samarth App to Render

## Quick Deploy Steps

### 1. Create Procfile
Create `Procfile` in project root:
```
web: php artisan serve --host=0.0.0.0 --port=$PORT
```

### 2. Prepare Local Files
```bash
# Install dependencies
composer install --optimize-autoloader

# Generate app key
php artisan key:generate

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Push to GitHub
```bash
git add .
git commit -m "Prepare for production"
git push origin main
```

### 4. Deploy on Render Dashboard

#### Option A: Manual Web Service
1. Go to [Render Dashboard](https://dashboard.render.com)
2. New → Web Service
3. Connect your GitHub repository
4. Configure:
   - **Build Command**: `composer install --no-dev --optimize-autoloader`
   - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`
   - **Environment**: PHP

#### Option B: Render Blueprint (Auto-deploy)
1. Create `render.yaml`:
```yaml
services:
  - type: web
    name: samarth-app
    env: php
    buildCommand: |
      composer install --no-dev --optimize-autoloader
      cp .env.example .env
    startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
```

### 5. Create PostgreSQL Database on Render
1. New → PostgreSQL
2. Note connection details
3. Add to environment variables

### 6. Environment Variables (Required)
Add in Render Dashboard → Your Service → Environment:

```env
APP_NAME=SAMARTH
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.onrender.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host.render.com
DB_PORT=5432
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 7. Run Migrations
In Render Shell or post-deploy command:
```bash
php artisan migrate --force
php artisan db:seed --force
```

## Update .env Example
Make sure you have `.env.example` with these fields:
```env
APP_NAME=SAMARTH
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=samarth
DB_USERNAME=postgres
DB_PASSWORD=
```

## Troubleshooting

### Error: "No application encryption key has been specified"
- Set `APP_KEY` in environment variables

### Error: "Connection refused"
- Check DB_HOST, DB_PORT, DB_DATABASE credentials

### Error: "Class not found"
- Run `composer dump-autoload`

### Static Assets Not Loading
- Run `npm install && npm run build` if using Vite
- Or add to Build Command: `npm ci && npm run build`

