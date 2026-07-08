#!/bin/bash
# Script per sincronizzare repository Git tra organizzazioni
# Uso: ./git_sync_org.sh <org> <branch> [--no-confirm]
set -euo pipefail

# Colori e contatori
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'
TOTAL=0
SYNCED=0
SKIPPED=0
FAILED=0

# Log
log_info() { echo -e "${GREEN}[INFO]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[WARN]${NC} $1"; }
log_error() { echo -e "${RED}[ERROR]${NC} $1"; }

# Sincronizza repository
sync_repo() {
    cd "$1" || return 1
    REPO_NAME=$(basename "$1")
    log_info "Sync: $REPO_NAME"
    
    # URL remotes
    ORIG_REMOTE=$(git config --get remote.origin.url)
    REPO_NAME=$(basename "$ORIG_REMOTE" .git)
    NEW_REMOTE="git@github.com:$2/$REPO_NAME.git"
    
    # Verifica esistenza repository
    if ! git ls-remote --exit-code "$NEW_REMOTE" &>/dev/null; then
        log_warn "Repository non trovato in $2"
        ((SKIPPED++))
        ((TOTAL++))
        return 0
    fi
    
    # Pulizia e commit
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \; &>/dev/null || true
    git add -A &>/dev/null || true
    git diff --quiet --cached &>/dev/null || git commit -m "Sync $(date +"%Y-%m-%d %H:%M:%S")" || true
    
    # Cambia remote, pull/push e ripristina
    git remote set-url origin "$NEW_REMOTE"
    git pull origin "$3" || true
    
    if git push -u origin HEAD:"$3"; then
        log_info "Push completato!"
        ((SYNCED++))
    else
        log_warn "Push fallito"
        ((FAILED++))
    fi
    
    git checkout "$3" &>/dev/null || true
    git remote set-url origin "$ORIG_REMOTE"
    
    ((TOTAL++))
    return 0
}

# Elabora parametri
if [ "$#" -lt 2 ] || [ "$1" = "--help" ]; then
    echo "Uso: $0 <org> <branch> [--no-confirm]"
    echo "Esempio: $0 nuova-org main"
    exit 0
fi

NEW_ORG="$1"
BRANCH="$2"
NO_CONFIRM=false
[ "$#" -gt 2 ] && [ "$3" = "--no-confirm" ] && NO_CONFIRM=true
SCRIPT_PATH=$(readlink -f "$0")
MAIN_REPO=$(pwd)

# Verifica Git
git rev-parse --is-inside-work-tree &>/dev/null || { log_error "Devi essere in un repository Git!"; exit 1; }

# Conferma
echo "Operazione: sync con $NEW_ORG su branch $BRANCH"
if [ "$NO_CONFIRM" = false ]; then
    echo -e "${YELLOW}Procedere? [Y/n]${NC}"
    read -r response
    [[ ! "${response:-y}" =~ ^[Yy] ]] && { log_info "Annullato."; exit 0; }
fi

# Submoduli
SUBMODULE_COUNT=$(git submodule | wc -l)
if [ "$SUBMODULE_COUNT" -gt 0 ]; then
    log_info "Trovati $SUBMODULE_COUNT submodule"
    set +e
    git submodule foreach "$SCRIPT_PATH" "$NEW_ORG" "$BRANCH" $([ "$NO_CONFIRM" = true ] && echo "--no-confirm") || true
    set -e
fi

# Sincronizza repo principale
set +e
sync_repo "$MAIN_REPO" "$NEW_ORG" "$BRANCH"
set -e

# Riepilogo
echo -e "\nRiepilogo: $TOTAL totali, $SYNCED sync, $SKIPPED saltati, $FAILED falliti"
[ "$FAILED" -gt 0 ] && log_warn "Alcuni repository richiedono attenzione manuale"
echo "Completato!"
