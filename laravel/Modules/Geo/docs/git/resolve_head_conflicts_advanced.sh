#!/bin/bash

# Script Avanzato per Risolvere Conflitti Git con <git marker>
# Mantiene sempre la "current change" (versione dopo =======)
# Versione migliorata con logging dettagliato e validazione

set -euo pipefail

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Configurazione
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../.." && pwd)"
LOG_FILE="${SCRIPT_DIR}/conflict_resolution_$(date +%Y%m%d_%H%M%S).log"
BACKUP_DIR="${SCRIPT_DIR}/backups/$(date +%Y%m%d_%H%M%S)"

# Funzioni di logging
log() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${BLUE}[$timestamp]${NC} $message" | tee -a "$LOG_FILE"
}

error() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${RED}[$timestamp] ERROR:${NC} $message" | tee -a "$LOG_FILE" >&2
}

success() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${GREEN}[$timestamp] SUCCESS:${NC} $message" | tee -a "$LOG_FILE"
}

warning() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${YELLOW}[$timestamp] WARNING:${NC} $message" | tee -a "$LOG_FILE"
}

info() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${CYAN}[$timestamp] INFO:${NC} $message" | tee -a "$LOG_FILE"
}

# Funzione per mostrare l'header
show_header() {
    echo -e "${CYAN}"
    echo "============================================================================="
    echo "  Script Avanzato per Risoluzione Conflitti Git - Current Change"
    echo "============================================================================="
    echo -e "${NC}"
    log "Directory progetto: $PROJECT_ROOT"
    log "Directory script: $SCRIPT_DIR"
    log "File di log: $LOG_FILE"
    log "Directory backup: $BACKUP_DIR"
    echo ""
}

# Funzione per creare directory di backup
create_backup_dir() {
    if [ ! -d "$BACKUP_DIR" ]; then
        mkdir -p "$BACKUP_DIR"
        log "Creata directory backup: $BACKUP_DIR"
    fi
}

# Funzione per trovare file con conflitti
find_conflict_files() {
    local files=()
    
    log "Cercando file con marker di conflitto Git..."
    
    # Usa find diretto senza colori nell'output
    while IFS= read -r -d '' file; do
        if [ -f "$file" ]; then
            files+=("$file")
        fi
    local end_count=$(grep -c "^>>>>>>>" "$file" 2>/dev/null || echo "0")
    
    echo "$head_count:$separator_count:$end_count"
}

# Funzione per risolvere un singolo file
resolve_file() {
    local file="$1"
    local temp_file="${file}.tmp.$$"
    local backup_file="${BACKUP_DIR}/$(basename "$file").backup"
    
    log "Risolvendo: $file"
    
    # Analizza il file
    local analysis=$(analyze_conflict_file "$file")
    local head_count=$(echo "$analysis" | cut -d: -f1)
    local separator_count=$(echo "$analysis" | cut -d: -f2)
    local end_count=$(echo "$analysis" | cut -d: -f3)
    
    info "  Conflitti trovati: HEAD=$head_count, SEPARATOR=$separator_count, END=$end_count"
    
    # Verifica che i marker siano bilanciati
    if [ "$head_count" -ne "$separator_count" ] || [ "$separator_count" -ne "$end_count" ]; then
        warning "  Marker non bilanciati in $file - procedo comunque"
    fi
    
    # Crea backup
    cp "$file" "$backup_file"
    info "  Backup creato: $backup_file"
    
    # Risolvi conflitti mantenendo current change
    awk '
    BEGIN {
        in_head = 0
        in_current = 0
        line_number = 0
    }
    {
        line_number++
        
        # Rileva inizio conflitto HEAD
            in_head = 0
            in_current = 1
            next
        }
        
        # Rileva fine conflitto
        if ($0 ~ /^>>>>>>>/) {
            in_head = 0
            in_current = 0
            next
        }
        
        # Stampa solo se non siamo in sezione HEAD
        if (!in_head) {
            print $0
        }
    }
    ' "$file" > "$temp_file"
    
    # Verifica che il file temporaneo sia valido
    if [ ! -s "$temp_file" ]; then
        error "  File temporaneo vuoto per $file"
        rm -f "$temp_file"
        return 1
    fi
    
    # Sostituisci il file originale
    if mv "$temp_file" "$file"; then
        # Verifica che non ci siano più conflitti
    
    if [ "$remaining_conflicts" -eq 0 ]; then
        success "Tutti i conflitti sono stati risolti!"
        return 0
    else
        warning "Rimangono $remaining_conflicts file con conflitti"
        return 1
    fi
}

# Funzione per mostrare statistiche finali
show_final_stats() {
    local total_files="$1"
    local fixed_files="$2"
    local failed_files="$3"
    
    echo ""
    log "============================================================================="
    log "  Statistiche Finali"
    log "============================================================================="
    success "File processati: $total_files"
    success "File risolti: $fixed_files"
    if [ "$failed_files" -gt 0 ]; then
        error "File falliti: $failed_files"
    fi
    
    local success_rate=0
    if [ "$total_files" -gt 0 ]; then
        success_rate=$((fixed_files * 100 / total_files))
    fi
    info "Tasso di successo: $success_rate%"
    
    log "Backup salvati in: $BACKUP_DIR"
    log "Log completo: $LOG_FILE"
    echo ""
}

# Funzione principale
main() {
    show_header
    
    # Verifica che siamo nella directory corretta
    if [ ! -f "$PROJECT_ROOT/composer.json" ]; then
        error "Directory progetto non valida: $PROJECT_ROOT"
        exit 1
    fi
    
    # Crea directory di backup
    create_backup_dir
    
    # Trova file con conflitti
    local conflict_files=()
    while IFS= read -r file; do
        if [ -n "$file" ] && [ -f "$file" ]; then
            conflict_files+=("$file")
        fi
    done < <(find_conflict_files)
    
    if [ ${#conflict_files[@]} -eq 0 ]; then
        success "Nessun file con conflitti trovato!"
        exit 0
    fi
    
    log "Trovati ${#conflict_files[@]} file con conflitti:"
    for file in "${conflict_files[@]}"; do
        echo "  - $file"
    done
    echo ""
    
    # Risolvi conflitti
    local fixed_count=0
    local failed_count=0
    local total_count=${#conflict_files[@]}
    
    for file in "${conflict_files[@]}"; do
        if resolve_file "$file"; then
            ((fixed_count++))
        else
            ((failed_count++))
        fi
    done
    
    # Validazione finale
    validate_result
    local validation_result=$?
    
    # Mostra statistiche
    show_final_stats "$total_count" "$fixed_count" "$failed_count"
    
    # Esci con codice appropriato
    if [ $validation_result -eq 0 ] && [ $failed_count -eq 0 ]; then
        success "Script completato con successo!"
        exit 0
    else
        error "Script completato con errori!"
        exit 1
    fi
}

# Esegui script
main "$@"
