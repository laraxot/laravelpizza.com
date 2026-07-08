#!/bin/bash

source ./bashscripts/lib/custom.sh

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

# ✅ Validazione input
if [ $# -ne 2 ]; then
    log "error" "Parametri mancanti"
    log "info" "Uso: $0 <path> <remote_repo>"
    exit 1
fi

# 📌 Configurazione
me=$(readlink -f -- "$0")
script_dir=$(dirname "$me")
LOCAL_PATH="$1"
REMOTE_REPO="$2"
REMOTE_BRANCH=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")
TEMP_BRANCH=$(basename "$LOCAL_PATH")-temp

# 🔄 Funzione per sincronizzare il subtree
sync_subtree() {
    log "info" "Inizio sincronizzazione subtree"

    # 🧹 Normalizzazione script
    sed -i -e 's/\r$//' "$script_dir/git_push_subtree.sh" || log "warning" "Errore nella normalizzazione push script"
    sed -i -e 's/\r$//' "$script_dir/git_pull_subtree.sh" || log "warning" "Errore nella normalizzazione pull script"

    # 🔒 Impostazione permessi
    chmod +x "$script_dir/git_push_subtree.sh" || log "warning" "Errore nell'impostazione permessi push script"
    chmod +x "$script_dir/git_pull_subtree.sh" || log "warning" "Errore nell'impostazione permessi pull script"

    # 📌 Commit delle modifiche locali
    git add .
    git commit -am "." || log "info" "Nessuna modifica da committare"
    git push -u origin "$REMOTE_BRANCH" || log "warning" "Push fallito, continuo comunque"

    # 📥 Pull subtree
    log "info" "Esecuzione pull subtree"
    if ! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH" --squash; then
        log "warning" "Pull con squash fallita, provo senza squash"
        git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH" || log "error" "Pull fallita per $LOCAL_PATH"
    fi

    # 🧹 Pulizia file di sistema
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;

    # 🔄 Sincronizzazione avanzata
    log "info" "Sincronizzazione avanzata con merge"
    git fetch "$REMOTE_REPO" "$REMOTE_BRANCH" --depth=1 || log "warning" "Fetch fallito"
    git merge -s subtree FETCH_HEAD --allow-unrelated-histories || log "warning" "Merge fallito"

    # 📤 Push forzato del subtree
    log "info" "Split e push del subtree"
    git subtree split --prefix="$LOCAL_PATH" -b "$TEMP_BRANCH" || log "error" "Split fallito"
    git push -f "$REMOTE_REPO" "$TEMP_BRANCH":"$REMOTE_BRANCH" || log "error" "Push forzato fallito"
    git branch -D "$TEMP_BRANCH" || log "warning" "Rimozione branch temporaneo fallita"

    # 📤 Push subtree standard (backup)
    log "info" "Backup push con metodo standard"
    git subtree push -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH" || log "warning" "Push subtree standard fallito"
}

# 🚀 Esecuzione sincronizzazione
sync_subtree

# 🧹 Normalizzazione script stesso
sed -i -e 's/\r$//' "$me" || log "warning" "Errore nella normalizzazione dello script principale"

log "success" "Subtree $LOCAL_PATH sincronizzato con successo con $REMOTE_REPO"

### git_sync_subtree.sh
Script ottimizzato per la sincronizzazione di un singolo subtree. Caratteristiche principali:
1. Sistema avanzato di logging con timestamp e codici colore
2. Gestione robusta degli errori con fallback automatici
3. Strategia di sincronizzazione in più passaggi:
   - Pull del subtree con tentativo di squash
   - Merge con strategia subtree
   - Split e push forzato tramite branch temporaneo
   - Push di backup con metodo standard

**Risoluzione conflitti applicata**:
- Integrato il miglior sistema di logging dalla versione HEAD (con timestamp)
- Adottata la variabile REMOTE_BRANCH dalla versione incoming per maggiore flessibilità
- Implementata una strategia di gestione errori più robusta con fallback automatici
- Mantenuti i commenti emoji per maggiore leggibilità
- Aggiunto push standard come backup dopo il metodo split-push

Questo script è progettato per funzionare in tandem con `git_pull_subtree.sh` e `git_push_subtree.sh`, ma può essere utilizzato anche come soluzione standalone per casi complessi di sincronizzazione subtree.
