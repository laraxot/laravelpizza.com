#!/bin/bash

# Script per generare un report riassuntivo dell'analisi PHPStan per tutti i moduli
# Autore: Windsurf AI
# Data: 2025-04-11

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Directory base Laravel
LARAVEL_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono/laravel"
# Directory base dei moduli
MODULES_DIR="${LARAVEL_DIR}/Modules"
# File di output
OUTPUT_FILE="${LARAVEL_DIR}/docs/phpstan_summary.md"

# Crea la directory docs se non esiste
mkdir -p "${LARAVEL_DIR}/docs"

echo -e "${BLUE}Generazione report riassuntivo dell'analisi PHPStan${NC}"
echo "=================================================="

# Intestazione del file
cat > "$OUTPUT_FILE" << EOL
# Report Riassuntivo Analisi PHPStan

Data generazione: $(date '+%Y-%m-%d %H:%M:%S')

## Panoramica

Questo report fornisce una panoramica dello stato dell'analisi statica del codice con PHPStan per tutti i moduli del progetto.

## Obiettivi di Qualità

Secondo le "Regole Windsurf per base_<nome progetto>_fila5_mono", gli obiettivi per l'analisi PHPStan sono:

- Iniziare dal livello 1 per i nuovi moduli
- Assicurarsi che tutto il codice passi almeno il livello 5
- Mirare al livello 9 come obiettivo finale per tutto il codice
- Documentare i problemi non risolvibili con annotazioni @phpstan-ignore

## Stato Attuale dei Moduli

| Modulo | Livello Massimo Superato | Livello 5 | Livello 9 | Errori al Livello Max | Stato |
|--------|--------------------------|-----------|-----------|------------------------|-------|
EOL

# Funzione per ottenere il numero di errori da un file
get_error_count() {
    local file="$1"
    if [ -f "$file" ] && grep -q "Rilevati .* errori" "$file"; then
        grep -o "Rilevati [0-9]* errori" "$file" | grep -o "[0-9]*"
    else
        echo "0"
    fi
}

# Contatori per le statistiche
total_modules=0
level5_passed=0
level9_passed=0
modules_with_errors=0

