#!/bin/bash

# Script per creare file README.md nella cartella docs/phpstan di ogni modulo
# Autore: Windsurf AI
# Data: 2025-04-11

# Colori per output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Directory base Laravel
LARAVEL_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono/laravel"
# Directory base dei moduli
MODULES_DIR="${LARAVEL_DIR}/Modules"

echo -e "${BLUE}Creazione file README.md per la documentazione PHPStan${NC}"
echo "=================================================="

# Ciclo su tutti i moduli
for MODULE_PATH in $MODULES_DIR/*; do
    if [ -d "$MODULE_PATH" ]; then
        MODULE_NAME=$(basename "$MODULE_PATH")
        
        # Crea la directory docs/phpstan se non esiste
        DOCS_DIR="$MODULE_PATH/docs/phpstan"
        mkdir -p "$DOCS_DIR"
        
        # File README.md
        README_FILE="$DOCS_DIR/README.md"
        
        echo "# Documentazione PHPStan per il Modulo ${MODULE_NAME}" > "$README_FILE"
        echo "" >> "$README_FILE"
        echo "## Introduzione" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "Questa cartella contiene la documentazione relativa all'analisi statica del codice effettuata con PHPStan sul modulo ${MODULE_NAME}." >> "$README_FILE"
        echo "L'analisi è stata eseguita a diversi livelli di rigore (da 1 a 10 e max) per identificare potenziali problemi nel codice." >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "## Struttura della Documentazione" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "Per ogni livello di analisi PHPStan, è presente un file dedicato:" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "- **level_1.md**: Analisi di base (verifica sintassi e chiamate a funzioni inesistenti)" >> "$README_FILE"
        echo "- **level_2.md**: Controllo di codice irraggiungibile e costanti non definite" >> "$README_FILE"
        echo "- **level_3.md**: Verifica dei tipi di ritorno e proprietà" >> "$README_FILE"
        echo "- **level_4.md**: Analisi più approfondita dei tipi" >> "$README_FILE"
        echo "- **level_5.md**: Controllo di metodi chiamati su tipi potenzialmente null" >> "$README_FILE"
        echo "- **level_6.md**: Verifica di proprietà non definite in classi" >> "$README_FILE"
        echo "- **level_7.md**: Controllo di chiamate a metodi con parametri errati" >> "$README_FILE"
        echo "- **level_8.md**: Verifica di proprietà non inizializzate" >> "$README_FILE"
        echo "- **level_9.md**: Controllo di metodi statici chiamati su istanze e viceversa" >> "$README_FILE"
        echo "- **level_10.md**: Analisi approfondita di tutti i tipi e controlli" >> "$README_FILE"
        echo "- **level_max.md**: Livello massimo di rigore nell'analisi" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "## Interpretazione dei Risultati" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "Ogni file di documentazione contiene:" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "1. **Risultato dell'analisi**: Successo o numero di errori rilevati" >> "$README_FILE"
        echo "2. **Dettaglio degli errori**: Output completo di PHPStan con indicazione di file, riga e tipo di errore" >> "$README_FILE"
        echo "3. **Suggerimenti per la risoluzione**: Consigli specifici per risolvere le categorie di errori più comuni" >> "$README_FILE"
        echo "4. **Consigli generali**: Linee guida per migliorare la qualità del codice" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "## Obiettivi di Qualità" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "Secondo le 'Regole Windsurf per base_<nome progetto>_fila5_mono', gli obiettivi per l'analisi PHPStan sono:" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "- Iniziare dal livello 1 per i nuovi moduli" >> "$README_FILE"
        echo "- Assicurarsi che tutto il codice passi almeno il livello 5" >> "$README_FILE"
        echo "- Mirare al livello 9 come obiettivo finale per tutto il codice" >> "$README_FILE"
        echo "- Documentare i problemi non risolvibili con annotazioni @phpstan-ignore" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "## Aggiornamento della Documentazione" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "Questa documentazione viene generata automaticamente utilizzando lo script \`phpstan_docs_generator.sh\` nella cartella \`bashscripts\`." >> "$README_FILE"
        echo "Si consiglia di aggiornare regolarmente questa documentazione, specialmente dopo modifiche significative al codice." >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "## Note Importanti" >> "$README_FILE"
        echo "" >> "$README_FILE"
        echo "- Gli errori PHPStan non indicano necessariamente bug nel codice, ma potenziali problemi o incoerenze" >> "$README_FILE"
        echo "- La risoluzione degli errori dovrebbe seguire i principi di tipizzazione stretta indicati nelle regole del progetto" >> "$README_FILE"
        echo "- Utilizzare \`@phpstan-ignore-next-line\` solo come ultima risorsa e sempre con una spiegazione del motivo" >> "$README_FILE"
        
        echo "Creato README.md per il modulo ${MODULE_NAME}"
    fi
done

echo -e "${GREEN}Creazione file README.md completata per tutti i moduli!${NC}"
