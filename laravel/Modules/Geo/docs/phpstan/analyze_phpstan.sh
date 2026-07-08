#!/bin/bash

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Directory di base
LARAVEL_DIR="laravel"
MODULES_DIR="$LARAVEL_DIR/Modules"

# Verifica che la directory Laravel esista
if [ ! -d "$LARAVEL_DIR" ]; then
    echo -e "${RED}Directory Laravel non trovata!${NC}"
    exit 1
fi

# Verifica che PHPStan sia installato
if [ ! -f "$LARAVEL_DIR/vendor/bin/phpstan" ]; then
    echo -e "${RED}PHPStan non trovato! Assicurati che sia installato.${NC}"
    exit 1
fi

# Funzione per creare il file markdown con le correzioni suggerite
create_markdown_report() {
    local module=$1
    local level=$2
    local json_file="$MODULES_DIR/$module/docs/phpstan/level_$level.json"
    local md_file="$MODULES_DIR/$module/docs/phpstan/level_$level.md"

    echo "# Analisi PHPStan Livello $level per il modulo $module" > "$md_file"
    echo "" >> "$md_file"
    echo "## Errori riscontrati e suggerimenti per la correzione" >> "$md_file"
    echo "" >> "$md_file"

    if [ -f "$json_file" ]; then
        # Analizza il JSON e estrai gli errori
        while IFS= read -r line; do
            if [[ $line =~ "message" ]]; then
                error_msg=$(echo "$line" | sed 's/.*"message": "\(.*\)",/\1/')
                echo "### Errore:" >> "$md_file"
                echo "\`\`\`" >> "$md_file"
                echo "$error_msg" >> "$md_file"
                echo "\`\`\`" >> "$md_file"
                echo "" >> "$md_file"
                echo "**Suggerimento per la correzione:**" >> "$md_file"
                echo "- Verificare i type hints e i return types" >> "$md_file"
                echo "- Assicurarsi che tutte le proprietà siano correttamente definite" >> "$md_file"
                echo "- Controllare che le dipendenze siano correttamente importate" >> "$md_file"
                echo "" >> "$md_file"
            fi
        done < "$json_file"
    fi
}

# Ciclo attraverso tutti i moduli
for module in "$MODULES_DIR"/*/ ; do
    module=$(basename "$module")
    echo -e "${YELLOW}Analizzando il modulo: $module${NC}"

    # Crea la directory docs/phpstan se non esiste
    mkdir -p "$MODULES_DIR/$module/docs/phpstan"

    # Esegui l'analisi per ogni livello da 1 a 8
    for level in {1..8}; do
        echo -e "${GREEN}Eseguendo analisi di livello $level...${NC}"

        # Esegui PHPStan e salva l'output in JSON
        cd "$LARAVEL_DIR" && \
        php vendor/bin/phpstan analyse \
            --level="$level" \
            --error-format=json \
            "Modules/$module/app" > "../$MODULES_DIR/$module/docs/phpstan/level_$level.json" 2>/dev/null

        # Verifica se l'analisi ha avuto successo
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ Analisi di livello $level completata per $module${NC}"
            # Crea il report markdown
            create_markdown_report "$module" "$level"
        else
            echo -e "${RED}✗ Errore nell'analisi di livello $level per $module${NC}"
            # Salva comunque il report markdown con gli errori
            create_markdown_report "$module" "$level"
        fi
    done
done

echo -e "${GREEN}Analisi completata per tutti i moduli!${NC}"