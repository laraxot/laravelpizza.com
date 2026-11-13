#!/bin/bash

# Script per verificare la struttura delle directory prima di eseguire PHPStan

# Colori per output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Verifica se è stato fornito un modulo come argomento
if [ -z "$1" ]; then
    echo -e "${RED}Errore: È necessario specificare un modulo${NC}"
    echo -e "${YELLOW}Uso: $0 NomeModulo${NC}"
    exit 1
fi

MODULE=$1
MODULE_PATH="Modules/$MODULE"

# Verifica se il modulo esiste
if [ ! -d "$MODULE_PATH" ]; then
    echo -e "${RED}Errore: Il modulo $MODULE non esiste${NC}"
    exit 1
fi

echo -e "${BLUE}Verifica della struttura delle directory per il modulo $MODULE...${NC}"

# Trova tutti i file PHP che non sono nelle directory consentite
# Escludiamo anche .php-cs-fixer.php, files in .vscode, lang/, e altri file di configurazione
files=$(find "$MODULE_PATH" -type f -name "*.php" | grep -v "/app/" | grep -v "/config/" | grep -v "/database/" | grep -v "/routes/" | grep -v "/resources/" | grep -v "/docs/" | grep -v "/.vscode/" | grep -v "/lang/" | grep -v "/.php-cs-fixer" | grep -v "/phpstan" | grep -v "/.git/")

if [ -z "$files" ]; then
    echo -e "${GREEN}✓ La struttura delle directory del modulo $MODULE è corretta${NC}"
    echo -e "${BLUE}Esecuzione di PHPStan...${NC}"
    ./vendor/bin/phpstan analyse --level=9 --memory-limit=2G "$MODULE_PATH"
    exit 0
fi

echo -e "${RED}✗ Trovati file PHP in posizioni non corrette:${NC}"

# Mostra i file in posizioni errate
echo "$files" | while read file; do
    echo -e "${RED}✗ $file${NC}"
    
    # Suggerisci dove dovrebbe essere posizionato
    rel_path=$(echo "$file" | sed "s|$MODULE_PATH/||")
    new_path="$MODULE_PATH/app/$rel_path"
    echo -e "${YELLOW}  Dovrebbe essere in: $new_path${NC}"
done

echo ""
echo -e "${YELLOW}Prima di eseguire PHPStan, è necessario correggere la struttura delle directory.${NC}"
echo -e "${YELLOW}Esegui il seguente comando per correggere automaticamente la struttura:${NC}"
echo -e "${GREEN}./bashscripts/fix_directory_structure.sh $MODULE${NC}"

exit 1 