#!/bin/bash

# Directory base
BASH_DIR="/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts"

# Funzione per determinare la categoria del file
get_category() {
    local file="$1"
    local content=$(cat "$file")
    local filename=$(basename "$file")
    
    # Analisi del contenuto e del nome del file
    if [[ "$content" =~ "git" ]] || [[ "$filename" =~ ^git_ ]]; then
        echo "git"
    elif [[ "$content" =~ "phpstan" ]] || [[ "$filename" =~ phpstan ]]; then
        echo "phpstan"
    elif [[ "$content" =~ "composer" ]] || [[ "$filename" =~ composer ]]; then
        echo "composer"
    elif [[ "$content" =~ "docker" ]] || [[ "$filename" =~ docker ]]; then
        echo "docker"
    elif [[ "$content" =~ "backup" ]] || [[ "$filename" =~ backup ]]; then
        echo "backup"
    elif [[ "$content" =~ "check" ]] || [[ "$content" =~ "verify" ]] || [[ "$filename" =~ ^check_ ]]; then
        echo "maintenance"
    elif [[ "$content" =~ "system" ]] || [[ "$content" =~ "init" ]] || [[ "$filename" =~ system ]]; then
        echo "system"
    elif [[ "$content" =~ "test" ]] || [[ "$filename" =~ test ]]; then
        echo "testing"
    elif [[ "$content" =~ "setup" ]] || [[ "$filename" =~ setup ]]; then
        echo "setup"
    elif [[ "$content" =~ "fix" ]] || [[ "$filename" =~ fix ]]; then
        echo "fix"
    else
        echo "utils"
    fi
}

# Funzione per spostare i file .sh nelle sottocartelle appropriate
move_sh_files() {
    local file="$1"
    local filename=$(basename "$file")
    local category=$(get_category "$file")
    local target_dir="$BASH_DIR/$category"
    
    echo "Spostamento $filename in $category"
    
    # Se il file esiste nella destinazione, lo elimina
    if [ -f "$target_dir/$filename" ]; then
        rm "$target_dir/$filename"
    fi
    
    # Sposta il file
    mv "$file" "$target_dir/"
}

# Sposta i file .sh rimanenti nelle sottocartelle appropriate
find "$BASH_DIR" -maxdepth 1 -name "*.sh" -type f | while read -r file; do
    move_sh_files "$file"
done

echo "Organizzazione finale completata!" 