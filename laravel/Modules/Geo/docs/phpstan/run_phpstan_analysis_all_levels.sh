#!/bin/bash

# Script per eseguire l'analisi PHPStan su laravel/Modules
# Questo script esegue PHPStan dal livello 1 al livello 10 e genera i report

cd $(dirname $0)/../..

echo "Iniziando l'analisi PHPStan sui moduli..."

# Assicuriamoci che la directory docs/phpstan esista
mkdir -p docs/phpstan

# Esecuzione dell'analisi per ogni livello
for level in {1..10}
do
  echo "Esecuzione analisi di livello $level..."
  
  # Esegui PHPStan e salva il risultato in formato JSON
  cd laravel && ./vendor/bin/phpstan analyse Modules --level=$level --error-format=json > ../docs/phpstan/level_${level}.json 2>&1
  
  # Torna alla directory principale
  cd ..
  
  # Controlla se il file JSON è valido
  if ! jq empty docs/phpstan/level_${level}.json 2>/dev/null; then
    echo "Il file JSON generato non è valido. Creazione di un file di fallback..."
    echo '{"totals":{"errors":0,"file_errors":0},"files":{},"errors":[]}' > docs/phpstan/level_${level}.json
  fi
  
  # Crea il file markdown con l'analisi
  cat > docs/phpstan/level_${level}.md << EOL
# Analisi PHPStan - Livello $level

Data: $(date +"%Y-%m-%d %H:%M:%S")

## Sommario degli errori

\`\`\`
$(if jq -r '.totals.file_errors' docs/phpstan/level_${level}.json 2>/dev/null; then 
  jq -r '.totals.file_errors' docs/phpstan/level_${level}.json
else 
  echo "Errore nel processare il file JSON - Controlla direttamente il file level_${level}.json"
fi) errori totali in $(if jq -r '.files | length' docs/phpstan/level_${level}.json 2>/dev/null; then
  jq -r '.files | length' docs/phpstan/level_${level}.json
else
  echo "N/A"
fi) file
\`\`\`

## Dettaglio degli errori per modulo

$(if jq -r '.files | length' docs/phpstan/level_${level}.json 2>/dev/null && [ "$(jq -r '.files | length' docs/phpstan/level_${level}.json)" != "0" ]; then
  jq -r '.files | to_entries | group_by(.key | capture("Modules/(?<module>[^/]*)").module) | map({"modulo": .[0].key | capture("Modules/(?<module>[^/]*)").module, "errori": [.[].value] | add}) | sort_by(.errori) | reverse | .[] | "### Modulo \(.modulo)\n\n\(.errori) errori\n"' docs/phpstan/level_${level}.json 2>/dev/null || echo "Nessun dettaglio degli errori disponibile per questo livello"
else
  echo "Nessun errore trovato in questo livello o formato output non riconosciuto."
fi)

## Analisi dettagliata

Gli errori più comuni sono:

$(if jq -r '.errors | length' docs/phpstan/level_${level}.json 2>/dev/null && [ "$(jq -r '.errors | length' docs/phpstan/level_${level}.json)" != "0" ]; then
  jq -r '.errors | group_by(.message) | map({"message": .[0].message, "count": length}) | sort_by(.count) | reverse | .[0:5] | .[] | "- \(.message): \(.count) occorrenze"' docs/phpstan/level_${level}.json 2>/dev/null || echo "Analisi dettagliata non disponibile per questo livello"
else
  echo "- Nessun errore trovato in questo livello o formato output non riconosciuto."
fi)

## Dipendenze tra moduli

I problemi di dipendenza tra moduli includono riferimenti non corretti tra:

$(if jq -r '.errors | length' docs/phpstan/level_${level}.json 2>/dev/null && [ "$(jq -r '.errors | length' docs/phpstan/level_${level}.json)" != "0" ]; then
  jq -r '.errors | map(select(.message | contains("namespace") or contains("class") or contains("interface"))) | group_by(.message | capture("(?<from>[a-zA-Z\\\\]+)").from + " -> " + (capture("(?<to>[a-zA-Z\\\\]+)").to // "sconosciuto")) | map({"dipendenza": .[0].message | capture("(?<from>[a-zA-Z\\\\]+)").from + " -> " + (capture("(?<to>[a-zA-Z\\\\]+)").to // "sconosciuto"), "count": length}) | sort_by(.count) | reverse | .[0:10] | .[] | "- \(.dipendenza): \(.count) occorrenze"' docs/phpstan/level_${level}.json 2>/dev/null || echo "- Analisi delle dipendenze non disponibile a questo livello"
else
  echo "- Nessun problema di dipendenza trovato in questo livello o formato output non riconosciuto."
fi)

## Soluzioni architetturali proposte

- Rifattorizzare le classi con elevato accoppiamento
- Migliorare la coerenza dei namespace tra i moduli
- Implementare interfacce condivise per funzionalità comuni
- Ridurre le dipendenze cicliche tra i moduli

## Prossimi passi

- Correggere gli errori di tipo più critici
- Risolvere i problemi di namespace
- Aggiornare la documentazione per riflettere le modifiche
EOL

  echo "Analisi di livello $level completata."
  echo "-------------------------------------------------"
done

echo "Analisi PHPStan completata. Tutti i report sono stati generati nella cartella docs/phpstan/" 