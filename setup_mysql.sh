#!/bin/bash

# ============================================
# Samarth App - MySQL Setup Script
# For 1000+ users scalability
# ============================================

set -e

echo "🚀 Setting up Samarth App with MySQL..."
echo "========================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if .env exists, if not copy from .env.example
if [ ! -f .env ]; then
    echo -e "${YELLOW}📄 Creating .env file from .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓ .env file created${NC}"
else
    echo -e "${YELLOW}⚠️  .env file already exists, skipping...${NC}"
fi

# Generate app key if not set
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo -e "${YELLOW}🔑 Generating APP_KEY...${NC}"
    php artisan key:generate --force
    echo -e "${GREEN}✓ APP_KEY generated${NC}"
fi

# Clear all caches
echo -e "${YELLOW}🧹 Clearing caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
echo -e "${GREEN}✓ Caches cleared${NC}"

# Run migrations with MySQL
echo -e "${YELLOW}📊 Running database migrations...${NC}"
php artisan migrate --force
echo -e "${GREEN}✓ Migrations completed${NC}"

# Seed the database
echo -e "${YELLOW}🌱 Seeding database...${NC}"
php artisan db:seed --force
echo -e "${GREEN}✓ Database seeded${NC}"

# Optimize the application
echo -e "${YELLOW}⚡ Optimizing application...${NC}"
php artisan optimize:clear
php artisan optimize
echo -e "${GREEN}✓ Application optimized${NC}"

echo ""
echo "========================================"
echo -e "${GREEN}✅ MySQL Setup Complete!${NC}"
echo "========================================"
echo ""
echo "📝 Next steps:"
echo "   1. Start MySQL container: docker-compose up -d mysql"
echo "   2. Start the app: docker-compose up -d app"
echo "   3. Access at: http://localhost:8080"
echo ""
echo "🗄️  MySQL Connection Details:"
echo "   Host: localhost:3306"
echo "   Database: samarth"
echo "   Username: samarth"
echo "   Password: samarth_pass"
echo ""

