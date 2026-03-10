#!/bin/bash
# Script per correggere link assoluti in link relativi nei file .md
# NON eseguire direttamente - studiare prima la logica

set -e

DOCS_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="/var/www/_bases/base_<nome progetto>_fila5_mono"

echo "🔍 Analisi link assoluti in: $DOCS_DIR"
echo ""

# Funzione per convertire path assoluto in relativo
convert_to_relative() {
    local absolute_path="$1"
    local from_file="$2"
    local from_dir=$(dirname "$from_file")
    
    # Rimuovi project root dal path
    local relative_from_project="${absolute_path#$PROJECT_ROOT/}"
    local relative_from_project="${relative_from_project#laravel/}"
    
    # Calcola path relativo da $from_dir
    # Se from_dir è Modules/Xot/docs e target è Modules/User/docs/file.md
    # risultato dovrebbe essere ../../User/docs/file.md
    
    python3 -c "import os; print(os.path.relpath('$absolute_path', '$from_dir'))"
}

# Backup prima di modificare
echo "📦 Creazione backup in /tmp/docs-backup-$(date +%Y%m%d_%H%M%S)"
tar -czf "/tmp/docs-backup-$(date +%Y%m%d_%H%M%S).tar.gz" .

# Pattern da sostituire:
# 1. /var/www/html/<directory progetto>/laravel/Modules/...
# 2. /var/www/_bases/base_*/laravel/Modules/...

echo "🔧 Pattern da correggere:"
echo "  - /var/www/html/<directory progetto>/"
echo "  - /var/www/_bases/base_*/"
echo "  - Path assoluti hardcoded"
echo ""

# Conta occorrenze per tipo
echo "📊 Analisi occorrenze:"
grep -r "/var/www/html/<directory progetto>" --include="*.md" . 2>/dev/null | wc -l | xargs -I {} echo "  Template paths: {}"
grep -r "/var/www/_bases/base_" --include="*.md" . 2>/dev/null | wc -l | xargs -I {} echo "  Hardcoded paths: {}"
echo ""

echo "⚠️  ATTENZIONE: Questo script richiede revisione manuale"
echo "   Studiare la documentazione prima di eseguire modifiche massive"
echo ""
echo "🎯 NEXT STEPS:"
echo "1. Verificare manualmente alcuni file campione"
echo "2. Testare conversione su singolo file"
echo "3. Solo dopo, applicare a tutti i file"
echo "4. Verificare che link funzionino dopo conversione"

