#!/bin/bash

# 🎨 Colori per il logging
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# 📝 Funzione di logging
log() {
    local level="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    case "$level" in
        "error") echo -e "${RED}❌ [$timestamp] $message${NC}" | tee -a "$LOG_FILE" ;;
        "success") echo -e "${GREEN}✅ [$timestamp] $message${NC}" | tee -a "$LOG_FILE" ;;
        "warning") echo -e "${YELLOW}⚠️ [$timestamp] $message${NC}" | tee -a "$LOG_FILE" ;;
        "info") echo -e "ℹ️ [$timestamp] $message" | tee -a "$LOG_FILE" ;;
    esac
}

# 🚀 Importa funzioni di utilità
source ./bashscripts/lib/custom.sh

# ✅ Validazione input
if [ $# -ne 2 ]; then
    log "error" "Parametri mancanti"
    log "info" "Uso: $0 <path> <remote_repo>"
    exit 1
fi

# 📌 Configurazione
LOCAL_PATH="$1"
LOCAL_PATH_BAK="${LOCAL_PATH}_bak"
REMOTE_REPO="$2"
REMOTE_BRANCH=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")
TEMP_BRANCH=$(basename "$LOCAL_PATH")-temp
LOG_FILE="subtree_sync.log"

# Mostra informazioni di configurazione
log "info" "📁 Path: $LOCAL_PATH"
log "info" "🌐 URL: $REMOTE_REPO"
log "info" "🌐 Branch: $REMOTE_BRANCH"
log "info" "🌐 Temporary branch: $TEMP_BRANCH"

# 🔍 Verifica prerequisiti
if [ ! -e "$LOCAL_PATH" ]; then
    log "error" "Il path $LOCAL_PATH non esiste"
    exit 1
fi

if ! git ls-remote "$REMOTE_REPO" > /dev/null 2>&1; then
    log "error" "Repository remoto $REMOTE_REPO non trovato"
    exit 1
fi

# 🔄 Funzione per il pull del subtree
pull_subtree() {
    log "info" "Inizio pull subtree"
    
    # 🛠️ Setup iniziale
    git_config_setup
    
    # 🧹 Pulizia file temporanei
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
    
    # 💾 Commit locale
    git add -A || log "warning" "Errore nell'add"
    git commit -am "🔄 Aggiornamento subtree" || log "info" "Nessun cambiamento da committare"
    git push -u origin "$REMOTE_BRANCH" || log "warning" "Errore nel push"
    
    # 📥 Pull subtree
    log "info" "Tentativo pull subtree standard"
    if ! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH" --squash; then
        log "warning" "Pull standard fallito, tentativo alternativo"
        
        if ! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"; then
            log "warning" "Pull alternativo fallito, procedo con split e merge"
            
            # 🔄 Split e merge
            git subtree split --prefix="$LOCAL_PATH" -b "$TEMP_BRANCH" || log "error" "Errore nello split"
            git subtree merge --prefix="$LOCAL_PATH" "$TEMP_BRANCH" || log "error" "Errore nel merge"
            git branch -D "$TEMP_BRANCH" || log "warning" "Impossibile eliminare branch temporaneo"
            
            # 📦 Backup e ripristino
            mv "$LOCAL_PATH" "$LOCAL_PATH_BAK" || log "error" "Errore nel backup"
            git add . || log "warning" "Errore nell'add post-backup"
            git commit -am "📦 Backup $LOCAL_PATH" || log "warning" "Errore nel commit backup"
            git push -u origin "$REMOTE_BRANCH" || log "warning" "Errore nel push backup"
            
            # 🔄 Ripristino
            git subtree add --prefix="$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH" --squash || log "error" "Errore nell'add subtree"
            rsync -avz "$LOCAL_PATH_BAK/" "$LOCAL_PATH" || log "error" "Errore nella sincronizzazione"
            
            # 🧹 Pulizia
            rm -rf "$LOCAL_PATH_BAK" || log "warning" "Impossibile rimuovere backup"
            git add . || log "warning" "Errore nell'add finale"
            git commit -am "🔄 Ripristino subtree $LOCAL_PATH" || log "warning" "Errore nel commit finale"
            git push -u origin "$REMOTE_BRANCH" || log "warning" "Errore nel push finale"
        fi
    fi
    
    # 🛠️ Manutenzione
    git rebase --rebase-merges --strategy subtree "$REMOTE_BRANCH" --autosquash || log "warning" "Errore nel rebase"
    git_maintenance
}

# 🚀 Esecuzione
pull_subtree

log "success" "Subtree $LOCAL_PATH pullato con successo da $REMOTE_REPO"
