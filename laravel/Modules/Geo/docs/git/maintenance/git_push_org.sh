#!/bin/bash

# Script per il push automatico delle modifiche al repository remoto
# Questo script gestisce il push delle modifiche con gestione degli errori e logging

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

# Verifica se siamo in un repository Git
if ! git rev-parse --is-inside-work-tree > /dev/null 2>&1; then
    log_error "Non siamo in un repository Git"
    exit 1
fi

# Verifica se ci sono modifiche da committare
if ! git diff-index --quiet HEAD --; then
    log_info "Trovate modifiche non committate"
    
    # Chiedi conferma per il commit
    read -p "Vuoi committare le modifiche? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        # Commit delle modifiche
        git add .
        read -p "Inserisci il messaggio di commit: " commit_message
        git commit -m "$commit_message"
        log_info "Modifiche committate con successo"
    else
        log_warn "Commit annullato"
        exit 1
    fi
fi

# Verifica se ci sono commit da pushare
if ! git rev-list origin/$(git rev-parse --abbrev-ref HEAD)..HEAD > /dev/null 2>&1; then
    log_info "Nessun commit da pushare"
    exit 0
fi

# Push delle modifiche
log_info "Push delle modifiche in corso..."
if git push origin $(git rev-parse --abbrev-ref HEAD); then
    log_info "Push completato con successo"
else
    log_error "Errore durante il push"
    exit 1
fi

# Verifica se ci sono conflitti
if git diff --name-only --diff-filter=U | grep -q .; then
    log_warn "Trovati conflitti da risolvere"
    git diff --name-only --diff-filter=U
    exit 1
fi

log_info "Operazione completata con successo"