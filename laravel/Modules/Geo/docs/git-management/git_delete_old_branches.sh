#!/bin/bash

# 🚀 Importa funzioni di utilità
source ./bashscripts/lib/custom.sh

# 📌 Configurazione
me=$(readlink -f -- "$0")
script_dir=$(dirname "$me")

# 🔄 Esegui script ricorsivamente sui submodule
log "info" "Esecuzione script sui submodule..."
git submodule foreach "$me"

# 📋 Branch da mantenere
branches_to_keep="dev master prod"

# 🔄 Itera su tutti i remote configurati
for remote in $(git remote); do
    log "info" "Verifica remote: $remote"

    # 📋 Ottieni la lista di tutti i branch remoti, escludendo quelli da mantenere
    branches_to_delete=$(git branch -r | grep "remotes/$remote/" | sed "s#remotes/$remote/##" | grep -v -E "^(dev|master|prod)$")

    # 🗑️ Cancella solo se ci sono branch da eliminare
    if [ -n "$branches_to_delete" ]; then
        for branch in $branches_to_delete; do
            log "info" "Eliminazione branch '$branch' dal remote '$remote'..."
            if git push "$remote" --delete "$branch"; then
                log "success" "Branch '$branch' eliminato con successo"
            else
                log "error" "Errore nell'eliminazione del branch '$branch'"
            fi
        done
    else
        log "info" "Nessun branch da eliminare per il remote '$remote'"
    fi
done

# Elimina i branch vecchi
for branch in $(git branch -r | grep -v HEAD | grep -v "$branches_to_keep"); do
    git branch -d "$branch"
    log "info" "Branch locale '$branch' eliminato"
done

log "success" "Pulizia branch completata"
