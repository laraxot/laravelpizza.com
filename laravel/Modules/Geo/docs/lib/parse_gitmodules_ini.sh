#!/bin/bash


parse_gitmodules() {
    INPUT_FILE="$1"
    # Controlla se il file esiste
    if [ ! -f "$INPUT_FILE" ]; then
        echo "Errore: Il file $INPUT_FILE non esiste"
        exit 1
    fi

    # Inizializza l'array associativo per tutti i sottmoduli
    declare -g -A submodules_array

    index=0
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
            
            submodules_array["path_${index}"]="$current_path"
            submodules_array["url_${index}"]="$current_url"
            ((index++))
            
            # Pulizia: reset delle variabili per il prossimo modulo
            current_path=""
            current_url=""
        fi
    done < "$INPUT_FILE"

    # Memorizza il numero totale di moduli
    submodules_array["total"]="$index"
    return 0
}

# Accesso ai valori
#total=${submodules_array["total"]}
#for ((i=0; i<total; i++)); do
#    echo "Submodule $i:"
#    echo "  Path: ${submodules_array["path_${i}"]}"
#    echo "  URL: ${submodules_array["url_${i}"]}"
#done