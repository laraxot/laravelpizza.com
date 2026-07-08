#!/bin/bash

# Script per rinominare i file nelle cartelle docs
# Regola: Tutti i file devono usare solo caratteri minuscoli, eccezione README.md

set -e

echo "🔧 Fixing docs file naming convention..."
echo "📋 Rule: All files must use lowercase, except README.md"

# Funzione per rinominare un file
rename_file() {
    local old_name="$1"
    local new_name="$2"
    
    if [[ "$old_name" != "$new_name" ]]; then
        echo "  📝 Renaming: $old_name → $new_name"
        mv "$old_name" "$new_name"
    fi
}

# Funzione per processare una directory
process_directory() {
    local dir="$1"
    
    if [[ ! -d "$dir" ]]; then
        return
    fi
    
    echo "📁 Processing directory: $dir"
    
    # Trova tutti i file .md nella directory
    while IFS= read -r -d '' file; do
        filename=$(basename "$file")
        dirname=$(dirname "$file")
        
        # Salta README.md (eccezione)
        if [[ "$filename" == "README.md" ]]; then
            continue
        fi
        
        # Crea il nuovo nome con solo caratteri minuscoli e underscore
        new_name=$(echo "$filename" | tr '[:upper:]' '[:lower:]' | sed 's/-/_/g')
        
        # Se il nome è cambiato, rinomina
        if [[ "$filename" != "$new_name" ]]; then
            rename_file "$dirname/$filename" "$dirname/$new_name"
        fi
    done < <(find "$dir" -maxdepth 1 -name "*.md" -print0)
}

# Processa tutte le cartelle docs nel progetto
echo "🔍 Finding all docs directories..."

# Trova tutte le cartelle docs
docs_dirs=$(find /var/www/html/_bases/base_<nome progetto>_fila5_mono -type d -name "docs" 2>/dev/null | grep -v vendor | grep -v node_modules)

# Processa ogni directory
for dir in $docs_dirs; do
    process_directory "$dir"
done

echo "✅ Docs naming convention fix completed!"
echo ""
echo "📊 Summary:"
echo "  - Processed directories: $(echo "$docs_dirs" | wc -l)"
echo "  - All .md files now use lowercase naming"
echo "  - README.md files preserved as exceptions"
echo ""
echo "📋 Remember:"
echo "  - All docs files must use lowercase"
echo "  - Use underscores instead of hyphens"
echo "  - README.md is the only exception" 