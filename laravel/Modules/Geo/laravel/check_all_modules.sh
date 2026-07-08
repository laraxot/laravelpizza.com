#!/bin/bash

cd /var/www/_bases/base_ptvx_fila5_mono/laravel

modules=(
    "ContoAnnuale" "DbForge" "Europa" "Gdpr" "Inail" "Incentivi"
    "IndennitaCondizioniLavoro" "IndennitaResponsabilita" "Job" "Lang"
    "Legge104" "Legge109" "Media" "Mensa" "MobilitaVolontaria" "Notify"
    "Performance" "Prenotazioni" "PresenzeAssenze" "Progressioni" "Ptv"
    "Questionari" "Rating" "Setting" "Sigma" "Sindacati" "Tenant" "UI" "User" "Xot"
)

echo "Starting PHPStan analysis of all modules..."
echo "============================================"

for module in "${modules[@]}"; do
    echo ""
    echo "=== Analyzing $module ==="
    result=$(php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/$module --error-format=table 2>&1)
    
    if echo "$result" | grep -q "\[OK\] No errors"; then
        echo "✓ $module: OK"
    else
        echo "✗ $module: ERRORS FOUND"
        echo "$result" | grep -A 20 "Error"
    fi
done

echo ""
echo "============================================"
echo "Analysis complete!"
