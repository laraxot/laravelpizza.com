#!/bin/bash

# 🚀 Importa le funzioni di utilità
source ./bashscripts/lib/custom.sh

# ✅ Validazione input
if [ $# -ne 2 ]; then
    log "error" "Parametri mancanti"
    log "info" "Uso: $0 <path> <remote_repo>"
    exit 1
fi

# 📌 Configurazione
LOCAL_PATH="$1"
REMOTE_REPO="$2"
TEMP_BRANCH=$(basename "$LOCAL_PATH")-temp

# 🎯 Log iniziale
log "info" "Inizio push subtree"
log "info" "📁 Path locale: $LOCAL_PATH"
log "info" "🌐 Repository remoto: $REMOTE_REPO"
log "info" "🌿 Branch: $BRANCH"
log "info" "🌿 Branch temporaneo: $TEMP_BRANCH"

# 🔍 Verifica prerequisiti
if [ ! -e "$LOCAL_PATH" ]; then
    handle_git_error "verifica path" "Il path $LOCAL_PATH non esiste"
fi

if ! git ls-remote "$REMOTE_REPO" > /dev/null 2>&1; then
    handle_git_error "verifica remote" "Repository remoto $REMOTE_REPO non trovato"
fi

# 🔄 Funzione per il push del subtree
push_subtree() {
    log "info" "Inizio push subtree"
    
    # 🛠️ Setup iniziale
    git_config_setup
    
    # 🧹 Pulizia file temporanei
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
    
    # 💾 Commit locale
    git add -A || handle_git_error "add" "Errore nell'add"
    git commit -am "🔄 Aggiornamento subtree" || handle_git_error "commit" "Errore nel commit"
    git push -u origin "$BRANCH" || handle_git_error "push" "Errore nel push"
    
    # Pulizia file temporanei (nuovamente, per sicurezza)
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
    
    # 📤 Push subtree
    log "info" "Tentativo push subtree standard"
    if ! git subtree push -P "$LOCAL_PATH" "$REMOTE_REPO" "$BRANCH"; then
        log "warning" "Push standard fallito, tentativo con split"
        
        # 🔄 Fetch e split
        git fetch "$REMOTE_REPO" "$BRANCH"
        if ! git subtree split --rejoin --prefix="$LOCAL_PATH" -b "$TEMP_BRANCH"; then
            handle_git_error "split" "Errore nello split"
        else
            log "success" "Subtree $LOCAL_PATH splittato correttamente"
        fi
        
        # Push del branch temporaneo
        if ! git push "$REMOTE_REPO" "$TEMP_BRANCH":"$BRANCH"; then
            handle_git_error "push" "Errore nel push del branch temporaneo"
        else
            log "success" "Subtree $LOCAL_PATH pushato correttamente su $REMOTE_REPO"
        fi
        
        # Pulizia
        git branch -D "$TEMP_BRANCH" || log "warning" "Impossibile eliminare branch temporaneo"
    fi
    
    # 🛠️ Manutenzione
    git rebase --rebase-merges --strategy subtree "$BRANCH" --autosquash || log "warning" "Errore nel rebase"
    git_maintenance
}

# 🚀 Esecuzione
push_subtree

log "success" "Subtree $LOCAL_PATH pushato con successo su $REMOTE_REPO"
