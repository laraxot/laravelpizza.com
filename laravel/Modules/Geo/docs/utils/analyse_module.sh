#!/bin/bash

# Script per analizzare un singolo modulo con PHPStan

if [ -z "$1" ]; then
    echo "Utilizzo: $0 <nome_modulo>"
    exit 1
fi

MODULE_NAME="$1"
MODULE_PATH="Modules/$MODULE_NAME"

# Verifica che il modulo esista
if [ ! -d "$MODULE_PATH" ]; then
    echo "Errore: Il modulo $MODULE_NAME non esiste."
    exit 1
fi

# Crea la cartella docs/phpstan se non esiste
mkdir -p "$MODULE_PATH/docs/phpstan"

echo "Analisi del modulo: $MODULE_NAME"

# Crea un file di documentazione principale
DOC_FILE="$MODULE_PATH/docs/phpstan/README.md"
echo "# Analisi PHPStan per il modulo $MODULE_NAME" > "$DOC_FILE"
echo "" >> "$DOC_FILE"
echo "Data: $(date)" >> "$DOC_FILE"
echo "" >> "$DOC_FILE"
echo "## Riassunto" >> "$DOC_FILE"
echo "" >> "$DOC_FILE"
echo "| Livello | Stato | Errori |" >> "$DOC_FILE"
echo "|---------|-------|--------|" >> "$DOC_FILE"

# Analizza il modulo con livelli da 1 a 10
for level in $(seq 1 10); do
    echo "Esecuzione PHPStan livello $level per $MODULE_NAME"

    # File di output
    JSON_FILE="$MODULE_PATH/docs/phpstan/level_${level}.json"
    MD_FILE="$MODULE_PATH/docs/phpstan/level_${level}.md"

    # Esegui PHPStan con output JSON
    ./vendor/bin/phpstan analyse "$MODULE_PATH" --level=$level --error-format=json > "$JSON_FILE" 2>&1

    # Verifica se c'è stato un errore fatale
    if [ $? -ne 0 ]; then
        echo "Errore nell'esecuzione di PHPStan al livello $level"

        # Crea un file Markdown con l'errore
        echo "# Analisi PHPStan Livello $level per il modulo $MODULE_NAME" > "$MD_FILE"
        echo "" >> "$MD_FILE"
        echo "Data: $(date)" >> "$MD_FILE"
        echo "" >> "$MD_FILE"
        echo "## Errore di esecuzione" >> "$MD_FILE"
        echo "" >> "$MD_FILE"
        echo '```' >> "$MD_FILE"
        cat "$JSON_FILE" >> "$MD_FILE"
        echo '```' >> "$MD_FILE"

        # Aggiorna il riassunto
        echo "| $level | ❌ Errore | Errore di esecuzione |" >> "$DOC_FILE"

        continue
    fi

    # Crea il file Markdown
    echo "# Analisi PHPStan Livello $level per il modulo $MODULE_NAME" > "$MD_FILE"
    echo "" >> "$MD_FILE"
    echo "Data: $(date)" >> "$MD_FILE"
    echo "" >> "$MD_FILE"

    # Controlla se ci sono errori nel JSON
    if grep -q "errors" "$JSON_FILE"; then
        ERROR_COUNT=$(grep -o '"errors":' "$JSON_FILE" | wc -l)
        ERROR_COUNT=$((ERROR_COUNT+0))  # Converti in numero

        echo "## Elenco degli errori" >> "$MD_FILE"
        echo "" >> "$MD_FILE"

        # Estrai gli errori dal JSON
        echo "Estratti $ERROR_COUNT errori dal report JSON"

        # Converti il JSON in un formato più leggibile
        # Utilizziamo grep per rendere il processo più veloce invece di jq
        cat "$JSON_FILE" | grep -o '"message":"[^"]*"' | sed 's/"message":"//g' | sed 's/"//g' > /tmp/error_messages.txt
        cat "$JSON_FILE" | grep -o '"file":"[^"]*"' | sed 's/"file":"//g' | sed 's/"//g' > /tmp/error_files.txt
        cat "$JSON_FILE" | grep -o '"line":[0-9]*' | sed 's/"line"://g' > /tmp/error_lines.txt

        # Combina i file per creare una tabella Markdown
        echo "| File | Linea | Messaggio |" >> "$MD_FILE"
        echo "|------|-------|-----------|" >> "$MD_FILE"

        paste -d '|' /tmp/error_files.txt /tmp/error_lines.txt /tmp/error_messages.txt | \
        while IFS='|' read -r file line message; do
            echo "| $file | $line | $message |" >> "$MD_FILE"
        done

        # Aggiorna il riassunto
        echo "| $level | ⚠️ Errori | $ERROR_COUNT errori trovati |" >> "$DOC_FILE"
    else
        echo "## Nessun errore trovato" >> "$MD_FILE"
        echo "" >> "$MD_FILE"
        echo "Il modulo $MODULE_NAME ha superato l'analisi PHPStan al livello $level senza errori." >> "$MD_FILE"

        # Aggiorna il riassunto
        echo "| $level | ✅ Successo | Nessun errore |" >> "$DOC_FILE"
    fi

    echo "" >> "$MD_FILE"
    echo "## Soluzioni proposte" >> "$MD_FILE"
    echo "" >> "$MD_FILE"
    echo "Le soluzioni verranno implementate dopo l'analisi completa degli errori." >> "$MD_FILE"
done

echo "Analisi completata per il modulo $MODULE_NAME"
echo "Il report è disponibile in $DOC_FILE"
