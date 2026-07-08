#!/bin/bash

# Script per verificare la presenza di file di traduzione duplicati o in percorsi non standard
# Autore: Windsurf Team
# Data: 3 Giugno 2025

# Colori per l'output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}===== Verifica file di traduzione duplicati o in percorsi non standard =====${NC}"

# Imposta il percorso base del progetto
BASE_DIR="/var/www/html/ptvx/laravel"
cd "$BASE_DIR" || { echo -e "${RED}Errore: impossibile accedere alla directory di base${NC}"; exit 1; }

# 1. Verifica percorsi duplicati (lang/lang)
echo -e "\n${YELLOW}Verifica percorsi con doppia cartella 'lang'...${NC}"
DUPLICATE_PATHS=$(find Modules -path "*/lang/lang/*" -type f -name "*.php")

if [ -n "$DUPLICATE_PATHS" ]; then
    echo -e "${RED}File di traduzione trovati in percorsi duplicati:${NC}"
    echo "$DUPLICATE_PATHS"
    
    # Proponi soluzione
    echo -e "\n${YELLOW}Comando suggerito per risolvere (creare backup):${NC}"
    echo "$DUPLICATE_PATHS" | while read -r file; do
        echo "mv \"$file\" \"${file}.bak\""
    done
else
    echo -e "${GREEN}Nessun percorso duplicato trovato.${NC}"
fi

# 2. Verifica file duplicati in diverse strutture di cartelle
echo -e "\n${YELLOW}Verifica file di traduzione duplicati in diverse strutture...${NC}"

# Crea un array associativo per memorizzare tutti i file di traduzione
declare -A TRANSLATION_FILES

# Trova tutti i file di traduzione e li organizza per nome e lingua
while IFS= read -r -d '' file; do
    # Estrai il nome del file e la lingua
    filename=$(basename "$file")
    lang_dir=$(dirname "$file")
    lang=$(basename "$lang_dir")
    
    # Ignora i file di backup
    if [[ "$file" == *".bak" ]]; then
        continue
    fi
    
    # Salva il percorso completo in un array associativo
    key="${lang}/${filename}"
    if [ -n "${TRANSLATION_FILES[$key]}" ]; then
        TRANSLATION_FILES[$key]="${TRANSLATION_FILES[$key]}|$file"
    else
        TRANSLATION_FILES[$key]="$file"
    fi
done < <(find Modules -path "*/lang/*/*.php" -type f -print0)

# Controlla i duplicati
FOUND_DUPLICATES=false
for key in "${!TRANSLATION_FILES[@]}"; do
    paths="${TRANSLATION_FILES[$key]}"
    if [[ "$paths" == *"|"* ]]; then
        FOUND_DUPLICATES=true
        echo -e "${RED}File duplicato trovato: ${key}${NC}"
        echo "$paths" | tr '|' '\n' | sed 's/^/  - /'
    fi
done

if [ "$FOUND_DUPLICATES" = false ]; then
    echo -e "${GREEN}Nessun file duplicato trovato.${NC}"
fi

# 3. Verifica errori di sintassi nei file di traduzione
echo -e "\n${YELLOW}Verifica errori di sintassi nei file di traduzione...${NC}"
SYNTAX_ERRORS=false

while IFS= read -r -d '' file; do
    # Verifica la sintassi del file PHP
    result=$(php -l "$file" 2>&1)
    if [[ "$result" != *"No syntax errors detected"* ]]; then
        SYNTAX_ERRORS=true
        echo -e "${RED}Errore di sintassi in: ${file}${NC}"
        echo "$result" | grep -v "^$" | head -2 | sed 's/^/  /'
    fi
done < <(find Modules -path "*/lang/*/*.php" -type f -print0)

if [ "$SYNTAX_ERRORS" = false ]; then
    echo -e "${GREEN}Nessun errore di sintassi trovato nei file di traduzione.${NC}"
fi

# 4. Verifica inconsistenze di sintassi degli array ([] vs array())
echo -e "\n${YELLOW}Verifica inconsistenze di sintassi degli array...${NC}"
ARRAY_INCONSISTENCIES=false

# Cerca file che usano array() invece di []
while IFS= read -r -d '' file; do
    if grep -q "array (" "$file"; then
        ARRAY_INCONSISTENCIES=true
        echo -e "${YELLOW}File con sintassi array() trovato: ${file}${NC}"
    fi
done < <(find Modules -path "*/lang/*/*.php" -type f -print0)

if [ "$ARRAY_INCONSISTENCIES" = false ]; then
    echo -e "${GREEN}Nessuna inconsistenza di sintassi array trovata.${NC}"
fi

echo -e "\n${YELLOW}===== Fine verifica =====${NC}"

# Suggerimenti finali
echo -e "\n${YELLOW}Suggerimenti:${NC}"
echo "1. Dopo ogni correzione, eseguire: php artisan cache:clear && php artisan config:clear && php artisan view:clear"
echo "2. Verificare che tutte le traduzioni siano nelle posizioni standard: Modules/<Module>/lang/<locale>/"
echo "3. Utilizzare sempre la sintassi breve degli array []"
echo "4. Aggiornare la documentazione dopo ogni correzione"

exit 0