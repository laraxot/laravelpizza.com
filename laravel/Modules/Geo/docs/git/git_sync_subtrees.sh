#!/bin/bash
me=$( readlink -f -- "$0")
script_dir=$(dirname "$me")
CUSTOM_ORG="$1"
CUSTOM_ORG="$1"

# Script per sincronizzare git subtree con ottimizzazione della history
CONFIG_FILE="gitmodules.ini"
DEPTH=1  # Limita la profondità della history scaricata
LOG_FILE="subtree_sync.log"

# Funzione per loggare messaggi
log() {
    local message="$1"
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $message" | tee -a "$LOG_FILE"
}

# Funzione per gestire gli errori
handle_error() {
    local error_message="$1"
    log "❌ Errore: $error_message"
    exit 1
}

# Verifica che il file di configurazione esista
if [[ ! -f $CONFIG_FILE ]]; then
    handle_error "File $CONFIG_FILE non trovato!"
fi

# Ottieni il branch corrente
current_branch=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")
log "🌿 Branch corrente: $current_branch"

# Processa le righe del file di configurazione
while IFS= read -r line; do
    # Salta righe vuote e commenti
    [[ -z "$line" || "$line" =~ ^[[:space:]]*# ]] && continue
    
    # Rimuovi spazi e CR
    line=$(echo "$line" | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')
    
    # Estrai i valori path e url
    if [[ "$line" =~ ^path\ *=\ *(.+)$ ]]; then
        current_path="${BASH_REMATCH[1]}"
    elif [[ "$line" =~ ^url\ *=\ *(.+)$ && -n "$current_path" ]]; then
        current_url="${BASH_REMATCH[1]}"

         # Modifica l'organizzazione nell'URL se CUSTOM_ORG è fornito
        if [[ -n "$CUSTOM_ORG" && "$current_url" =~ git@github.com:([^/]+)/(.+)$ ]]; then
            # Estrae la parte originale dell'organizzazione e il repository
            original_org="${BASH_REMATCH[1]}"
            repo_name="${BASH_REMATCH[2]}"
            
            # Sostituisce l'organizzazione con quella personalizzata
            current_url="git@github.com:${CUSTOM_ORG}/${repo_name}"
        #    log "🔄 URL modificato: $current_url (org originale: $original_org → $CUSTOM_ORG)"
        fi
        
        # Chiamata esterna allo script di sincronizzazione
        log "🔄 Sincronizzazione modulo: $current_path [$current_url]"
        
        # Chiamata esterna allo script di sincronizzazione
        log "🔄 Sincronizzazione modulo: $current_path"
        
        # Chiamata esterna allo script di sincronizzazione
        log "🔄 Sincronizzazione modulo: $current_path [$current_url]"
        
        # Chiamata esterna allo script di sincronizzazione
        log "🔄 Sincronizzazione modulo: $current_path"
        if ! "$script_dir/git_sync_subtree.sh" "$current_path" "$current_url" ; then
            log "⚠️ Sincronizzazione fallita per $current_path."
        fi
        
        # Pulizia: reset delle variabili per il prossimo modulo
        current_path=""
        current_url=""
    fi
done < "$CONFIG_FILE"

# Esegui git gc per mantenere il repository leggero
log "🧹 Pulizia del repository..."
git gc --prune=now --aggressive
sed -i -e 's/\r$//' "$me"
log "✅ Sincronizzazione completata con history ottimizzata!"

log "✅ Sincronizzazione completata con history ottimizzata!"
sed -i -e 's/\r$//' "$me"
log "✅ Sincronizzazione completata con history ottimizzata!"

log "✅ Sincronizzazione completata con history ottimizzata!"