# Ciclo su tutti i moduli
for MODULE_PATH in $MODULES_DIR/*; do
    if [ -d "$MODULE_PATH" ]; then
        MODULE_NAME=$(basename "$MODULE_PATH")
        echo -e "Analisi modulo: ${MODULE_NAME}"
        
        # Incrementa il contatore dei moduli
        total_modules=$((total_modules + 1))
        
        # Directory phpstan
        PHPSTAN_DIR="$MODULE_PATH/docs/phpstan"
        
        # Verifica il livello massimo superato
        MAX_LEVEL_PASSED=0
        for LEVEL in {1..10}; do
            PHPSTAN_LEVEL_FILE="$PHPSTAN_DIR/level_${LEVEL}.md"
            if [ -f "$PHPSTAN_LEVEL_FILE" ] && ! grep -q "Rilevati .* errori" "$PHPSTAN_LEVEL_FILE"; then
                MAX_LEVEL_PASSED=$LEVEL
            else
                break
            fi
        done
        
        # Verifica se il livello 5 è superato
        LEVEL5_STATUS="❌"
        if [ $MAX_LEVEL_PASSED -ge 5 ]; then
            LEVEL5_STATUS="✅"
            level5_passed=$((level5_passed + 1))
        fi
        
        # Verifica se il livello 9 è superato
        LEVEL9_STATUS="❌"
        if [ $MAX_LEVEL_PASSED -ge 9 ]; then
            LEVEL9_STATUS="✅"
            level9_passed=$((level9_passed + 1))
        fi
        
        # Verifica errori al livello max
        MAX_FILE="$PHPSTAN_DIR/level_max.md"
        if [ -f "$MAX_FILE" ]; then
            MAX_ERRORS=$(get_error_count "$MAX_FILE")
        else
            MAX_ERRORS="N/A"
        fi
        
        # Determina lo stato
        if [ $MAX_LEVEL_PASSED -ge 9 ]; then
            if [ "$MAX_ERRORS" == "0" ]; then
                STATUS="✅ Eccellente"
            else
                STATUS="🟢 Ottimo"
                modules_with_errors=$((modules_with_errors + 1))
            fi
        elif [ $MAX_LEVEL_PASSED -ge 5 ]; then
            STATUS="🟡 Buono"
            modules_with_errors=$((modules_with_errors + 1))
        elif [ $MAX_LEVEL_PASSED -ge 1 ]; then
            STATUS="🟠 Sufficiente"
            modules_with_errors=$((modules_with_errors + 1))
        else
            STATUS="🔴 Da analizzare"
            modules_with_errors=$((modules_with_errors + 1))
        fi
        
        # Aggiungi riga alla tabella
        echo "| [${MODULE_NAME}](../Modules/${MODULE_NAME}/docs/roadmap.md) | ${MAX_LEVEL_PASSED} | ${LEVEL5_STATUS} | ${LEVEL9_STATUS} | ${MAX_ERRORS} | ${STATUS} |" >> "$OUTPUT_FILE"
    fi
done

# Calcola le percentuali
level5_percentage=$((level5_passed * 100 / total_modules))
level9_percentage=$((level9_passed * 100 / total_modules))
modules_with_errors_percentage=$((modules_with_errors * 100 / total_modules))

# Aggiungi statistiche
cat >> "$OUTPUT_FILE" << EOL

## Statistiche Complessive

- **Moduli totali**: ${total_modules}
- **Moduli che superano il livello 5**: ${level5_passed} (${level5_percentage}%)
- **Moduli che superano il livello 9**: ${level9_passed} (${level9_percentage}%)
- **Moduli con errori da risolvere**: ${modules_with_errors} (${modules_with_errors_percentage}%)

## Priorità di Intervento

In base all'analisi, si consiglia di intervenire sui moduli nel seguente ordine:

1. Moduli con stato "🔴 Da analizzare" - Richiedono un'analisi immediata
2. Moduli con stato "🟠 Sufficiente" - Non raggiungono il livello 5 minimo richiesto
3. Moduli con stato "🟡 Buono" - Superano il livello 5 ma non il livello 9
4. Moduli con stato "🟢 Ottimo" - Superano il livello 9 ma hanno errori al livello max

## Piano d'Azione

1. **Fase 1**: Assicurarsi che tutti i moduli superino il livello 5
   - Risolvere gli errori nei moduli con stato "🔴 Da analizzare" e "🟠 Sufficiente"
   - Tempo stimato: 2-3 settimane

2. **Fase 2**: Portare tutti i moduli al livello 9
   - Concentrarsi sui moduli con stato "🟡 Buono"
   - Tempo stimato: 3-4 settimane

3. **Fase 3**: Risolvere gli errori al livello max
   - Concentrarsi sui moduli con stato "🟢 Ottimo"
   - Tempo stimato: 2-3 settimane

4. **Fase 4**: Manutenzione continua
   - Eseguire regolarmente l'analisi PHPStan durante lo sviluppo
   - Aggiornare la documentazione
   - Tempo stimato: Continuo

## Note e Raccomandazioni

- Gli errori più comuni sono relativi alla tipizzazione nelle migrazioni del database
- Si consiglia di creare classi di tipo dedicate (DTO) per strutture dati complesse
- Utilizzare \`@phpstan-ignore-next-line\` solo come ultima risorsa e sempre con una spiegazione
- Aggiornare regolarmente questo report per monitorare i progressi

## Collegamenti Utili

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Regole Windsurf per base_<nome progetto>_fila5_mono](../docs/regole_windsurf.md)
- [Principi e Filosofia dello Sviluppo Software](../docs/principi_sviluppo.md)
EOL

echo -e "${GREEN}Report riassuntivo generato: ${OUTPUT_FILE}${NC}"
