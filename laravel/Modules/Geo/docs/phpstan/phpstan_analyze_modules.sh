#!/bin/bash

# Script per analizzare tutti i moduli con PHPStan dal livello 1 al 10

echo "Inizio analisi dei moduli"

# Lista delle directory in Modules
MODULES=$(ls -d Modules/*/)

# Per ogni modulo
for MODULE_PATH in $MODULES; do
    # Estrai solo il nome del modulo
    MODULE=$(basename $MODULE_PATH)
    
    echo "======================="
    echo "Analisi del modulo $MODULE"
    echo "======================="
    
    # Crea la directory per i report se non esiste
    mkdir -p "Modules/$MODULE/docs/phpstan"
    
    # Esegui PHPStan dal livello 1 al 10
    for LEVEL in {1..10}; do
        echo "Esecuzione di PHPStan sul modulo $MODULE al livello $LEVEL"
        
        # Esegui PHPStan e salva il report JSON
        ./vendor/bin/phpstan analyze --level=$LEVEL "Modules/$MODULE/app" --error-format=json > "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json" || true
        
        # Crea il file Markdown con l'analisi degli errori
        echo "# Analisi degli errori PHPStan per $MODULE - Livello $LEVEL" > "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
        echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
        echo "Data: $(date)" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
        echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
        
        # Verifica se il file JSON è stato creato correttamente e contiene dati
        if [ -s "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json" ]; then
            # Estrai il numero di errori
            ERROR_COUNT=$(jq -r '.totals.errors' "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json")
            
            echo "## Errori riscontrati" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
            echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
            echo "Numero totale di errori: $ERROR_COUNT" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
            echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
            
            # Se ci sono errori, elencali nel file Markdown
            if [ "$ERROR_COUNT" -gt 0 ]; then
                echo "### Lista degli errori" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
                echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
                
                # Estrai i messaggi di errore dal JSON
                jq -r '.files | to_entries[] | .key as $file | .value.messages[]? | "- **File:** \($file)\n  **Linea:** \(.line)\n  **Messaggio:** \(.message)\n"' "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md" || echo "Errore nell'estrazione dei dati JSON" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
                
                echo "## Soluzioni proposte" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
                echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
                echo "Le soluzioni verranno implementate dopo l'analisi completa degli errori." >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
            else
                echo "Nessun errore riscontrato al livello $LEVEL." >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
            fi
        else
            echo "Errore durante l'esecuzione di PHPStan o il file JSON non contiene dati validi." >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
        fi
        
        echo "Completata l'analisi del modulo $MODULE al livello $LEVEL"
    done
    
    echo "Completata l'analisi completa per il modulo $MODULE"
done

echo "Analisi completata per tutti i moduli" 