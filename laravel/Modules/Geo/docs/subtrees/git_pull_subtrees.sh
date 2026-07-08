#!/bin/bash

# 🚀 Importa funzioni di utilità
source ./bashscripts/lib/custom.sh
source ./bashscripts/lib/parse_gitmodules_ini.sh

# 📌 Configurazione
me=$(readlink -f -- "$0")
script_dir=$(dirname "$me")
ORG="$1"

# 🔄 Esegui backup e configurazione
backup_disk || {
    log "error" "Backup fallito"
    exit 1
}

# ⚙️ Configurazione git
git_config_setup

# 🔄 Parsing dei submodule
parse_gitmodules gitmodules.ini

# 🔄 Processo di pull per ogni submodule
total=${submodules_array["total"]}
for ((i=0; i<total; i++)); do
    path=${submodules_array["path_${i}"]}
    url=${submodules_array["url_${i}"]}
    
    # 🔄 Riscrittura URL se ORG è passato
    if [ -n "$ORG" ]; then
        url_org=$(rewrite_url "$url" "$ORG")
        script="$script_dir/git_push_subtree_org.sh"
        
        # 🔒 Impostazione permessi e normalizzazione
        chmod +x "$script" || log "warning" "Impossibile impostare permessi per $script"
        sed -i -e 's/\r$//' "$script" || log "warning" "Impossibile normalizzare $script"
        
        # 📤 Push con ORG
        if ! "$script" "$path" "$url_org" "$BRANCH"; then
            log "warning" "Push ORG fallita per $path"
        fi
    fi
    
    log "info" "Submodule $i - Path: $path - URL: $url"
    
    # 📥 Pull subtree
    script="$script_dir/git_pull_subtree.sh"
    chmod +x "$script" || log "warning" "Impossibile impostare permessi per $script"
    sed -i -e 's/\r$//' "$script" || log "warning" "Impossibile normalizzare $script"
    
    log "info" "Pull modulo: $path"
    if ! "$script" "$path" "$url"; then
        log "warning" "Pull fallita per $path"
    fi
done

log "success" "Pull completato per tutti i submodule"
