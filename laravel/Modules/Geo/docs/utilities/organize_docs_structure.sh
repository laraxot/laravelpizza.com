#!/bin/bash

# Script per organizzare sistematicamente la struttura delle cartelle docs
# Segue le regole di naming convention Laraxot e elimina duplicati

set -e

BASE_DIR="/var/www/html/_bases/base_<nome progetto>"
LOG_FILE="$BASE_DIR/docs/docs_organization_log.txt"

echo "=== INIZIO ORGANIZZAZIONE DOCS $(date) ===" > "$LOG_FILE"

# Funzione per logging
log_action() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

# Funzione per identificare duplicati (file con stesso contenuto)
find_content_duplicates() {
    local dir="$1"
    log_action "Analizzando duplicati di contenuto in: $dir"
    
    if [ -d "$dir" ]; then
        find "$dir" -name "*.md" -type f -exec md5sum {} \; | sort | uniq -d -w32 >> "$LOG_FILE"
    fi
}

# Funzione per identificare file con naming simile (hyphen vs underscore)
find_naming_variants() {
    local dir="$1"
    log_action "Analizzando varianti di naming in: $dir"
    
    if [ -d "$dir" ]; then
        # Trova file con pattern simili
        find "$dir" -name "*-*" -type f | while read -r hyphen_file; do
            basename_file=$(basename "$hyphen_file" .md)
            underscore_version="${basename_file//-/_}.md"
            underscore_path="$(dirname "$hyphen_file")/$underscore_version"
            
            if [ -f "$underscore_path" ]; then
                echo "DUPLICATO NAMING: $hyphen_file <-> $underscore_path" >> "$LOG_FILE"
            fi
        done
    fi
}

# Funzione per consolidare file duplicati
consolidate_duplicates() {
    local dir="$1"
    log_action "Consolidando duplicati in: $dir"
    
    if [ -d "$dir" ]; then
        # Preferenza: hyphen over underscore per consistency
        find "$dir" -name "*_*" -type f | while read -r underscore_file; do
            basename_file=$(basename "$underscore_file" .md)
            hyphen_version="${basename_file//_/-}.md"
            hyphen_path="$(dirname "$underscore_file")/$hyphen_version"
            
            if [ -f "$hyphen_path" ]; then
                # Confronta contenuto
                if cmp -s "$underscore_file" "$hyphen_path"; then
                    log_action "RIMUOVO DUPLICATO: $underscore_file (identico a $hyphen_path)"
                    rm "$underscore_file"
                else
                    log_action "CONFLITTO: $underscore_file vs $hyphen_path (contenuto diverso)"
                fi
            fi
        done
    fi
}

# Funzione per creare struttura logica
create_logical_structure() {
    local base_docs="$1"
    log_action "Creando struttura logica in: $base_docs"
    
    # Crea cartelle principali se non esistono
    mkdir -p "$base_docs/core"
    mkdir -p "$base_docs/modules"
    mkdir -p "$base_docs/development"
    mkdir -p "$base_docs/architecture"
    mkdir -p "$base_docs/standards"
    mkdir -p "$base_docs/troubleshooting"
    mkdir -p "$base_docs/guides"
    mkdir -p "$base_docs/reference"
}

# Analisi delle cartelle principali
log_action "=== ANALISI CARTELLE DOCS ==="

# Main docs
find_content_duplicates "$BASE_DIR/docs"
find_naming_variants "$BASE_DIR/docs"

# Module docs
for module in Xot <nome progetto> User UI Tenant; do
    module_docs="$BASE_DIR/laravel/Modules/$module/docs"
    if [ -d "$module_docs" ]; then
        log_action "Analizzando modulo: $module"
        find_content_duplicates "$module_docs"
        find_naming_variants "$module_docs"
    fi
done

log_action "=== CONSOLIDAMENTO DUPLICATI ==="

# Consolida duplicati
consolidate_duplicates "$BASE_DIR/docs"

for module in Xot <nome progetto> User UI Tenant; do
    module_docs="$BASE_DIR/laravel/Modules/$module/docs"
    if [ -d "$module_docs" ]; then
        consolidate_duplicates "$module_docs"
    fi
done

# Crea struttura logica
create_logical_structure "$BASE_DIR/docs"

log_action "=== FINE ORGANIZZAZIONE DOCS $(date) ==="

echo "Organizzazione completata. Vedi log: $LOG_FILE"
