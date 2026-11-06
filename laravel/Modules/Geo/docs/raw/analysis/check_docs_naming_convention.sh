#!/bin/bash

# Script per verificare la conformità della convenzione di naming lowercase nelle directory docs
# Tutti i file e cartelle in docs/ devono essere lowercase, tranne README.md

set -e

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
VIOLATIONS_FOUND=0

echo "🔍 Verifica convenzione naming lowercase per directory docs..."
echo "📁 Directory di progetto: $PROJECT_ROOT"
echo ""

# Funzione per stampare violazioni
print_violation() {
    local file="$1"
    local type="$2"
    echo "❌ VIOLAZIONE ($type): $file"
    VIOLATIONS_FOUND=$((VIOLATIONS_FOUND + 1))
}

# Verifica file con maiuscole (escludendo README.md e vendor)
echo "🔎 Controllo file con caratteri maiuscoli..."
while IFS= read -r -d '' file; do
    # Salta README.md (unica eccezione consentita)
    if [[ "$(basename "$file")" == "README.md" ]]; then
        continue
    fi
    
    # Salta file vendor
    if [[ "$file" == *"/vendor/"* ]]; then
        continue
    fi
    
    print_violation "$file" "FILE"
done < <(find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type f -print0 2>/dev/null || true)

# Verifica cartelle con maiuscole
echo "🔎 Controllo cartelle con caratteri maiuscoli..."
while IFS= read -r -d '' dir; do
    # Salta cartelle vendor
    if [[ "$dir" == *"/vendor/"* ]]; then
        continue
    fi
    
    print_violation "$dir" "DIRECTORY"
done < <(find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type d -print0 2>/dev/null || true)

echo ""

# Risultato finale
if [ $VIOLATIONS_FOUND -eq 0 ]; then
    echo "✅ SUCCESSO: Tutte le directory docs rispettano la convenzione lowercase!"
    echo "📋 Regola: Solo README.md può contenere caratteri maiuscoli"
    exit 0
else
    echo "🚨 ERRORE: Trovate $VIOLATIONS_FOUND violazioni della convenzione naming!"
    echo ""
    echo "📋 Regole da seguire:"
    echo "   • Tutti i file nelle directory docs/ devono essere lowercase"
    echo "   • Tutte le cartelle nelle directory docs/ devono essere lowercase"
    echo "   • UNICA ECCEZIONE: README.md può contenere maiuscole"
    echo ""
    echo "🔧 Per correggere:"
    echo "   1. Rinomina i file/cartelle in lowercase"
    echo "   2. Aggiorna tutti i riferimenti nei file di documentazione"
    echo "   3. Verifica che i link interni funzionino"
    echo ""
    exit 1
fi
