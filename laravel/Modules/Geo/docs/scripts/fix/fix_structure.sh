#!/bin/bash

# 🎨 Colori per il logging
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# 📝 Funzione di logging
log() {
    local level="$1"
    local message="$2"
    case "$level" in
        "error") echo -e "${RED}❌ $message${NC}" ;;
        "success") echo -e "${GREEN}✅ $message${NC}" ;;
        "warning") echo -e "${YELLOW}⚠️ $message${NC}" ;;
        "info") echo -e "${BLUE}ℹ️ $message${NC}" ;;
    esac
}

# Definizione degli array di cartelle
MOVE_TO_APP=("Actions" "Broadcasting" "Casts" "Console" "Emails" "Enums" "Events" 
             "Exceptions" "Jobs" "Listeners" "Mail" "Models" "Notifications" 
             "Observers" "Policies" "Providers" "Rules" "Services" "Traits" 
             "Filesystem" "Http" "Interfaces" "Repositories" "Transformers")

RENAME_TO_LOWER=("App" "Config" "Database" "Resources" "Routes" "Tests")

# Funzione per gestire il movimento e la rinomina delle cartelle
move_and_rename() {
    local dir_name="$1"
    local dir_name_lower=$(echo "$dir_name" | tr '[:upper:]' '[:lower:]')
    local target_dir="${2:-}"  # Parametro opzionale per la directory di destinazione

    if [ -d "$dir_name" ] || [ -d "$dir_name_lower" ]; then
        # Gestione cartelle esistenti
        if [ -d "$dir_name" ] && [ -d "$dir_name_lower" ]; then
            log "info" "Unisco il contenuto di $dir_name in $dir_name_lower..."
            cp -r "$dir_name"/* "$dir_name_lower"/
            rm -rf "$dir_name"
        elif [ -d "$dir_name" ]; then
            log "info" "Rinomino $dir_name in $dir_name_lower..."
            mv "$dir_name" "$dir_name_lower"
        fi

        # Sposta nella directory di destinazione se specificata
        if [ -n "$target_dir" ]; then
            mkdir -p "$target_dir"
            log "info" "Sposto $dir_name_lower in $target_dir/"
            mv "$dir_name_lower" "$target_dir/"
        fi
    else
        log "warning" "Nota: Le cartelle $dir_name o $dir_name_lower non esistono."
    fi
}

# Crea la cartella app se non esiste
mkdir -p app

# Processa le cartelle da spostare in app/
log "info" "Spostamento cartelle in app/..."
for folder in "${MOVE_TO_APP[@]}"; do
    move_and_rename "$folder" "app"
done

# Processa le cartelle da rinominare in minuscolo
log "info" "Rinomina cartelle in minuscolo..."
for folder in "${RENAME_TO_LOWER[@]}"; do
    move_and_rename "$folder"
done

log "success" "Struttura del progetto aggiornata con successo."
