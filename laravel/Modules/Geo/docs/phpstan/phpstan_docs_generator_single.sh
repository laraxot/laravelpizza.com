#!/bin/bash

# Script per generare documentazione PHPStan per un singolo modulo
# Autore: Windsurf AI
# Data: 2025-04-11

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Verifica che sia stato fornito un nome di modulo
if [ -z "$1" ]; then
    echo -e "${RED}Errore: Specificare il nome del modulo come parametro.${NC}"
    echo "Esempio: $0 Activity"
    exit 1
fi

# Nome del modulo
MODULE_NAME="$1"

# Directory base Laravel
LARAVEL_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono/laravel"
# Directory del modulo
MODULE_PATH="${LARAVEL_DIR}/Modules/${MODULE_NAME}"

# Verifica che il modulo esista
if [ ! -d "$MODULE_PATH" ]; then
    echo -e "${RED}Errore: Il modulo ${MODULE_NAME} non esiste.${NC}"
    exit 1
fi

echo -e "${BLUE}Generazione documentazione PHPStan per il modulo ${MODULE_NAME}${NC}"
echo "=================================================="

# Crea la directory docs/phpstan se non esiste
DOCS_DIR="$MODULE_PATH/docs/phpstan"
mkdir -p "$DOCS_DIR"

# Livelli PHPStan da analizzare
LEVELS=(1 2 3 4 5 6 7 8 9 10 "max")

