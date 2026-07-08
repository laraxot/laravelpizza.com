#!/bin/bash

# Funzione per creare la struttura delle traduzioni
create_translation_structure() {
    local module_path=$1
    local module_name=$(basename "$module_path")
    
    echo "Creazione struttura traduzioni per $module_name"
    
    # Crea le directory per le traduzioni
    mkdir -p "$module_path/docs/{it,en}"
    
    # Trova tutti i file .md nella cartella docs
    find "$module_path/docs" -type f -name "*.md" | while read -r file; do
        # Ottieni il percorso relativo
        rel_path=$(realpath --relative-to="$module_path/docs" "$file")
        
        # Crea i collegamenti simbolici
        ln -sf "../../Lang/docs/it/$rel_path" "$module_path/docs/it/$rel_path"
        ln -sf "../../Lang/docs/en/$rel_path" "$module_path/docs/en/$rel_path"
        
        echo "Creato collegamento per $rel_path"
    done
}

# Funzione per verificare le traduzioni
check_translations() {
    local module_path=$1
    local module_name=$(basename "$module_path")
    
    echo "Verifica traduzioni per $module_name"
    
    # Verifica i collegamenti
    find "$module_path/docs/{it,en}" -type l | while read -r link; do
        if [ ! -e "$link" ]; then
            echo "ERRORE: Collegamento rotto: $link"
        fi
    done
    
    # Verifica i file di traduzione
    find "$module_path/docs" -type f -name "*.md" | while read -r file; do
        rel_path=$(realpath --relative-to="$module_path/docs" "$file")
        
        # Verifica esistenza traduzioni
        if [ ! -f "../../Lang/docs/it/$rel_path" ]; then
            echo "MISSING: Traduzione italiana mancante per $rel_path"
        fi
        
        if [ ! -f "../../Lang/docs/en/$rel_path" ]; then
            echo "MISSING: Traduzione inglese mancante per $rel_path"
        fi
    done
}

# Percorso base dei moduli
MODULES_PATH="laravel/Modules"

# Gestisci tutti i moduli
for module in "$MODULES_PATH"/*; do
    if [ -d "$module" ] && [ "$(basename "$module")" != "Lang" ]; then
        create_translation_structure "$module"
        check_translations "$module"
    fi
done

echo "Gestione traduzioni completata!" 