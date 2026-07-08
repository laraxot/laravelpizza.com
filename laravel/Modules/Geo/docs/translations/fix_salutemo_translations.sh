#!/bin/bash

# Script per correggere i problemi di duplicazione nei file di traduzione <nome progetto>

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

<nome progetto>_LANG_DIR="laravel/Modules/<nome progetto>/lang/it"

echo -e "${YELLOW}🔧 Correzione problemi traduzioni <nome progetto>...${NC}"

# Funzione per correggere un file di traduzione
fix_translation_file() {
    local file="$1"
    local filename=$(basename "$file")
    
    echo -e "${YELLOW}🔧 Correggendo: $filename${NC}"
    
    # Crea backup
    local backup_file="${file}.backup.$(date +%Y%m%d_%H%M%S)"
    cp "$file" "$backup_file"
    echo -e "${BLUE}📦 Backup creato: $backup_file${NC}"
    
    # Leggi il contenuto
    local content=$(cat "$file")
    
    # Rimuovi tutte le dichiarazioni PHP e declare duplicate
    content=$(echo "$content" | sed 's/^<?php$//g' | sed 's/^<?php//g')
    content=$(echo "$content" | sed 's/^declare(strict_types=1);$//g')
    content=$(echo "$content" | sed 's/^return$//g')
    
    # Rimuovi righe vuote multiple
    content=$(echo "$content" | sed '/^$/d')
    
    # Ricostruisci il file corretto
    local fixed_content="<?php

declare(strict_types=1);

return $content"
    
    # Scrivi il file corretto
    echo "$fixed_content" > "$file"
    
    echo -e "${GREEN}✅ Corretto: $filename${NC}"
}

# Funzione per rimuovere campi duplicati rimasti
remove_remaining_duplicates() {
    local file="$1"
    local filename=$(basename "$file")
    
    echo -e "${YELLOW}🧹 Rimuovendo duplicati rimasti da: $filename${NC}"
    
    # Rimuovi campi duplicati che potrebbero essere rimasti
    sed -i "/'applyFilters' => \[/,/^\s*\],$/d" "$file" 2>/dev/null || true
    sed -i "/'toggleColumns' => \[/,/^\s*\],$/d" "$file" 2>/dev/null || true
    sed -i "/'reorderRecords' => \[/,/^\s*\],$/d" "$file" 2>/dev/null || true
    sed -i "/'resetFilters' => \[/,/^\s*\],$/d" "$file" 2>/dev/null || true
    sed -i "/'openFilters' => \[/,/^\s*\],$/d" "$file" 2>/dev/null || true
}

# Funzione per migliorare la formattazione
improve_formatting() {
    local file="$1"
    local filename=$(basename "$file")
    
    echo -e "${YELLOW}📝 Migliorando formattazione di: $filename${NC}"
    
    # Sostituisci array() con [] se ancora presenti
    sed -i 's/array (/[/g' "$file"
    sed -i 's/)/]/g' "$file"
    
    # Rimuovi spazi extra
    sed -i 's/^  \[/  [/g' "$file"
    sed -i 's/^\s*\[/  [/g' "$file"
}

# Processa tutti i file di traduzione
for file in "$<nome progetto>_LANG_DIR"/*.php; do
    if [ -f "$file" ]; then
        echo -e "${BLUE}📁 Processando: $(basename "$file")${NC}"
        
        # Correggi il file
        fix_translation_file "$file"
        
        # Rimuovi duplicati rimasti
        remove_remaining_duplicates "$file"
        
        # Migliora formattazione
        improve_formatting "$file"
        
        echo -e "${GREEN}✅ Completato: $(basename "$file")${NC}"
        echo "---"
    fi
done

echo -e "${GREEN}🎉 Correzione traduzioni <nome progetto> completata!${NC}"
echo -e "${YELLOW}📋 Verifica finale:${NC}"
echo -e "  1. Controlla che i file non abbiano duplicazioni"
echo -e "  2. Verifica la sintassi PHP"
echo -e "  3. Testa le traduzioni nell'applicazione" 