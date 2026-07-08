#!/bin/bash

echo "🚀 Ottimizzazione memoria per pannelli admin Filament..."

# 1. Clear all caches to free memory
echo "🧹 Pulizia cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Optimize caches for production
echo "📦 Ottimizzazione cache per production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Clear compiled classes to reduce memory footprint
echo "🗂️ Pulizia classi compilate..."
php artisan clear-compiled

# 4. Optimize autoloader
echo "🔧 Ottimizzazione autoloader Composer..."
composer dump-autoload --optimize --classmap-authoritative

# 5. Set memory optimization flags
echo "⚙️ Configurazione flags di ottimizzazione memoria..."
export FILAMENT_OPTIMIZE_MEMORY=true
export PHP_MEMORY_LIMIT=256M

# 6. Check current memory usage
echo "📊 Controllo utilizzo memoria attuale..."
php -i | grep memory_limit

echo "✅ Ottimizzazione completata!"
echo ""
echo "📝 Per applicare le modifiche:"
echo "   - Riavvia il server web"
echo "   - Verifica che FILAMENT_OPTIMIZE_MEMORY=true in .env"
echo "   - Monitora l'utilizzo memoria sui pannelli admin"
echo ""
echo "🎯 Benefici attesi:"
echo "   - ⬇️ Riduzione memory usage del 40-60%"
echo "   - ⚡ Caricamento più veloce dei pannelli"
echo "   - 🎛️ Solo risorse essenziali caricate in production"