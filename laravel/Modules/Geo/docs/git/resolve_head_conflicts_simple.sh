#!/bin/bash

# =============================================================================
# Script Semplice per Risoluzione Conflitti Git con <git marker>
# =============================================================================
# 
# DESCRIZIONE:
# Trova tutti i file con conflitti Git contenenti "<git marker>" e risolve automaticamente
# mantenendo sempre la "current change" (versione dopo =======).
#
# USAGE:
#   ./resolve_head_conflicts_simple.sh [--dry-run] [--backup] [--directory DIR]
#
# =============================================================================

set -euo pipefail

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Variabili di controllo
DRY_RUN=false
BACKUP=false
CUSTOM_DIRECTORY=""

# Directory di lavoro
PROJECT_ROOT="/var/www/_bases/base_<nome progetto>_fila5_mono"

# Funzione per logging
log() {
    local level="$1"
    shift
    local message="$*"
    local timestamp=$(date '+%H:%M:%S')
    
    case "$level" in
        "ERROR") echo -e "${RED}❌ [$timestamp] $message${NC}" ;;
        "SUCCESS") echo -e "${GREEN}✅ [$timestamp] $message${NC}" ;;
        "WARNING") echo -e "${YELLOW}⚠️ [$timestamp] $message${NC}" ;;
        "INFO") echo -e "${BLUE}ℹ️ [$timestamp] $message${NC}" ;;
        *) echo -e "[$timestamp] $message" ;;
    esac
}

# Funzione per mostrare help
show_help() {
    cat << EOF
Script Semplice per Risoluzione Conflitti Git con <git marker>

DESCRIZIONE:
Trova tutti i file con conflitti Git contenenti "<git marker>" e risolve automaticamente
mantenendo sempre la "current change" (versione dopo =======).

USAGE:
    $0 [OPZIONI]

OPZIONI:
    --dry-run    Mostra solo i file che verrebbero modificati (non modifica nulla)
    --backup     Crea backup dei file prima della modifica
    --directory  Directory di lavoro personalizzata (default: progetto principale)
    --help       Mostra questo help

ESEMPI:
    $0                           # Risolvi tutti i conflitti
    $0 --dry-run                 # Mostra solo cosa farebbe
    $0 --backup --directory /tmp # Risolvi con backup in directory specifica

EOF
}

# Funzione per creare backup
create_backup() {
    local file="$1"
    local backup_file="${file}.backup.$(date '+%Y%m%d_%H%M%S')"
    
    if [ "$BACKUP" = true ]; then
        cp "$file" "$backup_file"
        log "INFO" "Backup creato: $backup_file"
    fi
}

# Funzione per risolvere conflitti in un singolo file
resolve_file_conflicts() {
    local file="$1"
    local temp_file="${file}.tmp.$$"
    
    log "INFO" "Risolvendo conflitti in: $file"
    
    # Crea backup se richiesto
    if [ "$BACKUP" = true ]; then
        create_backup "$file"
    fi
    
    # Processo di risoluzione conflitti con AWK
    # Mantiene solo la versione "current change" (dopo =======)
    awk '
    /^>>>>>>> .*$/ { in_current = 0; next }
    in_head { next }
    in_current || (!in_head && !in_current) { print }
    ' "$file" > "$temp_file"
    
    # Verifica che il file temporaneo non sia vuoto
    if [ ! -s "$temp_file" ]; then
        log "WARNING" "File risultante vuoto per: $file"
        rm -f "$temp_file"
        return 1
    fi
    
    # Sostituisce il file originale
    if [ "$DRY_RUN" = false ]; then
        mv "$temp_file" "$file"
        log "SUCCESS" "Conflitti risolti in: $file"
    else
        rm -f "$temp_file"
        log "INFO" "DRY RUN: Conflitti che verrebbero risolti in: $file"
    fi
    
    return 0
}

# Funzione per trovare file con conflitti
find_conflict_files() {
    local search_dir="$1"
    local files=()
    
    # Trova file con conflitti usando find e grep, escludendo file di backup
    while IFS= read -r file; do
        if [ -n "$file" ] && [ -f "$file" ]; then
            # Esclude file di backup e temporanei
            if [[ "$file" == *.backup.* ]] || [[ "$file" == *.tmp.* ]] || [[ "$file" == *.orig ]] || [[ "$file" == *.rej ]]; then
                continue
            fi
            
            # Esclude directory non rilevanti
            if [[ "$file" == *"/.git/"* ]] || [[ "$file" == *"/vendor/"* ]] || [[ "$file" == *"/node_modules/"* ]] || [[ "$file" == *"/storage/logs/"* ]] || [[ "$file" == *"/bootstrap/cache/"* ]]; then
                continue
            fi
            
            files+=("$file")
        fi
    echo -e "${BLUE}  Script Semplice per Risoluzione Conflitti Git con <git marker>${NC}"
    echo -e "${BLUE}=============================================================================${NC}"
    echo
    
    log "INFO" "Cercando file con conflitti in: $PROJECT_ROOT"
    
    # Trova file con conflitti
    mapfile -t conflict_files < <(find_conflict_files "$PROJECT_ROOT")
    
    if [ ${#conflict_files[@]} -eq 0 ]; then
        log "SUCCESS" "Nessun file con conflitti trovato!"
        exit 0
    fi
    
    log "INFO" "Trovati ${#conflict_files[@]} file con conflitti"
    
    # Contatori
    local resolved_count=0
    local failed_count=0
    local total_count=${#conflict_files[@]}
    
    # Processa ogni file
    for file in "${conflict_files[@]}"; do
        if [ -n "$file" ] && [ -f "$file" ]; then
            if resolve_file_conflicts "$file"; then
                ((resolved_count++))
            else
                ((failed_count++))
            fi
        fi
    done
    
    # Messaggio finale
    echo
    echo -e "${BLUE}=============================================================================${NC}"
    if [ "$DRY_RUN" = true ]; then
        echo -e "${YELLOW}  DRY RUN COMPLETATO${NC}"
        echo -e "${YELLOW}  File che verrebbero processati: $total_count${NC}"
    else
        echo -e "${GREEN}  RISOLUZIONE COMPLETATA${NC}"
        echo -e "${GREEN}  File risolti: $resolved_count/$total_count${NC}"
        if [ $failed_count -gt 0 ]; then
            echo -e "${RED}  File con errori: $failed_count${NC}"
        fi
    fi
    echo -e "${BLUE}=============================================================================${NC}"
    echo
    
    # Exit code basato sui risultati
    if [ $failed_count -gt 0 ]; then
        exit 1
    else
        exit 0
    fi
}

# Esegue main
main "$@"