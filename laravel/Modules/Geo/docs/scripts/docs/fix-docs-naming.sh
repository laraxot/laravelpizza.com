#!/bin/bash
# Script generato automaticamente per correggere naming convention

set -e

BASE_DIR="/var/www/html/_bases/base_ptvx"

echo "🔧 Correzione automatica naming convention docs..."

# Funzione per rinominare file e cartelle
fix_naming() {
    local path="$1"
    
    # Prima rinomina i file
    find "$path" -type f -name "*[A-Z]*" ! -name "README.md" | while read -r file; do
        dir=$(dirname "$file")
        filename=$(basename "$file")
        lowercase_name=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
        
        if [ "$filename" != "$lowercase_name" ]; then
            echo "Rinomino file: $filename -> $lowercase_name"
            mv "$file" "$dir/$lowercase_name"
        fi
    done
    
    # Poi rinomina le cartelle (dal più profondo al meno profondo)
    find "$path" -type d -name "*[A-Z]*" | sort -r | while read -r dir; do
        parent=$(dirname "$dir")
        dirname_only=$(basename "$dir")
        lowercase_name=$(echo "$dirname_only" | tr '[:upper:]' '[:lower:]')
        
        if [ "$dirname_only" != "$lowercase_name" ]; then
            echo "Rinomino cartella: $dirname_only -> $lowercase_name"
            mv "$dir" "$parent/$lowercase_name"
        fi
    done
}

# Applica correzioni
if [ -d "$BASE_DIR/docs" ]; then
    fix_naming "$BASE_DIR/docs"
fi

for module_docs in "$BASE_DIR/laravel/Modules/*/docs"; do
    if [ -d "$module_docs" ]; then
        fix_naming "$module_docs"
    fi
done

echo "✅ Correzioni naming completate!"
