#!/bin/bash

# Funzione per migrare i contenuti di un modulo
migrate_module_docs() {
    local module_path=$1
    local module_name=$(basename "$module_path")
    
    echo "Migrazione documentazione per il modulo $module_name"
    
    # Verifica se esiste la cartella _docs
    if [ -d "$module_path/_docs" ]; then
        # Crea la cartella docs se non esiste
        mkdir -p "$module_path/docs"
        
        # Copia tutti i file .txt in .md
        for file in "$module_path/_docs"/*.txt; do
            if [ -f "$file" ]; then
                filename=$(basename "$file" .txt)
                cp "$file" "$module_path/docs/$filename.md"
            fi
        done
        
        # Aggiorna i riferimenti nei file .md esistenti
        for file in "$module_path/docs"/*.md; do
            if [ -f "$file" ]; then
                # Sostituisci i riferimenti ${cat ...} con il contenuto effettivo
                sed -i 's/\${cat[^}]*}//g' "$file"
            fi
        done
        
        # Elimina la cartella _docs
        rm -rf "$module_path/_docs"
        
        echo "Migrazione completata per $module_name"
    else
        echo "Nessuna cartella _docs trovata in $module_name"
    fi
}

# Percorso base dei moduli
MODULES_PATH="laravel/Modules"

# Migra tutti i moduli
for module in "$MODULES_PATH"/*; do
    if [ -d "$module" ]; then
        migrate_module_docs "$module"
    fi
done

echo "Migrazione completata per tutti i moduli" 