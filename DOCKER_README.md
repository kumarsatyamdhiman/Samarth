# ============================================
# Samarth App - Docker Deployment Guide
# ============================================

## Quick Start

### 1. Copy Environment File
```bash
cp .env.example .env
```

### 2. Start Docker Containers
```bash
docker-compose up -d --build
```

### 3. Install Dependencies & Setup
```bash
# Enter the app container
docker-compose exec app bash

# Inside the container:
composer install
npm ci
npm run build

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Exit container
exit
```

### 4. Access the App
- **URL**: http://localhost:8080
- **Login**: http://localhost:8080/login

## Commands

### Start Services
```bash
docker-compose up -d
```

### Stop Services
```bash
docker-compose down
```

### View Logs
```bash
docker-compose logs -f
```

### Restart Services
```bash
docker-compose restart
```

### Rebuild Containers
```bash
docker-compose up -d --build
```

### Access Database
```bash
docker-compose exec postgres psql -U postgres -d samarth
```

## Services Included

| Service    | Port  | Description           |
|------------|-------|-----------------------|
| Nginx      | 8080  | Web server            |
| PHP-FPM    | 9000  | PHP application       |
| PostgreSQL | 5432  | Database              |
| Redis      | 6379  | Cache (optional)      |

## Directory Structure

```
samarth/
├── Dockerfile
├── docker-compose.yml
├── docker/
│   └── nginx/
│       └── default.conf
├── .env.example
└── .env (create from example)
```

## Troubleshooting

### Database Connection Error
```bash
# Wait for PostgreSQL to be ready
docker-compose exec postgres pg_isready -U postgres

# Check database logs
docker-compose logs postgres
```

### Permission Issues
```bash
# Fix permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
```

### Clear Cache
```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

### Stop All Containers
```bash
docker-compose down -v
```

