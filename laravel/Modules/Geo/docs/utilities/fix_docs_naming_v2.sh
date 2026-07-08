#!/bin/bash

# Script per correggere i nomi di file e cartelle nelle cartelle docs
# Rimuove caratteri maiuscoli mantenendo README.md invariato

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🔍 Analisi file e cartelle con caratteri maiuscoli nelle cartelle docs...${NC}"

# Funzione per rinominare file e cartelle
rename_files_and_dirs() {
    local dir="$1"
    local depth="$2"
    
    # Evita ricorsione infinita
    if [ "$depth" -gt 10 ]; then
        return
    fi
    
    # Trova file e cartelle con caratteri maiuscoli (escludendo README.md)
    find "$dir" -maxdepth 1 -name "*[A-Z]*" ! -name "README.md" | sort | while read -r item; do
        if [ -e "$item" ]; then
            local basename=$(basename "$item")
            local dirname=$(dirname "$item")
            local newname=$(echo "$basename" | tr '[:upper:]' '[:lower:]')
            
            # Se il nome è cambiato
            if [ "$basename" != "$newname" ]; then
                local newpath="$dirname/$newname"
                
                # Controlla se esiste già un file/cartella con il nuovo nome
                if [ -e "$newpath" ]; then
                    echo -e "${RED}⚠️  Conflitto: $item -> $newpath (già esistente)${NC}"
                    continue
                fi
                
                echo -e "${GREEN}📝 Rinomino: $item -> $newpath${NC}"
                mv "$item" "$newpath"
            fi
        fi
    done
    
    # Ricorsione per sottocartelle
    find "$dir" -maxdepth 1 -type d | sort | while read -r subdir; do
        if [ "$subdir" != "$dir" ]; then
            rename_files_and_dirs "$subdir" $((depth + 1))
        fi
    done
}

# Cartelle docs da controllare
docs_dirs=(
    "docs"
    "laravel/docs"
)

# Aggiungi tutti i moduli Laravel
for module_dir in laravel/Modules/*/docs; do
    if [ -d "$module_dir" ]; then
        docs_dirs+=("$module_dir")
    fi
done

# Conta totale file/cartelle da rinominare
total_items=0
for docs_dir in "${docs_dirs[@]}"; do
    if [ -d "$docs_dir" ]; then
        count=$(find "$docs_dir" -name "*[A-Z]*" ! -name "README.md" 2>/dev/null | wc -l)
        total_items=$((total_items + count))
    fi
done

echo -e "${YELLOW}📊 Trovati $total_items file/cartelle da rinominare${NC}"

# Processa ogni cartella docs
for docs_dir in "${docs_dirs[@]}"; do
    if [ -d "$docs_dir" ]; then
        echo -e "${YELLOW}📁 Processando: $docs_dir${NC}"
        rename_files_and_dirs "$docs_dir" 0
    fi
done

echo -e "${GREEN}✅ Rinominazione completata!${NC}"

# Verifica finale
echo -e "${YELLOW}🔍 Verifica finale...${NC}"

# Trova tutti i file rimanenti con caratteri maiuscoli
remaining_files=$(find docs laravel/docs laravel/Modules/*/docs -name "*[A-Z]*" ! -name "README.md" 2>/dev/null | sort)

if [ -z "$remaining_files" ]; then
    echo -e "${GREEN}✅ Tutti i file e cartelle sono ora in minuscolo (eccetto README.md)${NC}"
else
    remaining_count=$(echo "$remaining_files" | wc -l)
    echo -e "${RED}⚠️  Rimangono $remaining_count file/cartelle con caratteri maiuscoli:${NC}"
    echo "$remaining_files"
fi

echo -e "${GREEN}🎉 Script completato!${NC}" 