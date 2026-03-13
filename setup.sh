#!/bin/bash
# ═══════════════════════════════════════════════
#  VaccTrack Setup Script
#  Run this once after cloning / extracting
# ═══════════════════════════════════════════════

set -e

echo ""
echo "  💉  VaccTrack — Pediatric Vaccine Tracker"
echo "  ─────────────────────────────────────────"
echo ""

# 1. Copy .env
if [ ! -f .env ]; then
  cp .env.example .env
  echo "  ✅ .env created"
fi

# 2. Install composer dependencies
echo "  📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Generate app key
echo "  🔑 Generating application key..."
php artisan key:generate

# 4. Create SQLite database
if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
  echo "  🗄️  SQLite database created"
fi

# 5. Run migrations
echo "  🏗️  Running database migrations..."
php artisan migrate --force

# 6. Seed the database
echo "  🌱 Seeding demo data..."
php artisan db:seed --force

# 7. Storage link
php artisan storage:link 2>/dev/null || true

echo ""
echo "  ═══════════════════════════════════════"
echo "  ✅  VaccTrack is ready!"
echo ""
echo "  Run:  php artisan serve"
echo "  Open: http://localhost:8000"
echo ""
echo "  Demo credentials:"
echo "  Doctor  → admin / admin"
echo "  Parent  → parent / parent"
echo "  ═══════════════════════════════════════"
echo ""
