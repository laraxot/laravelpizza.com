#!/bin/bash

# 🎨 Colori per il logging
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# LOG_FILE="subtree_sync.log"  # Rimosso: non si scrive più su file
BRANCH=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")

# Funzione avanzata per loggare messaggi
log() {
    # Supporta sia il formato avanzato con livelli che il formato semplice
    if [ $# -eq 2 ]; then
        # Formato avanzato: log "level" "message"
        local level="$1"
        local message="$2"
        local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
        case "$level" in
            "error") echo -e "${RED}❌ [$timestamp] $message${NC}" ;;
            "success") echo -e "${GREEN}✅ [$timestamp] $message${NC}" ;;
            "warning") echo -e "${YELLOW}⚠️ [$timestamp] $message${NC}" ;;
            "info") echo -e "${BLUE}ℹ️ [$timestamp] $message${NC}" ;;
            *) echo -e "[$timestamp] $message" ;;
        esac
    else
        # Formato semplice: log "message"
        local message="$1"
        local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
        echo "📆 $timestamp - $message"
    fi
}

# Funzione avanzata per gestire gli errori git
handle_git_error() {
    local operation="$1"
    local error_message="$2"
    local retry_count="${3:-3}"

    log "error" "Errore durante $operation: $error_message"

    if [ $retry_count -gt 0 ]; then
        log "warning" "Tentativo di ripetere l'operazione ($retry_count tentativi rimasti)"
        return 1
    else
        log "error" "Tentativi esauriti per $operation"
        exit 1
    fi
}

# Funzione per gestire gli errori generici
handle_error() {
    local error_message="$1"
    log "error" "$error_message"
    exit 1
}

# Funzione semplice per terminare con errore
die() {
    echo "$1" >&2
    exit 1
}

# Funzione per verificare l'integrità del repository
check_repository_integrity() {
    log "info" "Verifica integrità repository..."

    if ! git fsck --full --strict; then
        handle_git_error "verifica integrità" "Problemi riscontrati nel repository"
    fi

    if ! git diff --quiet; then
        log "warning" "Ci sono modifiche non committate nel repository"
    fi
}

# Funzione per riscrivere la URL secondo le regole specificate
rewrite_url() {
    local original_url="$1"
    local org="$2"

    # Estrai solo il nome del repository (ultimo componente dopo lo slash)
    repo_name=$(basename "$original_url")

    if [[ "$org" == *"/"* ]]; then
        # ORG contiene uno slash → usa direttamente come prefisso
        echo "${org}/${repo_name}"
    else
        # ORG è un'organizzazione GitHub → usa formato GitHub SSH
        echo "git@github.com:${org}/${repo_name}"
    fi
}

# Funzione avanzata per la manutenzione git
git_maintenance() {
    log "info" "Eseguo manutenzione avanzata del repository git..."

    # Backup automatico prima della manutenzione
    local backup_branch="backup-$(date +%Y%m%d-%H%M%S)"
    git branch "$backup_branch" || handle_git_error "creazione backup" "Impossibile creare branch di backup"

    # Pulizia e ottimizzazione
    git gc --aggressive --prune=now || handle_git_error "garbage collection" "Errore durante la pulizia"
    git reflog expire --expire=now --all || handle_git_error "pulizia reflog" "Errore durante la pulizia reflog"

    # Rimozione branch remoti non più esistenti
    git remote prune origin || handle_git_error "pulizia remote" "Errore durante la pulizia dei remote"

    # Pulizia dei file non tracciati
    git clean -fd || handle_git_error "pulizia file" "Errore durante la pulizia dei file"

    # Verifica finale
    check_repository_integrity

    log "success" "Manutenzione completata con successo"
}

# Funzione avanzata per configurare le impostazioni git
git_config_setup() {
    log "info" "Configurazione avanzata git..."

    # Configurazioni base
    git config core.ignorecase false || handle_git_error "configurazione" "Errore impostazione ignorecase"
    git config core.fileMode false || handle_git_error "configurazione" "Errore impostazione fileMode"
    git config core.autocrlf false || handle_git_error "configurazione" "Errore impostazione autocrlf"
    git config core.eol lf || handle_git_error "configurazione" "Errore impostazione eol"
    git config core.symlinks false || handle_git_error "configurazione" "Errore impostazione symlinks"
    git config core.longpaths true || handle_git_error "configurazione" "Errore impostazione longpaths"

    # Configurazioni avanzate
    git config pull.rebase true || handle_git_error "configurazione" "Errore impostazione pull.rebase"
    git config fetch.prune true || handle_git_error "configurazione" "Errore impostazione fetch.prune"

    log "success" "Configurazione git completata con successo"
}

