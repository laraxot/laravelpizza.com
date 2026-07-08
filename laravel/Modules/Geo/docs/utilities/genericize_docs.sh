#!/bin/bash

# Directory base
BASE_DIR="/var/www/html/_bases/base_ptvx_fila5_mono"
DOCS_DIR="$BASE_DIR/docs"

# Funzione per sostituire i riferimenti specifici
replace_specific_refs() {
    local file="$1"
    local temp_file="${file}.tmp"
    
    # Backup del file
    cp "$file" "${file}.bak"
    
    # Sostituisci i riferimenti specifici con il placeholder
    sed -i 's/<slogan progetto>/<nome progetto>/gi' "$file"
    sed -i 's/<nome progetto>/<nome progetto>/gi' "$file"
    sed -i 's/ptvx/<nome progetto>/gi' "$file"
    sed -i 's/PTVX/<nome progetto>/gi' "$file"
    
    # Sostituisci anche i riferimenti nei percorsi
    sed -i 's/base_ptvx_fila5_mono/base_<nome progetto>/gi' "$file"
    
    # Sostituisci i riferimenti nei link
    sed -i 's/laraxot\/module_ptvx/laraxot\/module_<nome progetto>/gi' "$file"
    sed -i 's/laraxot\/ptvx/laraxot\/<nome progetto>/gi' "$file"
}

# Funzione per processare ricorsivamente una directory
process_directory() {
    local dir="$1"
    
    # Processa tutti i file .md nella directory
    find "$dir" -name "*.md" -type f | while read -r file; do
        echo "Processo $file"
        replace_specific_refs "$file"
    done
    
    # Processa tutti i file .txt nella directory
    find "$dir" -name "*.txt" -type f | while read -r file; do
        echo "Processo $file"
        replace_specific_refs "$file"
    done
}

# Processa la directory principale della documentazione
process_directory "$DOCS_DIR"

# Processa la documentazione nei moduli
if [ -d "$BASE_DIR/laravel/Modules" ]; then
    find "$BASE_DIR/laravel/Modules" -type d -name "docs" | while read -r module_docs; do
        process_directory "$module_docs"
    done
fi

echo "Sostituzione riferimenti specifici completata!" 