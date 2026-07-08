#!/bin/bash

# Script per rinominare i file della documentazione secondo le convenzioni
# Questo script converte i nomi dei file da snake_case a kebab-case
# e assicura che non ci siano caratteri maiuscoli (eccetto README.md)

# Directory della documentazione
DOCS_DIR="docs"

# Funzione per convertire da snake_case a kebab-case
convert_to_kebab_case() {
    echo "$1" | tr '_' '-' | tr '[:upper:]' '[:lower:]'
}

# Funzione per rinominare un file
rename_file() {
    local old_name="$1"
    local new_name="$2"
    
    if [ "$old_name" != "$new_name" ]; then
        echo "Rinomino: $old_name -> $new_name"
        mv "$old_name" "$new_name"
    fi
}

# Funzione per aggiornare i riferimenti nei file
update_references() {
    local old_name="$1"
    local new_name="$2"
    
    # Aggiorna i riferimenti nei file .md
    find "$DOCS_DIR" -type f -name "*.md" -exec sed -i "s|$old_name|$new_name|g" {} +
    
    # Aggiorna i riferimenti nei file .mdc
    find .cursor/rules .windsurf/rules -type f -name "*.mdc" -exec sed -i "s|$old_name|$new_name|g" {} +
}

# Funzione principale per processare i file
process_files() {
    local dir="$1"
    
    # Trova tutti i file .md nella directory
    find "$dir" -type f -name "*.md" | while read -r file; do
        # Ottieni il nome del file senza il percorso
        filename=$(basename "$file")
        
        # Se non è README.md, converti in minuscolo
        if [ "$filename" != "README.md" ]; then
            new_name=$(convert_to_kebab_case "$filename")
            dir_name=$(dirname "$file")
            new_path="$dir_name/$new_name"
            
            # Rinomina il file se necessario
            rename_file "$file" "$new_path"
            
            # Aggiorna i riferimenti
            update_references "$filename" "$new_name"
        fi
    done
}

# Esegui lo script
echo "Inizio rinominazione file nella documentazione..."
process_files "$DOCS_DIR"
echo "Rinominazione completata!"

# Verifica finale
echo "Verifica dei file rimanenti con caratteri maiuscoli:"
find "$DOCS_DIR" -type f -name "*.md" ! -name "README.md" -exec grep -l "[A-Z]" {} \; 