backup_disk() {
    # Richiesta interattiva della lettera del disco
    read -p "📀 Inserisci la lettera del disco per il backup [d]: " DISK_LETTER
    DISK_LETTER=${DISK_LETTER:-"d"}  # Se non specificato, usa 'd' come default
    # Backup to disk
    if ! ./bashscripts/utils/sync_to_disk.sh "$DISK_LETTER" ; then
        handle_error "Failed to sync to disk $DISK_LETTER"
    fi

    echo "  💾 Backup Disk: $DISK_LETTER"
}

restore_disk() {
    # Richiesta interattiva della lettera del disco
    read -p "📀 Inserisci la lettera del disco da cui ripristinare [d]: " DISK_LETTER
    DISK_LETTER=${DISK_LETTER:-"d"}  # Se non specificato, usa 'd' come default

    # Verifica che il disco sia montato
    BACKUP_DIR="/mnt/$DISK_LETTER/var/www/html/_bases"
    if [ ! -d "$BACKUP_DIR" ]; then
        handle_error "Il disco $DISK_LETTER non è montato o la directory di backup non esiste"
        return 1
    fi

    log "info" "Ricerca backup disponibili su disco $DISK_LETTER..."

    # Trova gli ultimi 10 backup ordinati per data (più recenti prima)
    BACKUPS=($(ls -t "$BACKUP_DIR"/*.tar.gz 2>/dev/null | head -10))

    if [ ${#BACKUPS[@]} -eq 0 ]; then
        handle_error "Nessun backup trovato sul disco $DISK_LETTER"
        return 1
    fi

    echo -e "\nBackup disponibili sul disco $DISK_LETTER:\n"

    # Mostra i backup disponibili con radio button
    for i in ${!BACKUPS[@]}; do
        BACKUP_NAME=$(basename "${BACKUPS[$i]}")
        echo "[$((i+1))] $BACKUP_NAME"
    done

    # Richiedi la selezione
    echo ""
    read -p "Seleziona il backup da ripristinare [1-${#BACKUPS[@]}]: " SELECTION

    # Verifica che la selezione sia valida
    if ! [[ "$SELECTION" =~ ^[0-9]+$ ]] || [ "$SELECTION" -lt 1 ] || [ "$SELECTION" -gt ${#BACKUPS[@]} ]; then
        handle_error "Selezione non valida"
        return 1
    fi

    # Calcola l'indice dell'array (0-based)
    SELECTION=$((SELECTION-1))
    SELECTED_BACKUP="${BACKUPS[$SELECTION]}"
    BACKUP_NAME=$(basename "$SELECTED_BACKUP")

    echo -e "\n🔄 Ripristino di $BACKUP_NAME in corso..."

    # Chiama lo script restore_from_disk.sh
    if ! ./bashscripts/utils/restore_from_disk.sh "$DISK_LETTER" "$SELECTED_BACKUP"; then
        handle_error "Errore durante il ripristino del backup"
        return 1
    fi

    log "success" "Ripristino completato con successo"
}

git_delete_history() {
    local branch="$1"
    git checkout --orphan newBranch$branch
    git add --renormalize -A
    git add -A  # Add all files and commit them
    git commit -am "first"
    git branch -D $branch  # Deletes the $1 branch
    git branch -m $branch  # Rename the current branch to $1
    git gc --aggressive --prune=all     # remove the old files
    git push -uf origin $branch  # Force push $1 branch to github
    git gc --aggressive --prune=all     # remove the old files
    git gc --auto
}

dummy_push(){
    local org="$1"
    local branch="$2"
    local msg="${3:-.}"  # Se il messaggio non è specificato, usa "."
    # 🧹 Pulizia file temporanei
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
    git add -A
    git commit -am "$msg"
    git push -u "$org" HEAD:"$branch"
}

declare -A PARSED_KV  # Dizionario globale (o può essere passato per riferimento)

parse_args() {
    local _target=""
    PARSED_KV=()  # Reset del dizionario

    for arg in "$@"; do
        if [[ "$arg" == --*=* ]]; then
            local key="${arg%%=*}"
            local value="${arg#*=}"
            key="${key#--}"
            PARSED_KV["$key"]="$value"
        else
            if [ -z "$_target" ]; then
                _target="$arg"
            fi
        fi
    done

    if [ -z "$_target" ]; then
        echo "❌ Argomento principale (es: branch) mancante" >&2
        return 1
    fi

    # Restituisci il target principale tramite nome di variabile passato
    eval "$1='$_target'"
}


# Funzione per verificare se un comando esiste
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Funzione per verificare se un file esiste
file_exists() {
    [ -f "$1" ]
}

# Funzione per verificare se una directory esiste
dir_exists() {
    [ -d "$1" ]
}

# Funzione per verificare se un file è eseguibile
is_executable() {
    [ -x "$1" ]
}

# Funzione per verificare se un file è leggibile
is_readable() {
    [ -r "$1" ]
}

# Funzione per verificare se un file è scrivibile
is_writable() {
    [ -w "$1" ]
}