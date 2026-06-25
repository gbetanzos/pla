#!/usr/bin/env bash

set -e

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$APP_DIR"

echo "=========================================="
echo "  Shopping List App Setup Script"
echo "=========================================="
echo ""

# 1. Install Composer dependencies
echo "[1/8] Installing Composer dependencies..."
composer install

# 2. Generate application key
echo "[2/8] Generating application key..."
php artisan key:generate

# 3. Copy .env.demo if it exists
echo "[3/8] Setting up environment..."
if [[ -f ".env.demo" ]]; then
    cp .env.demo .env
else
    # Use existing .env or create default
    if [[ ! -f ".env" ]]; then
        cp .env.example .env 2>/dev/null || php artisan env:make
    fi
fi

# 4. Set database configuration
echo "[4/8] Configuring SQLite database..."
mkdir -p database
if [[ ! -f "database.sqlite" ]]; then
    touch database.sqlite
    echo "Created: database/database.sqlite"
fi

# 5. Run migrations
echo "[5/8] Running migrations..."
php artisan migrate:fresh --drop-views --force

# 6. Seed database
echo "[6/8] Seeding database..."
php artisan db:seed --class=ProductSeeder

# 7. Run storage:link
echo "[7/8] Creating storage link..."
php artisan storage:link

# 8. Clear caches
echo "[8/8] Clearing caches..."
php artisan config:clear && php artisan route:clear && php artisan view:clear

echo ""
echo "=========================================="
echo "  Setup Complete!"
echo "=========================================="
echo ""
echo "Database: database.sqlite"
echo "URL:      http://localhost:8000"
echo ""
echo "To start the server:"
echo "  php artisan serve --host=0.0.0.0 --port=8000"
echo ""
echo "To run tests:"
echo "  php artisan test"
echo ""
