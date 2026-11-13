#!/bin/bash

# Script per analizzare tutti i moduli con PHPStan dal livello 1 al 10

# Array dei moduli
MODULES=(
  "Activity"
  "Chart"
  "CloudStorage"
  "Cms"
  "Gdpr"
  "Job"
  "Lang"
  "Limesurvey"
  "Media"
  "Notify"
  "healthcare_app"
  "Setting"
  "Tenant"
  "Theme"
  "UI"
  "User"
  "Xot"
)

# Ciclo sui moduli
for MODULE in "${MODULES[@]}"; do
  echo "Analisi del modulo $MODULE"
  
  # Verifica se esiste la directory docs/phpstan nel modulo, altrimenti la crea
  if [ ! -d "Modules/$MODULE/docs/phpstan" ]; then
    mkdir -p "Modules/$MODULE/docs/phpstan"
  fi
  
  # Esegue PHPStan dal livello 1 al 10 per il modulo
  for LEVEL in {1..10}; do
    echo "Esecuzione di PHPStan sul modulo $MODULE al livello $LEVEL"
    
    # Esegue PHPStan e salva il report in formato JSON
    ./vendor/bin/phpstan analyze --level=$LEVEL Modules/$MODULE/app --error-format=json > "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json" || true
    
    # Crea il file Markdown con l'analisi degli errori
    echo "# Analisi degli errori PHPStan del modulo $MODULE al livello $LEVEL" > "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    echo "Data: $(date)" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    echo "## Errori riscontrati" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    
    # Estrae il numero di errori dal report JSON
    ERROR_COUNT=$(grep -o '"totals":{"errors":[0-9]*' "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json" | grep -o '[0-9]*$')
    echo "Numero totale di errori: $ERROR_COUNT" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    
    # Se ci sono errori, li estrae e li aggiunge al file Markdown
    if [ "$ERROR_COUNT" -gt 0 ]; then
      echo "### Lista degli errori" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
      echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
      
      # Estrae i messaggi di errore dal report JSON
      jq -r '.files | to_entries[] | .key as $file | .value.messages[] | "- **File:** \($file)\n  **Linea:** \(.line)\n  **Messaggio:** \(.message)\n"' "Modules/$MODULE/docs/phpstan/level_${LEVEL}.json" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md" || echo "Errore durante l'estrazione degli errori dal JSON" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
      
      echo "## Soluzioni proposte" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
      echo "" >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
      echo "Le soluzioni verranno implementate in seguito all'analisi completa degli errori." >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    else
      echo "Nessun errore riscontrato al livello $LEVEL." >> "Modules/$MODULE/docs/phpstan/level_${LEVEL}.md"
    fi
    
    echo "Completata l'analisi del modulo $MODULE al livello $LEVEL"
  done
  
  echo "Completata l'analisi completa del modulo $MODULE"
done

echo "Analisi completata per tutti i moduli" 
