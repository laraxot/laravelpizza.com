#!/bin/bash

# Script per risolvere automaticamente i conflitti Git rimanenti
# Aggiorna tutti i path per il progetto FixCity

echo "🔧 Risoluzione automatica conflitti Git..."

# Trova tutti i file con conflitti

if [ -z "$CONFLICT_FILES" ]; then
    echo "✅ Nessun conflitto trovato!"
    exit 0
fi

echo "📋 File con conflitti trovati:"
echo "$CONFLICT_FILES"
echo ""

# Contatore
count=0
total=$(echo "$CONFLICT_FILES" | wc -l)

for file in $CONFLICT_FILES; do
    count=$((count + 1))
    echo "[$count/$total] 🔧 Risolvendo: $file"
    
    # Backup del file originale
    cp "$file" "$file.backup"
    
    # Risolvi conflitti comuni
    
    # Aggiorna path specifici per FixCity
    sed -i 's|/var/www/html/ptvx|/var/www/html/_bases/base_fixcity_fila5_mono|g' "$file"
    sed -i 's|/var/www/html/_bases/base_ptvx_fila5_mono|/var/www/html/_bases/base_fixcity_fila5_mono|g' "$file"
    sed -i 's|base_ptvx_fila5_mono|base_fixcity_fila5_mono|g' "$file"
    sed -i 's|ptvx|fixcity|g' "$file"
    
    # Rimuovi righe duplicate
    awk '!seen[$0]++' "$file" > "$file.tmp" && mv "$file.tmp" "$file"
    
    echo "✅ Completato: $file"
done

echo ""
echo "🎉 Risoluzione completata!"
echo "📊 File processati: $total"
echo ""
echo "⚠️  IMPORTANTE: Verifica manualmente i file modificati prima di committare!"
echo "💡 Usa 'git diff' per controllare le modifiche"
