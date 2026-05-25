#!/bin/bash
# Deploy script — jalankan di VPS: bash deploy.sh

set -e

APP_DIR="/var/www/lsp-edukia"
cd "$APP_DIR"

echo "→ Masuk maintenance mode..."
php artisan down --retry=60

echo "→ Pull kode terbaru..."
git pull origin main

echo "→ Install composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "→ Jalankan migrasi..."
php artisan migrate --force

echo "→ Clear & rebuild cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "→ Set permissions..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 755 storage bootstrap/cache

echo "→ Keluar maintenance mode..."
php artisan up

echo "✓ Deploy selesai!"
