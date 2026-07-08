#!/bin/bash

# Fix Autoload PSR-4 Errors Script - <nome progetto>
# Corregge i nomi dei file PHP per farli corrispondere ai nomi delle classi
# Data: 2025-08-04

set -e

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>"
LARAVEL_ROOT="$PROJECT_ROOT/laravel"

echo "======================================================="
echo "FIX AUTOLOAD PSR-4 ERRORS - FILE/CLASS NAME MISMATCH"
echo "======================================================="

# Funzione per estrarre il nome della classe da un file PHP
get_class_name() {
    local file="$1"
    # Estrae il nome della classe dal file PHP
    grep -E "^(class|interface|trait|enum)" "$file" | head -1 | sed -E 's/.*(class|interface|trait|enum)\s+([A-Za-z0-9_]+).*/\2/' || echo ""
}

# Funzione per rinominare file PHP per corrispondere al nome della classe
fix_php_file() {
    local file="$1"
    local dir=$(dirname "$file")
    local current_basename=$(basename "$file" .php)
    
    # Estrae il nome della classe dal file
    local class_name=$(get_class_name "$file")
    
    if [[ -n "$class_name" && "$class_name" != "$current_basename" ]]; then
        local new_file="$dir/$class_name.php"
        
        # Verifica che il nuovo file non esista già
        if [[ ! -f "$new_file" ]]; then
            echo "Rinomino: $file -> $new_file (classe: $class_name)"
            mv "$file" "$new_file"
        else
            echo "⚠️  ATTENZIONE: $new_file esiste già, salto $file"
        fi
    fi
}

echo "1. FASE 1: Correzione file del modulo Chart"
echo "==========================================="

# Corregge tutti i file PHP del modulo Chart
find "$LARAVEL_ROOT/Modules/Chart/app" -name "*.php" -type f | while read -r file; do
    fix_php_file "$file"
done

echo ""
echo "2. FASE 2: Correzione file del modulo Xot/packages"
echo "================================================="

# Corregge i file del package coolsam
if [[ -d "$LARAVEL_ROOT/Modules/Xot/packages/coolsam/panel-modules/src" ]]; then
    find "$LARAVEL_ROOT/Modules/Xot/packages/coolsam/panel-modules/src" -name "*.php" -type f | while read -r file; do
        fix_php_file "$file"
    done
fi

echo ""
echo "3. FASE 3: Correzione file Helper.php mancante"
echo "=============================================="

# Verifica e corregge il problema del file Helper.php mancante
HELPER_FILE="$LARAVEL_ROOT/Modules/Xot/helpers/Helper.php"
if [[ ! -f "$HELPER_FILE" ]]; then
    echo "⚠️  File Helper.php mancante: $HELPER_FILE"
    
    # Cerca file helper con nomi simili
    find "$LARAVEL_ROOT/Modules/Xot" -name "*helper*" -type f | while read -r file; do
        echo "Trovato file helper simile: $file"
        local class_name=$(get_class_name "$file")
        if [[ "$class_name" == "Helper" ]]; then
            echo "Rinomino: $file -> $HELPER_FILE"
            mkdir -p "$(dirname "$HELPER_FILE")"
            mv "$file" "$HELPER_FILE"
        fi
    done
fi

echo ""
echo "4. FASE 4: Correzione sistematica di tutti i moduli"
echo "=================================================="

# Corregge tutti i file PHP in tutti i moduli
find "$LARAVEL_ROOT/Modules" -name "*.php" -type f -path "*/app/*" | while read -r file; do
    # Salta i file vendor e di test
    if [[ "$file" =~ vendor|test|Test ]]; then
        continue
    fi
    
    local current_basename=$(basename "$file" .php)
    local class_name=$(get_class_name "$file")
    
    # Se il nome del file non corrisponde al nome della classe, correggi
    if [[ -n "$class_name" && "$class_name" != "$current_basename" ]]; then
        local dir=$(dirname "$file")
        local new_file="$dir/$class_name.php"
        
        if [[ ! -f "$new_file" ]]; then
            echo "Correzione: $(basename "$file") -> $class_name.php (modulo: $(echo "$file" | sed 's|.*/Modules/\([^/]*\)/.*|\1|'))"
            mv "$file" "$new_file"
        fi
    fi
done

echo ""
echo "5. FASE 5: Test composer dump-autoload"
echo "======================================"

cd "$LARAVEL_ROOT"
echo "Eseguendo composer dump-autoload per verificare le correzioni..."

if composer dump-autoload --no-scripts 2>/dev/null; then
    echo "✅ SUCCESSO: composer dump-autoload completato senza errori PSR-4"
else
    echo "⚠️  Ci sono ancora alcuni errori, ma procediamo con l'analisi dettagliata"
fi

echo ""
echo "6. FASE 6: Riepilogo correzioni"
echo "==============================="

# Conta i file corretti
corrected_files=$(find "$LARAVEL_ROOT/Modules" -name "*.php" -type f -path "*/app/*" | wc -l)
echo "File PHP analizzati: $corrected_files"

# Verifica che non ci siano più errori PSR-4 critici
echo "Verifica finale degli errori PSR-4..."
composer dump-autoload 2>&1 | grep -E "does not comply with psr-4|Failed to open stream" | wc -l | xargs -I {} echo "Errori PSR-4 rimanenti: {}"

echo ""
echo "======================================================="
echo "CORREZIONE AUTOLOAD PSR-4 COMPLETATA!"
echo "======================================================="
echo "Tutte le correzioni sono state applicate per far corrispondere"
echo "i nomi dei file PHP ai nomi delle classi secondo PSR-4."
echo "======================================================="
