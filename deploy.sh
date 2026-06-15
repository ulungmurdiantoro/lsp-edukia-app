#!/bin/bash
# Deploy script — jalankan di VPS: bash deploy.sh

set -e

APP_DIR="/var/www/lsp-edukia"
REPO="https://github.com/ulungmurdiantoro/lsp-edukia-app.git"

# ── First-time setup ──────────────────────────────────────────────────────────
if [ ! -d "$APP_DIR/.git" ]; then
    echo "→ Clone repo pertama kali..."
    sudo mkdir -p "$APP_DIR"
    sudo chown -R $USER:$USER "$APP_DIR"
    git clone "$REPO" "$APP_DIR"
    cd "$APP_DIR"

    echo "→ Buat .env dari template..."
    cp .env.production.example .env
    echo ""
    echo "! Edit .env sekarang (isi APP_KEY, DB, dll) lalu tekan Enter untuk lanjut."
    read -r
    php artisan key:generate
    php artisan storage:link
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    # Owner = user deploy (bisa jalankan artisan), grup = www-data (web server bisa tulis).
    sudo chown -R $USER:www-data "$APP_DIR"
    sudo chmod -R 2775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
    echo "✓ Setup pertama selesai!"
    exit 0
fi

# ── Update / re-deploy ────────────────────────────────────────────────────────
cd "$APP_DIR"

echo "→ Masuk maintenance mode..."
php artisan down --retry=60

echo "→ Pull kode terbaru dari GitHub..."
git pull origin main

echo "→ Install composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "→ Jalankan migrasi..."
php artisan migrate --force

echo "→ Set permissions (ambil-alih kepemilikan sebelum kelola cache)..."
# Owner = user deploy (bisa jalankan artisan & hapus cache), grup = www-data (web server bisa tulis).
# 2775 = setgid + izin tulis grup, agar file baru tetap milik grup www-data.
# WAJIB sebelum cache:clear agar file cache buatan www-data bisa dihapus oleh user deploy.
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 2775 storage bootstrap/cache

echo "→ Clear & rebuild cache..."
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "→ Keluar maintenance mode..."
php artisan up

echo "✓ Deploy selesai!"
