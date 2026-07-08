#!/bin/bash

source ./bashscripts/lib/custom.sh

# Validate input
if [ $# -lt 2 ] || [ $# -gt 3 ]; then
    log "error" "Parametri errati"
    log "info" "Uso: $0 <path> <remote_repo> [branch]"
    exit 1
fi

LOCAL_PATH="$1"
REMOTE_REPO="$2"
BRANCH="${3:-main}"  # Usa il terzo parametro se fornito, altrimenti "main"

curr_dir=$(pwd)

log "info" "Inizializzazione push per $LOCAL_PATH verso $REMOTE_REPO (branch: $BRANCH)"

cd "$LOCAL_PATH" || handle_error "Impossibile accedere a $LOCAL_PATH"

# Inizializzazione repository locale
log "info" "Inizializzazione repository locale"
git init || handle_git_error "git init" "Impossibile inizializzare il repository"

# Configurazione git
log "info" "Configurazione git"
git_config_setup

# Creazione branch
log "info" "Creazione branch $BRANCH"
git checkout -b "$BRANCH" || handle_git_error "git checkout" "Impossibile creare il branch $BRANCH"

# Configurazione remote
log "info" "Configurazione remote origin"
git remote add origin "$REMOTE_REPO" || handle_git_error "git remote add" "Impossibile aggiungere il remote origin"

# Fetch e merge
log "info" "Fetch da remote"
git fetch --all --depth=1 || handle_git_error "git fetch" "Impossibile eseguire fetch"

# Aggiunta e commit dei file
log "info" "Commit dei file locali"
git add -A
git commit -m "Inizializzazione repository" || true  # Non fallire se non ci sono cambiamenti

# Merge con remote
log "info" "Merge con remote"
git pull origin "$BRANCH" --autostash --rebase --allow-unrelated-histories --depth=1 || true

# Gestione conflitti
while true; do
    # Tenta il push
    if git push -u origin HEAD:"$BRANCH" 2>/dev/null; then
        log "success" "Push completato con successo"
        break
    fi

    # Se il push fallisce, prova il rebase
    git pull --rebase origin "$BRANCH"

    # Se ci sono conflitti
    if [ $? -ne 0 ]; then
        log "warning" "Rilevati conflitti, tentativo di risoluzione automatica..."
        git add -A
        git rebase --continue

        # Se il rebase fallisce, annulla e riprova
        if [ $? -ne 0 ]; then
            log "warning" "Impossibile risolvere automaticamente, annullo il rebase..."
            git rebase --abort
            git reset --hard HEAD
            git pull origin "$BRANCH" --autostash --rebase --allow-unrelated-histories --depth=1
        fi
    fi
done

# Pulizia
log "info" "Pulizia repository locale"
rm -rf .git

# Ritorno alla directory originale
cd "$curr_dir" || handle_error "Impossibile tornare alla directory originale"

log "success" "Push ORG completato con successo"
