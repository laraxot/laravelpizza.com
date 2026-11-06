#!/bin/bash

# Script per verificare la riusabilità dei moduli Laraxot
# Identifica hardcoding di nomi progetti nei moduli riutilizzabili

set -e

REUSABLE_MODULES=("Notify" "User" "Xot" "UI" "Cms" "Blog" "Geo")
PROJECT_NAMES=("<nome progetto>" "<nome progetto>" "dentalpro")
LARAVEL_DIR="/var/www/html/_bases/base_<nome progetto>/laravel"

echo "🔍 Controllo riusabilità moduli Laraxot..."
echo "============================================"

ERRORS_FOUND=0

for module in "${REUSABLE_MODULES[@]}"; do
    MODULE_PATH="$LARAVEL_DIR/Modules/$module"
    
    if [ ! -d "$MODULE_PATH" ]; then
        echo "⚠️  Modulo $module non trovato in $MODULE_PATH"
        continue
    fi
    
    echo "📦 Controllo modulo: $module"
    echo "   Path: $MODULE_PATH"
    
    # Controlla hardcoding di nomi progetti
    for project in "${PROJECT_NAMES[@]}"; do
        FOUND=$(grep -r -i "$project" "$MODULE_PATH" --include="*.php" --include="*.md" --exclude-dir=vendor 2>/dev/null | wc -l)
        
        if [ "$FOUND" -gt 0 ]; then
            echo "   ❌ Trovate $FOUND occorrenze di '$project':"
            grep -r -i "$project" "$MODULE_PATH" --include="*.php" --include="*.md" --exclude-dir=vendor | head -5
            echo "   ..."
            ERRORS_FOUND=$((ERRORS_FOUND + 1))
        fi
    done
    
    # Controlla import diretti da progetti specifici
    DIRECT_IMPORTS=$(grep -r "use Modules\\\\[^N][^o][^t][^i][^f][^y]\\\\[^X][^o][^t]\\\\[^U][^I]" "$MODULE_PATH" --include="*.php" 2>/dev/null | wc -l)
    
    if [ "$DIRECT_IMPORTS" -gt 0 ]; then
        echo "   ❌ Trovati $DIRECT_IMPORTS import diretti da altri moduli:"
        grep -r "use Modules\\\\[^N][^o][^t][^i][^f][^y]\\\\[^X][^o][^t]\\\\[^U][^I]" "$MODULE_PATH" --include="*.php" | head -3
        ERRORS_FOUND=$((ERRORS_FOUND + 1))
    fi
    
    # Controlla utilizzo User:: senza XotData
    USER_HARDCODED=$(grep -r "User::" "$MODULE_PATH" --include="*.php" | grep -v "XotData" | wc -l)
    
    if [ "$USER_HARDCODED" -gt 0 ]; then
        echo "   ❌ Trovate $USER_HARDCODED occorrenze di User:: senza XotData"
        ERRORS_FOUND=$((ERRORS_FOUND + 1))
    fi
    
    if [ "$ERRORS_FOUND" -eq 0 ]; then
        echo "   ✅ Modulo $module è riutilizzabile"
    fi
    
    echo ""
done

echo "============================================"

if [ "$ERRORS_FOUND" -eq 0 ]; then
    echo "🎉 Tutti i moduli riutilizzabili sono project-agnostic!"
    exit 0
else
    echo "❌ Trovati $ERRORS_FOUND problemi di riusabilità"
    echo ""
    echo "📋 Azioni richieste:"
    echo "1. Sostituire hardcoding con pattern dinamici"
    echo "2. Utilizzare XotData::make()->getUserClass() per la classe User"
    echo "3. Utilizzare config('app.name') e config('app.domain')"
    echo "4. Aggiornare documentazione per riflettere le correzioni"
    echo ""
    echo "📖 Guida: /docs/module_reusability_guidelines.md"
    exit 1
fi
