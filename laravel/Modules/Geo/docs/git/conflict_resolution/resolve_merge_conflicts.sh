#!/bin/bash

# Script per risolvere automaticamente i conflitti di merge scegliendo sempre la "current change"
# Autore: Cascade
# Data: 2025-09-21

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Directory di base
BASE_DIR="/var/www/_bases/base_<nome progetto>_fila5_mono"

# Log file
LOG_FILE="${BASE_DIR}/bashscripts/resolve_conflicts_$(date +%Y%m%d_%H%M%S).log"

echo -e "${BLUE}=== Script di risoluzione automatica dei conflitti di merge ===${NC}"
echo -e "${BLUE}=== Risolve i conflitti scegliendo sempre la 'current change' ===${NC}"
echo -e "${BLUE}=== $(date) ===${NC}"
echo -e "${YELLOW}I log verranno salvati in: ${LOG_FILE}${NC}\n"

# Inizializza il log
echo "=== Log di risoluzione dei conflitti di merge ===" > "$LOG_FILE"
echo "=== $(date) ===" >> "$LOG_FILE"
echo "=== Risolve i conflitti scegliendo sempre la 'current change' ===" >> "$LOG_FILE"
echo "" >> "$LOG_FILE"

# Funzione per risolvere i conflitti in un file
resolve_conflicts() {
    local file="$1"
    local temp_file="${file}.tmp"
    local conflict_count=0
    local in_conflict=false
    local skip_section=false
    
    # Verifica se il file esiste
    if [ ! -f "$file" ]; then
        echo -e "${RED}File non trovato: $file${NC}"
        echo "File non trovato: $file" >> "$LOG_FILE"
        return 1
    fi
    
    # Verifica se il file è leggibile
    if [ ! -r "$file" ]; then
        echo -e "${RED}File non leggibile: $file${NC}"
        echo "File non leggibile: $file" >> "$LOG_FILE"
        return 1
    }
    
    # Verifica se il file è scrivibile
    if [ ! -w "$file" ]; then
        echo -e "${RED}File non scrivibile: $file${NC}"
        echo "File non scrivibile: $file" >> "$LOG_FILE"
        return 1
    }
    
    # Legge il file riga per riga
    while IFS= read -r line; do
        # Inizio di un conflitto
            in_conflict=true
            skip_section=true
            ((conflict_count++))
            continue
        fi
        
        # Separatore di conflitto
            in_conflict=false
            skip_section=false
            continue
        fi
        
        # Se non siamo in una sezione da saltare, scriviamo la riga nel file temporaneo
        if [ "$skip_section" = false ]; then
            echo "$line" >> "$temp_file"
        fi
    done < "$file"
    
    # Se abbiamo trovato e risolto conflitti, sostituiamo il file originale
    if [ "$conflict_count" -gt 0 ]; then
        mv "$temp_file" "$file"
        echo -e "${GREEN}Risolti $conflict_count conflitti in: $file${NC}"
        echo "Risolti $conflict_count conflitti in: $file" >> "$LOG_FILE"
        return 0
    else
        # Se non ci sono conflitti, rimuoviamo il file temporaneo
        [ -f "$temp_file" ] && rm "$temp_file"
        echo -e "${YELLOW}Nessun conflitto trovato in: $file${NC}"
        echo "Nessun conflitto trovato in: $file" >> "$LOG_FILE"
        return 0
    fi
}

# Funzione per trovare tutti i file con conflitti di merge
find_and_resolve_conflicts() {
    local search_dir="$1"
    local total_files=0
    local resolved_files=0
    local failed_files=0
    
    echo -e "${BLUE}Ricerca di file con conflitti di merge in: $search_dir${NC}"
    echo "Ricerca di file con conflitti di merge in: $search_dir" >> "$LOG_FILE"
    
    # Trova tutti i file che contengono "<git marker>"
    while IFS= read -r file; do
        ((total_files++))
        echo -e "${YELLOW}[$total_files] Elaborazione: $file${NC}"
        
        # Risolvi i conflitti nel file
        if resolve_conflicts "$file"; then
            ((resolved_files++))
        else
            ((failed_files++))
            echo -e "${RED}Impossibile risolvere i conflitti in: $file${NC}"
            echo "Impossibile risolvere i conflitti in: $file" >> "$LOG_FILE"
        fi
    done < <(grep -l "<git marker>" "$search_dir" --include="*" -r)
    
    echo -e "\n${BLUE}=== Riepilogo ===${NC}"
    echo -e "${BLUE}File totali con conflitti: $total_files${NC}"
    echo -e "${GREEN}File risolti con successo: $resolved_files${NC}"
    echo -e "${RED}File con errori: $failed_files${NC}"
    
    echo -e "\n=== Riepilogo ===" >> "$LOG_FILE"
    echo "File totali con conflitti: $total_files" >> "$LOG_FILE"
    echo "File risolti con successo: $resolved_files" >> "$LOG_FILE"
    echo "File con errori: $failed_files" >> "$LOG_FILE"
}

# Esegui la funzione principale
find_and_resolve_conflicts "$BASE_DIR"

echo -e "\n${GREEN}Completato! Log salvato in: $LOG_FILE${NC}"
