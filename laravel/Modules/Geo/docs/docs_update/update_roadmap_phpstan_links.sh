#!/bin/bash

# Script per aggiornare i collegamenti PHPStan nella roadmap
# Questo script aggiorna automaticamente i collegamenti ai report PHPStan nella documentazione

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Funzione per il logging
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verifica se il file esiste
if [ ! -f "$1" ]; then
    log_error "File non trovato: $1"
    exit 1
fi

file="$1"

# 1. Backup del file originale
cp "$file" "${file}.bak"
log_info "Backup creato: ${file}.bak"

# 2. Aggiorna i collegamenti PHPStan
log_info "Aggiornamento collegamenti PHPStan..."
sed -i 's|docs/phpstan/level_\([0-9]\+\)\.md|docs/phpstan/level_\1.md|g' "$file"

# 3. Verifica la sintassi del file
if [[ "$file" == *.md ]]; then
    log_info "Verifica sintassi Markdown..."
    if markdownlint "$file" > /dev/null 2>&1; then
        log_info "Sintassi Markdown valida"
    else
        log_warn "Problemi di sintassi Markdown trovati"
    fi
fi

log_info "Aggiornamento completato per: $file"

# 4. Trova altri file con collegamenti da aggiornare
log_info "Ricerca altri file con collegamenti da aggiornare..."
files_to_update=$(find . -type f -name "*.md" -not -path "*/\.*" \
    -not -path "*/vendor/*" \
    -not -path "*/node_modules/*" \
    -exec grep -l "docs/phpstan/level_" {} \;)

if [ -n "$files_to_update" ]; then
    log_warn "Altri file con collegamenti da aggiornare:"
    echo "$files_to_update"
else
    log_info "Nessun altro file con collegamenti da aggiornare"
fi
