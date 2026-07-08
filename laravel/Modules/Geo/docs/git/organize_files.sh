#!/bin/bash

# Directory base
BASE_DIR="/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts"
DOCS_DIR="$BASE_DIR/docs"

# Crea le sottocartelle per i file .sh
mkdir -p "$BASE_DIR/git"
mkdir -p "$BASE_DIR/maintenance"
mkdir -p "$BASE_DIR/system"
mkdir -p "$BASE_DIR/utils"
mkdir -p "$BASE_DIR/phpstan"
mkdir -p "$BASE_DIR/composer"
mkdir -p "$BASE_DIR/docker"
mkdir -p "$BASE_DIR/backup"

# Funzione per analizzare il contenuto del file e determinare la categoria
analyze_file() {
    local file="$1"
    local content=$(cat "$file")
    
    # Analisi del contenuto per determinare la categoria
    if [[ "$content" =~ "git" ]] || [[ "$content" =~ "subtree" ]] || [[ "$content" =~ "branch" ]]; then
        echo "git"
    elif [[ "$content" =~ "phpstan" ]] || [[ "$content" =~ "static analysis" ]]; then
        echo "phpstan"
    elif [[ "$content" =~ "composer" ]] || [[ "$content" =~ "dependencies" ]]; then
        echo "composer"
    elif [[ "$content" =~ "docker" ]] || [[ "$content" =~ "container" ]]; then
        echo "docker"
    elif [[ "$content" =~ "backup" ]] || [[ "$content" =~ "restore" ]]; then
        echo "backup"
    elif [[ "$content" =~ "check" ]] || [[ "$content" =~ "verify" ]] || [[ "$content" =~ "maintenance" ]]; then
        echo "maintenance"
    elif [[ "$content" =~ "system" ]] || [[ "$content" =~ "init" ]] || [[ "$content" =~ "setup" ]]; then
        echo "system"
    else
        echo "utils"
    fi
}

# Funzione per spostare i file .sh
move_sh_files() {
    local source_file="$1"
    local filename=$(basename "$source_file")
    
    # Analizza il contenuto del file per determinare la categoria
    local category=$(analyze_file "$source_file")
    local target_dir="$BASE_DIR/$category"
    
    echo "Analisi di $filename: categoria $category"
    
    # Se il file esiste nella destinazione, lo elimina
    if [ -f "$target_dir/$filename" ]; then
        echo "File $filename già presente in $target_dir - eliminazione in corso..."
        rm "$target_dir/$filename"
    fi
    
    # Sposta il file
    mv "$source_file" "$target_dir/"
    echo "Spostato $filename in $target_dir"
}

# Funzione per spostare i file .md
move_md_files() {
    local source_file="$1"
    local filename=$(basename "$source_file")
    
    # Se il file esiste nella destinazione, lo elimina
    if [ -f "$DOCS_DIR/$filename" ]; then
        echo "File $filename già presente in $DOCS_DIR - eliminazione in corso..."
        rm "$DOCS_DIR/$filename"
    fi
    
    # Sposta il file
    mv "$source_file" "$DOCS_DIR/"
    echo "Spostato $filename in $DOCS_DIR"
}

# Processa tutti i file .sh nella directory principale
for file in "$BASE_DIR"/*.sh; do
    if [ -f "$file" ]; then
        move_sh_files "$file"
    fi
done

# Processa tutti i file .md nella directory principale
for file in "$BASE_DIR"/*.md; do
    if [ -f "$file" ]; then
        move_md_files "$file"
    fi
done

echo "Organizzazione completata!" 