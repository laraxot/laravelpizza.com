#!/bin/bash


source ./bashscripts/lib/custom.sh
# Includi lo script di parsing
source ./bashscripts/lib/parse_gitmodules_ini.sh

# Chiama la funzione
parse_gitmodules gitmodules.ini

me=$( readlink -f -- "$0")
script_dir=$(dirname "$me")

total=${submodules_array["total"]}
for ((i=0; i<total; i++)); do
    path=${submodules_array["path_${i}"]}
    url=${submodules_array["url_${i}"]}
    echo "---------"
    echo "Submodule $i:"
    echo "  📁 Path: $path"
    echo "  🌐 URL: $url"
    script="$script_dir/git_sync_subtree.sh"
    chmod +x "$script"
    sed -i -e 's/\r$//' "$script"
    
    # Chiamata esterna allo script di sincronizzazione
    log "🔄 Push modulo: $path"
    if ! "$script" "$path" "$url" ; then
        log "⚠️ Push fallita per $path."
    fi
done
