#!/bin/bash
# cleanup-docs.sh - Script consolidamento documentazione moduli Laraxot
# Uso: bash cleanup-docs.sh [module_name]
# Esempio: bash cleanup-docs.sh Xot

set -e

MODULE=${1:-"Xot"}
DOCS_DIR="/var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/$MODULE/docs"

if [ ! -d "$DOCS_DIR" ]; then
    echo "❌ Directory non trovata: $DOCS_DIR"
    exit 1
fi

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🧹 Cleanup Documentation - Modulo: $MODULE"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Crea cartelle archive se non esistono
mkdir -p "$DOCS_DIR/archive/historical"
mkdir -p "$DOCS_DIR/archive/duplicates"
mkdir -p "$DOCS_DIR/archive/uppercase"

# Contatori
RENAMED=0
ARCHIVED=0
DUPLICATES=0

echo "📊 FASE 1: Analisi stato attuale..."
echo ""
TOTAL_FILES=$(find "$DOCS_DIR" -maxdepth 1 -name "*.md" -type f | wc -l)
echo "Totale file root: $TOTAL_FILES"
echo ""

echo "📊 FASE 2: Archivia file con date nel nome..."
echo ""
find "$DOCS_DIR" -maxdepth 1 -name "*-20[0-9][0-9]-[0-1][0-9]-[0-3][0-9]*.md" -type f | while read file; do
    if [ -f "$file" ]; then
        base=$(basename "$file")
        echo "  📦 Archiving: $base"
        mv "$file" "$DOCS_DIR/archive/historical/$base"
        ((ARCHIVED++))
    fi
done
echo "Archiviati: $ARCHIVED file"
echo ""

echo "📊 FASE 3: Identifica duplicati underscore/hyphen..."
echo ""
# Trova coppie file_name.md e file-name.md
find "$DOCS_DIR" -maxdepth 1 -name "*_*.md" -type f | while read file_underscore; do
    base_under=$(basename "$file_underscore" .md)
    base_hyphen=$(echo "$base_under" | tr '_' '-')
    file_hyphen="$DOCS_DIR/$base_hyphen.md"
    
    if [ -f "$file_hyphen" ]; then
        echo "  🔍 Duplicato trovato:"
        echo "     - $base_under.md (underscore)"
        echo "     - $base_hyphen.md (hyphen)"
        echo "     Azione: Mantieni hyphen, archivia underscore"
        mv "$file_underscore" "$DOCS_DIR/archive/duplicates/$(basename "$file_underscore")"
        ((DUPLICATES++))
    fi
done
echo "Duplicati archiviati: $DUPLICATES"
echo ""

echo "📊 FASE 4: Rinomina file UPPERCASE → kebab-case..."
echo ""
find "$DOCS_DIR" -maxdepth 1 -name "*.md" -type f | while read file; do
    base=$(basename "$file")
    
    # Skip README.md e CHANGELOG.md
    if [[ "$base" == "README.md" ]] || [[ "$base" == "CHANGELOG.md" ]]; then
        continue
    fi
    
    # Converti a lowercase kebab-case
    new_base=$(echo "$base" | tr '[:upper:]' '[:lower:]' | tr '_' '-')
    
    if [[ "$base" != "$new_base" ]]; then
        # Se esiste già il file lowercase, archivia quello UPPERCASE
        if [ -f "$DOCS_DIR/$new_base" ]; then
            echo "  ⚠️  Conflict: $base → $new_base (già esiste)"
            echo "     Archiving UPPERCASE version"
            mv "$file" "$DOCS_DIR/archive/uppercase/$base"
        else
            echo "  ✏️  Rename: $base → $new_base"
            mv "$file" "$DOCS_DIR/$new_base"
            ((RENAMED++))
        fi
    fi
done
echo "Rinominati: $RENAMED file"
echo ""

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ Cleanup completato!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📊 Riepilogo:"
echo "  - File archiviati (date): $ARCHIVED"
echo "  - Duplicati rimossi: $DUPLICATES"
echo "  - File rinominati: $RENAMED"
echo ""
NEW_TOTAL=$(find "$DOCS_DIR" -maxdepth 1 -name "*.md" -type f | wc -l)
echo "  Totale prima: $TOTAL_FILES"
echo "  Totale dopo:  $NEW_TOTAL"
echo "  Riduzione:    $((TOTAL_FILES - NEW_TOTAL)) files"
echo ""
echo "📁 File archiviati in:"
echo "  - $DOCS_DIR/archive/historical/"
echo "  - $DOCS_DIR/archive/duplicates/"
echo "  - $DOCS_DIR/archive/uppercase/"
echo ""

