#!/bin/bash

# Script per eseguire PHPStan su tutti i moduli Laravel

# Vai alla directory Laravel
cd /var/www/html/_bases/base_healthcare_app_fila5_mono/laravel

# Ottieni tutti i moduli
MODULES=($(ls -d Modules/*/ | cut -d'/' -f2))

# Crea cartella principale per i report
mkdir -p docs/phpstan

# Crea report principale
MAIN_DOC="docs/phpstan/README.md"
echo "# Analisi PHPStan - Report Generale" > "$MAIN_DOC"
echo "" >> "$MAIN_DOC"
echo "Data: $(date)" >> "$MAIN_DOC"
echo "" >> "$MAIN_DOC"
echo "## Moduli analizzati" >> "$MAIN_DOC"
echo "" >> "$MAIN_DOC"
echo "| Modulo | Stato | Livello Massimo Superato |" >> "$MAIN_DOC"
echo "|--------|-------|--------------------------|" >> "$MAIN_DOC"

# Analizza ogni modulo
for MODULE_NAME in "${MODULES[@]}"; do
    echo "Analisi del modulo: $MODULE_NAME"
    
    MODULE_PATH="Modules/$MODULE_NAME"
    
    # Crea cartella per i report del modulo
    mkdir -p "$MODULE_PATH/docs/phpstan"
    
    # File report modulo
    MODULE_DOC="$MODULE_PATH/docs/phpstan/README.md"
    echo "# Analisi PHPStan per il modulo $MODULE_NAME" > "$MODULE_DOC"
    echo "" >> "$MODULE_DOC"
    echo "Data: $(date)" >> "$MODULE_DOC"
    echo "" >> "$MODULE_DOC"
    echo "## Riassunto" >> "$MODULE_DOC"
    echo "" >> "$MODULE_DOC"
    echo "| Livello | Stato | Errori |" >> "$MODULE_DOC"
    echo "|---------|-------|--------|" >> "$MODULE_DOC"
    
    MAX_LEVEL_PASSED=0
    MODULE_STATUS="❌ Fallito"
    
    # Analizza il modulo a livelli incrementali
    for LEVEL in $(seq 1 10); do
        echo "Esecuzione PHPStan livello $LEVEL per $MODULE_NAME"
        
        # File di output
        JSON_FILE="$MODULE_PATH/docs/phpstan/level_${LEVEL}.json"
        MD_FILE="$MODULE_PATH/docs/phpstan/level_${LEVEL}.md"
        
        # Esegui PHPStan
        ./vendor/bin/phpstan analyse "$MODULE_PATH" --level=$LEVEL --error-format=json > "$JSON_FILE" 2>&1
        
        # Verifica se c'è stato un errore fatale
        if [ $? -ne 0 ]; then
            echo "Errore nell'esecuzione di PHPStan al livello $LEVEL"
            
            # Crea report MD con l'errore
            echo "# Analisi PHPStan Livello $LEVEL per il modulo $MODULE_NAME" > "$MD_FILE"
            echo "" >> "$MD_FILE"
            echo "Data: $(date)" >> "$MD_FILE"
            echo "" >> "$MD_FILE"
            echo "## Errore di esecuzione" >> "$MD_FILE"
            echo "" >> "$MD_FILE"
            echo '```' >> "$MD_FILE"
            cat "$JSON_FILE" >> "$MD_FILE"
            echo '```' >> "$MD_FILE"
            
            # Aggiorna il riassunto del modulo
            echo "| $LEVEL | ❌ Errore | Errore di esecuzione |" >> "$MODULE_DOC"
            
            break
        fi
        
        # Crea il file Markdown
        echo "# Analisi PHPStan Livello $LEVEL per il modulo $MODULE_NAME" > "$MD_FILE"
        echo "" >> "$MD_FILE"
        echo "Data: $(date)" >> "$MD_FILE"
        echo "" >> "$MD_FILE"
        
        # Controlla se ci sono errori nel JSON
        if grep -q '"totals":{"errors":0' "$JSON_FILE"; then
            echo "## Nessun errore trovato" >> "$MD_FILE"
            echo "" >> "$MD_FILE"
            echo "Il modulo $MODULE_NAME ha superato l'analisi PHPStan al livello $LEVEL senza errori." >> "$MD_FILE"
            
            # Aggiorna il riassunto del modulo
            echo "| $LEVEL | ✅ Successo | Nessun errore |" >> "$MODULE_DOC"
            
            MAX_LEVEL_PASSED=$LEVEL
            MODULE_STATUS="✅ Superato"
            
        else
            # Estrai il numero di errori
            ERROR_COUNT=$(grep -o '"totals":{"errors":[0-9]*' "$JSON_FILE" | grep -o '[0-9]*$')
            
            echo "## Elenco degli errori ($ERROR_COUNT errori trovati)" >> "$MD_FILE"
            echo "" >> "$MD_FILE"
            
            # Converti il JSON in formato leggibile
            echo "| File | Linea | Messaggio |" >> "$MD_FILE"
            echo "|------|-------|-----------|" >> "$MD_FILE"
            
            # Estrai i messaggi di errore dal JSON
            grep -o '"message":"[^"]*"' "$JSON_FILE" | sed 's/"message":"//g' | sed 's/"//g' > /tmp/error_messages.txt
            grep -o '"file":"[^"]*"' "$JSON_FILE" | sed 's/"file":"//g' | sed 's/"//g' > /tmp/error_files.txt
            grep -o '"line":[0-9]*' "$JSON_FILE" | sed 's/"line"://g' > /tmp/error_lines.txt
            
            # Combina i file per creare la tabella
            paste -d '|' /tmp/error_files.txt /tmp/error_lines.txt /tmp/error_messages.txt | \
            while IFS='|' read -r file line message; do
                echo "| $file | $line | $message |" >> "$MD_FILE"
            done
            
            # Aggiorna il riassunto del modulo
            echo "| $LEVEL | ⚠️ Errori | $ERROR_COUNT errori trovati |" >> "$MODULE_DOC"
            
            # Sezione soluzioni proposte
            echo "" >> "$MD_FILE"
            echo "## Soluzioni proposte" >> "$MD_FILE"
            echo "" >> "$MD_FILE"
            echo "Le soluzioni saranno implementate dopo l'analisi completa degli errori." >> "$MD_FILE"
            
            # Se ci sono errori, interrompi l'analisi a livelli superiori
            break
        fi
    done
    
    # Crea link bidirezionale nella documentazione principale
    echo "## Collegamenti" >> "$MODULE_DOC"
    echo "" >> "$MODULE_DOC"
    echo "- [Report Generale](/docs/phpstan/README.md)" >> "$MODULE_DOC"
    
    # Aggiorna il report principale
    echo "| $MODULE_NAME | $MODULE_STATUS | $MAX_LEVEL_PASSED |" >> "$MAIN_DOC"
    echo "" >> "$MAIN_DOC"
    echo "- [$MODULE_NAME](/$MODULE_PATH/docs/phpstan/README.md)" >> "$MAIN_DOC"
    
    echo "Analisi completata per il modulo $MODULE_NAME"
    echo "-----------------------------------------"
done

echo "Analisi PHPStan completata per tutti i moduli."
echo "Report generale disponibile in $MAIN_DOC" 