# Ciclo su tutti i livelli
for LEVEL in "${LEVELS[@]}"; do
    echo -e "${YELLOW}Analisi livello: ${LEVEL}${NC}"
    
    # File di output per il livello corrente
    OUTPUT_FILE="$DOCS_DIR/level_${LEVEL}.md"
    
    # Intestazione del file
    echo "# Analisi PHPStan - Modulo ${MODULE_NAME} - Livello ${LEVEL}" > "$OUTPUT_FILE"
    echo "" >> "$OUTPUT_FILE"
    echo "Data analisi: $(date '+%Y-%m-%d %H:%M:%S')" >> "$OUTPUT_FILE"
    echo "" >> "$OUTPUT_FILE"
    
    # Esegui PHPStan e cattura l'output
    cd "$LARAVEL_DIR"
    PHPSTAN_OUTPUT=$(./vendor/bin/phpstan analyse "Modules/$MODULE_NAME" --level="$LEVEL" 2>&1)
    EXIT_CODE=$?
    
    # Aggiungi risultati al file
    if [ $EXIT_CODE -eq 0 ]; then
        echo "## Risultato: SUCCESSO" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        echo "Nessun errore rilevato a livello ${LEVEL}." >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        echo "### Consigli" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        echo "- Il codice è ben strutturato e rispetta le regole di tipizzazione del livello ${LEVEL}." >> "$OUTPUT_FILE"
        echo "- Considerare di aumentare il livello di analisi per identificare potenziali problemi più complessi." >> "$OUTPUT_FILE"
    else
        # Conta gli errori
        ERROR_COUNT=$(echo "$PHPSTAN_OUTPUT" | grep -o '\[ERROR\] Found [0-9]* errors' | grep -o '[0-9]*')
        
        echo "## Risultato: ERRORI" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        echo "Rilevati ${ERROR_COUNT} errori a livello ${LEVEL}." >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        
        echo "### Dettaglio errori" >> "$OUTPUT_FILE"
        echo "\`\`\`" >> "$OUTPUT_FILE"
        echo "$PHPSTAN_OUTPUT" >> "$OUTPUT_FILE"
        echo "\`\`\`" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        
        echo "### Suggerimenti per la risoluzione" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        
        # Analisi degli errori più comuni
        if echo "$PHPSTAN_OUTPUT" | grep -q "Cannot call method .* on mixed"; then
            echo "#### Errori di tipo 'Cannot call method on mixed'" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "Questi errori indicano che PHPStan non può determinare il tipo di una variabile e quindi non può verificare se il metodo chiamato esiste. Per risolvere:" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "1. Aggiungere annotazioni di tipo PHPDoc per chiarire il tipo della variabile" >> "$OUTPUT_FILE"
            echo "2. Utilizzare asserzioni di tipo come \`assert(\$var instanceof ClassName)\`" >> "$OUTPUT_FILE"
            echo "3. Aggiungere controlli espliciti con \`instanceof\` prima di chiamare i metodi" >> "$OUTPUT_FILE"
            echo "4. Per le migrazioni Laravel, tipizzare correttamente il parametro \$table come Blueprint" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "Esempio di correzione per migrazioni:" >> "$OUTPUT_FILE"
            echo "\`\`\`php" >> "$OUTPUT_FILE"
            echo "Schema::create('table_name', function (Blueprint \$table) {" >> "$OUTPUT_FILE"
            echo "    \$table->id(); // Ora PHPStan sa che \$table è di tipo Blueprint" >> "$OUTPUT_FILE"
            echo "});" >> "$OUTPUT_FILE"
            echo "\`\`\`" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
        fi
        
        if echo "$PHPSTAN_OUTPUT" | grep -q "Parameter #[0-9]* .* expects .*, .* given"; then
            echo "#### Errori di tipo 'Parameter expects X, Y given'" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "Questi errori indicano incompatibilità di tipo nei parametri dei metodi. Per risolvere:" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "1. Assicurarsi che il tipo passato corrisponda a quello atteso" >> "$OUTPUT_FILE"
            echo "2. Utilizzare cast espliciti quando appropriato" >> "$OUTPUT_FILE"
            echo "3. Aggiornare la firma del metodo per accettare il tipo fornito" >> "$OUTPUT_FILE"
            echo "4. Aggiungere controlli di tipo prima di chiamare il metodo" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
        fi
        
        if echo "$PHPSTAN_OUTPUT" | grep -q "Access to an undefined property"; then
            echo "#### Errori di tipo 'Access to an undefined property'" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "Questi errori indicano l'accesso a proprietà che non esistono nella classe. Per risolvere:" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
            echo "1. Verificare se la proprietà è definita correttamente" >> "$OUTPUT_FILE"
            echo "2. Aggiungere la proprietà mancante alla classe" >> "$OUTPUT_FILE"
            echo "3. Per proprietà dinamiche, utilizzare \`@property\` nelle annotazioni PHPDoc" >> "$OUTPUT_FILE"
            echo "4. Per modelli Eloquent, usare \`@property\` per documentare le colonne del database" >> "$OUTPUT_FILE"
            echo "" >> "$OUTPUT_FILE"
        fi
        
        # Suggerimenti generali
        echo "### Consigli generali" >> "$OUTPUT_FILE"
        echo "" >> "$OUTPUT_FILE"
        echo "1. Iniziare risolvendo gli errori più semplici e ripetitivi" >> "$OUTPUT_FILE"
        echo "2. Utilizzare \`@phpstan-ignore-next-line\` solo come ultima risorsa per errori non risolvibili" >> "$OUTPUT_FILE"
        echo "3. Considerare l'aggiunta di test unitari per verificare il comportamento corretto" >> "$OUTPUT_FILE"
        echo "4. Aggiornare la documentazione del codice con annotazioni PHPDoc complete" >> "$OUTPUT_FILE"
        echo "5. Valutare l'utilizzo di classi di tipo dedicate (DTO) per strutture dati complesse" >> "$OUTPUT_FILE"
        echo "6. Seguire le linee guida di tipizzazione nel documento 'Regole Windsurf per base_<nome progetto>_fila5_mono'" >> "$OUTPUT_FILE"
    fi
    
    echo "  Documentazione salvata in: $OUTPUT_FILE"
done

echo -e "${GREEN}Analisi completata per il modulo: ${MODULE_NAME}${NC}"
echo ""
echo "Puoi trovare i report nella cartella: $DOCS_DIR"
