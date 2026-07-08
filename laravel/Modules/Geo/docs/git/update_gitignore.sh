#!/bin/bash

# Directory base
BASE_DIR="/var/www/html/_bases/base_ptvx_fila5_mono"

# Funzione per aggiornare un singolo file .gitignore
update_gitignore() {
    local file="$1"
    
    # Verifica se *.bak è già presente
    if ! grep -q "^\*\.bak$" "$file"; then
        echo "Aggiornamento $file"
        # Aggiungi *.bak in una nuova riga
        echo -e "\n# Backup files\n*.bak" >> "$file"
    fi
}

# Trova e aggiorna tutti i file .gitignore
find "$BASE_DIR" -name ".gitignore" -type f | while read -r file; do
    update_gitignore "$file"
done

echo "Aggiornamento file .gitignore completato!" 