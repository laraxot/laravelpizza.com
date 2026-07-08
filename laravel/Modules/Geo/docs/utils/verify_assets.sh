#!/bin/bash

# Colori per l'output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Directory da verificare
PUBLIC_DIR="/var/www/html/<nome progetto>/public_html"
ASSETS_DIR="$PUBLIC_DIR/assets"

echo -e "${YELLOW}Verifica Asset System${NC}"
echo "============================="

# Verifica esistenza directory
if [ ! -d "$PUBLIC_DIR" ]; then
    echo -e "${RED}ERRORE: Directory $PUBLIC_DIR non esiste${NC}"
    exit 1
fi

# Verifica permessi
echo -e "${YELLOW}Verifica permessi...${NC}"
PERMISSIONS=$(stat -c "%a" "$PUBLIC_DIR")
if [ "$PERMISSIONS" != "775" ]; then
    echo -e "${RED}ATTENZIONE: Permessi non corretti su $PUBLIC_DIR${NC}"
    echo "Eseguire: sudo chmod -R 775 $PUBLIC_DIR"
fi

# Verifica proprietario
echo -e "${YELLOW}Verifica proprietario...${NC}"
OWNER=$(stat -c "%U" "$PUBLIC_DIR")
GROUP=$(stat -c "%G" "$PUBLIC_DIR")
if [ "$OWNER" != "www-data" ] || [ "$GROUP" != "www-data" ]; then
    echo -e "${RED}ATTENZIONE: Proprietario/Gruppo non corretti${NC}"
    echo "Eseguire: sudo chown -R www-data:www-data $PUBLIC_DIR"
fi

# Verifica struttura directory
echo -e "${YELLOW}Verifica struttura directory...${NC}"
if [ ! -d "$ASSETS_DIR" ]; then
    echo -e "${YELLOW}Creazione directory assets...${NC}"
    mkdir -p "$ASSETS_DIR"
    chmod 775 "$ASSETS_DIR"
    chown www-data:www-data "$ASSETS_DIR"
fi

# Verifica spazio disponibile
echo -e "${YELLOW}Verifica spazio disponibile...${NC}"
SPACE=$(df -h "$PUBLIC_DIR" | awk 'NR==2 {print $4}')
echo "Spazio disponibile: $SPACE"

echo -e "${GREEN}Verifica completata${NC}"
echo "============================="
