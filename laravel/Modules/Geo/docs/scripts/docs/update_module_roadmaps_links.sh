#!/bin/bash

# Script per aggiungere collegamenti bidirezionali alle roadmap dei moduli
# Autore: Windsurf AI
# Data: 2025-04-11

# Colori per output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Aggiornamento collegamenti bidirezionali nelle roadmap dei moduli...${NC}"

# Directory base
BASE_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
MAIN_ROADMAP="${BASE_DIR}/docs/roadmap.md"

# Funzione per aggiungere link alla roadmap principale
add_back_link() {
    local roadmap_file=$1
    local module_name=$2
    
    # Controlla se il file esiste
    if [ ! -f "$roadmap_file" ]; then
        echo -e "${RED}File non trovato: $roadmap_file${NC}"
        return 1
    fi
    
    # Controlla se il link è già presente
    if grep -q "Torna alla Roadmap Principale" "$roadmap_file"; then
        echo -e "${YELLOW}Link già presente in $roadmap_file${NC}"
        return 0
    fi
    
    # Aggiungi il link alla fine del file
    echo "" >> "$roadmap_file"
    echo "---" >> "$roadmap_file"
    echo "" >> "$roadmap_file"
    echo "## Collegamenti" >> "$roadmap_file"
    echo "" >> "$roadmap_file"
    echo "[⬅️ Torna alla Roadmap Principale](/docs/roadmap.md)" >> "$roadmap_file"
    echo "" >> "$roadmap_file"
    
    echo -e "${GREEN}Aggiunto link alla roadmap principale in $roadmap_file${NC}"
    return 0
}

# Aggiorna le roadmap dei moduli
echo -e "${YELLOW}Aggiornamento roadmap dei moduli...${NC}"
for module_dir in "${BASE_DIR}/laravel/Modules/"*/; do
    module_name=$(basename "$module_dir")
    roadmap_file="${module_dir}docs/roadmap.md"
    
    if [ -f "$roadmap_file" ]; then
        echo -e "${YELLOW}Aggiornamento roadmap per il modulo $module_name...${NC}"
        add_back_link "$roadmap_file" "$module_name"
    else
        echo -e "${RED}Roadmap non trovata per il modulo $module_name${NC}"
    fi
done

# Aggiorna le roadmap dei temi
echo -e "${YELLOW}Aggiornamento roadmap dei temi...${NC}"
for theme_dir in "${BASE_DIR}/laravel/Themes/"*/; do
    theme_name=$(basename "$theme_dir")
    roadmap_file="${theme_dir}docs/roadmap.md"
    
    if [ -f "$roadmap_file" ]; then
        echo -e "${YELLOW}Aggiornamento roadmap per il tema $theme_name...${NC}"
        add_back_link "$roadmap_file" "$theme_name"
    else
        echo -e "${RED}Roadmap non trovata per il tema $theme_name${NC}"
    fi
done

echo -e "${GREEN}Aggiornamento completato!${NC}"
