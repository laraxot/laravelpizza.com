#!/bin/bash

# Script per aggiornare tutti i file Pest.php con DatabaseTransactions
echo "🔧 Aggiornamento file Pest.php con DatabaseTransactions..."

# Lista dei file Pest.php da aggiornare
PEST_FILES=(
    "Modules/Cms/tests/Pest.php"
    "Modules/Employee/tests/Pest.php"
    "Modules/Gdpr/tests/Pest.php"
    "Modules/Geo/tests/Pest.php"
    "Modules/Lang/tests/Pest.php"
    "Modules/Media/tests/Pest.php"
    "Modules/Notify/tests/Pest.php"
    "Modules/<nome progetto>/tests/Pest.php"
    "Modules/Tenant/tests/Pest.php"
    "Modules/UI/tests/Pest.php"
    "Modules/Xot/tests/Pest.php"
)

for file in "${PEST_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "📄 Aggiornando: $file"
        
        # Backup
        cp "$file" "$file.backup.$(date +%Y%m%d_%H%M%S)"
        
        # Sostituisci pest()->extend con uses()
        sed -i 's/pest()->extend(TestCase::class)/uses(TestCase::class)/g' "$file"
        
        # Aggiungi DatabaseTransactions dopo TestCase
        sed -i '/uses(TestCase::class)/a\    ->uses(\\Illuminate\\Foundation\\Testing\\DatabaseTransactions::class)' "$file"
        
        echo "  ✅ Aggiornato"
    else
        echo "  ⚠️  File non trovato: $file"
    fi
done

echo "✨ Aggiornamento Pest.php completato!"
