#!/bin/bash

# Script di Emergenza per Sistemare i Conflitti Git
# Rimuove TUTTI i marker di conflitto Git e mantiene solo la versione "current"

set -euo pipefail

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione di logging
log() {
    echo -e "${BLUE}[$(date '+%H:%M:%S')]${NC} $1"
}

error() {
    echo -e "${RED}[$(date '+%H:%M:%S')] ERROR:${NC} $1" >&2
}

success() {
    echo -e "${GREEN}[$(date '+%H:%M:%S')] SUCCESS:${NC} $1"
}

warning() {
    echo -e "${YELLOW}[$(date '+%H:%M:%S')] WARNING:${NC} $1"
}

# Directory di lavoro
WORK_DIR="${1:-/var/www/_bases/base_<nome progetto>_fila5_mono}"

# Verifica che la directory esista
if [ ! -d "$WORK_DIR" ]; then
    error "Directory non trovata: $WORK_DIR"
    exit 1
fi

cd "$WORK_DIR"

log "============================================================================="
log "  Script di Emergenza per Sistemare Conflitti Git"
log "============================================================================="
log "Directory di lavoro: $WORK_DIR"

# Trova tutti i file con marker di conflitto Git
log "Cercando file con marker di conflitto Git..."

# Pattern per trovare file con conflitti
CONFLICT_FILES=()
while IFS= read -r -d '' file; do
    if [ -f "$file" ]; then
        CONFLICT_FILES+=("$file")
    fi
    /^>>>>>>> .*$/ { in_current = 0; next }
    in_head { next }
    in_current || (!in_head && !in_current) { print }
    ' "$file" > "$temp_file"
    
    # Sostituisci il file originale
    mv "$temp_file" "$file"
    
    # Verifica che il file sia stato sistemato
log "  Risultati della Sistemazione"
log "============================================================================="
success "File sistemati: $fixed_count"
if [ $failed_count -gt 0 ]; then
    error "File falliti: $failed_count"
fi

# Verifica finale
log "Verifica finale..."
        echo "  - $file"
    done
fi

log "Script completato!"
