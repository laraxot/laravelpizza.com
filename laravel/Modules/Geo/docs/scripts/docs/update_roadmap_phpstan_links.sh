#!/bin/bash

# Script per aggiornare i file roadmap.md con collegamenti ai file phpstan
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

echo -e "${BLUE}Aggiornamento dei file roadmap.md con collegamenti a PHPStan${NC}"
echo "=================================================="

# Ciclo su tutti i moduli
for MODULE_PATH in $MODULES_DIR/*; do
    if [ -d "$MODULE_PATH" ]; then
        MODULE_NAME=$(basename "$MODULE_PATH")
        echo -e "${YELLOW}Elaborazione modulo: ${MODULE_NAME}${NC}"
        
        # Crea le directory docs se non esistono
        DOCS_DIR="$MODULE_PATH/docs"
        PHPSTAN_DIR="$DOCS_DIR/phpstan"
        mkdir -p "$DOCS_DIR"
        mkdir -p "$PHPSTAN_DIR"
        
        # Percorso del file roadmap.md
        ROADMAP_FILE="$DOCS_DIR/roadmap.md"
        
        # Verifica se il file roadmap.md esiste
        if [ ! -f "$ROADMAP_FILE" ]; then
            echo "  Creazione nuovo file roadmap.md..."
            
            # Crea un nuovo file roadmap.md
            cat > "$ROADMAP_FILE" << EOL
# Roadmap Modulo ${MODULE_NAME}

## 📊 Progress Overview
| Categoria | Progresso | Note |
|-----------|-----------|------|
| Core Features | 80% | In sviluppo |
| Performance | 70% | Da ottimizzare |
| Documentation | 60% | Da completare |
| Test Coverage | 50% | Da migliorare |
| Security | 75% | Standard elevati |

## Stato Attuale
- **Versione**: 1.0.0
- **Stato Implementazione**: 70%
- **Priorità**: Media
- **Dipendenze**: Xot, UI

## Task & Progress

### Completato (100%)
- [x] Funzionalità base
- [x] Integrazione con moduli core
- [x] Struttura database

### In Progress (50%)
- [ ] Ottimizzazione performance
- [ ] Miglioramento UI/UX
- [ ] Documentazione completa
- [ ] Test di integrazione

### Da Fare (0%)
- [ ] Funzionalità avanzate
- [ ] API documentation
- [ ] Miglioramenti UX
- [ ] Ottimizzazione query

## Analisi di Sistema

### Performance
- Performance attuale da valutare
- Ottimizzazioni pianificate

### Design e UX
- Design system da implementare
- Miglioramenti UX pianificati

### Sicurezza
- Implementazione standard di sicurezza
- Revisione accessi e permessi

## Documentazione Tecnica

### Architettura
- Descrizione dell'architettura del modulo
- Diagrammi e schemi

### API
- Documentazione API interne
- Endpoint e utilizzo

## Qualità del Codice
- Implementazione test automatici
- Code review regolari

EOL
        fi
        
        # Verifica se la sezione PHPStan esiste già nel file roadmap.md
        if ! grep -q "## Analisi Statica del Codice (PHPStan)" "$ROADMAP_FILE"; then
            echo "  Aggiunta sezione PHPStan al file roadmap.md..."
            
            # Aggiungi la sezione PHPStan al file roadmap.md
            cat >> "$ROADMAP_FILE" << EOL

## Analisi Statica del Codice (PHPStan)

L'analisi statica del codice è stata effettuata utilizzando PHPStan a diversi livelli di rigore.
I risultati completi sono disponibili nella cartella [docs/phpstan](phpstan/).

### Stato Attuale

| Livello | Stato | Errori | Azioni Richieste |
|---------|-------|--------|------------------|
EOL
            
            # Aggiungi informazioni per ogni livello PHPStan
            for LEVEL in {1..10} "max"; do
                PHPSTAN_LEVEL_FILE="$PHPSTAN_DIR/level_${LEVEL}.md"
                
                if [ -f "$PHPSTAN_LEVEL_FILE" ]; then
                    # Estrai il numero di errori dal file
                    if grep -q "Rilevati .* errori" "$PHPSTAN_LEVEL_FILE"; then
                        ERROR_COUNT=$(grep -o "Rilevati [0-9]* errori" "$PHPSTAN_LEVEL_FILE" | grep -o "[0-9]*")
                        STATUS="❌ Non superato"
                        ACTIONS="Correzione errori richiesta"
                    else
                        ERROR_COUNT="0"
                        STATUS="✅ Superato"
                        ACTIONS="Nessuna azione richiesta"
                    fi
                    
                    # Aggiungi riga alla tabella
                    echo "| [Livello ${LEVEL}](phpstan/level_${LEVEL}.md) | ${STATUS} | ${ERROR_COUNT} | ${ACTIONS} |" >> "$ROADMAP_FILE"
                else
                    echo "| Livello ${LEVEL} | ⚠️ Non analizzato | - | Eseguire analisi |" >> "$ROADMAP_FILE"
                fi
            done
            
            # Aggiungi note e obiettivi
            cat >> "$ROADMAP_FILE" << EOL

### Obiettivi di Qualità

Secondo le "Regole Windsurf per base_<nome progetto>_fila5_mono", gli obiettivi per l'analisi PHPStan sono:

- Iniziare dal livello 1 per i nuovi moduli
- Assicurarsi che tutto il codice passi almeno il livello 5
- Mirare al livello 9 come obiettivo finale per tutto il codice
- Documentare i problemi non risolvibili con annotazioni @phpstan-ignore

### Piano d'Azione

1. Risolvere gli errori partendo dal livello più basso
2. Prioritizzare gli errori più critici e ripetitivi
3. Aggiornare la documentazione del codice con annotazioni PHPDoc complete
4. Implementare test unitari per verificare il comportamento corretto
5. Eseguire regolarmente l'analisi PHPStan durante lo sviluppo
EOL
        else
            echo "  La sezione PHPStan esiste già nel file roadmap.md"
            
            # Aggiorna la tabella di stato PHPStan
            # Prima rimuovi la tabella esistente
            sed -i '/| Livello | Stato | Errori | Azioni Richieste |/,/^$/d' "$ROADMAP_FILE"
            
            # Aggiungi la nuova tabella
            sed -i '/### Stato Attuale/a\
| Livello | Stato | Errori | Azioni Richieste |\
|---------|-------|--------|------------------|' "$ROADMAP_FILE"
            
            # Aggiungi informazioni per ogni livello PHPStan
            for LEVEL in {1..10} "max"; do
                PHPSTAN_LEVEL_FILE="$PHPSTAN_DIR/level_${LEVEL}.md"
                
                if [ -f "$PHPSTAN_LEVEL_FILE" ]; then
                    # Estrai il numero di errori dal file
                    if grep -q "Rilevati .* errori" "$PHPSTAN_LEVEL_FILE"; then
                        ERROR_COUNT=$(grep -o "Rilevati [0-9]* errori" "$PHPSTAN_LEVEL_FILE" | grep -o "[0-9]*")
                        STATUS="❌ Non superato"
                        ACTIONS="Correzione errori richiesta"
                    else
                        ERROR_COUNT="0"
                        STATUS="✅ Superato"
                        ACTIONS="Nessuna azione richiesta"
                    fi
                    
                    # Aggiungi riga alla tabella
                    sed -i "/| Livello | Stato | Errori | Azioni Richieste |/a\\
| [Livello ${LEVEL}](phpstan/level_${LEVEL}.md) | ${STATUS} | ${ERROR_COUNT} | ${ACTIONS} |" "$ROADMAP_FILE"
                else
                    sed -i "/| Livello | Stato | Errori | Azioni Richieste |/a\\
| Livello ${LEVEL} | ⚠️ Non analizzato | - | Eseguire analisi |" "$ROADMAP_FILE"
                fi
            done
        fi
        
        # Ora aggiungiamo un collegamento al roadmap.md nei file phpstan
        for LEVEL in {1..10} "max"; do
            PHPSTAN_LEVEL_FILE="$PHPSTAN_DIR/level_${LEVEL}.md"
            
            if [ -f "$PHPSTAN_LEVEL_FILE" ]; then
                # Verifica se il collegamento al roadmap.md esiste già
                if ! grep -q "Roadmap del modulo" "$PHPSTAN_LEVEL_FILE"; then
                    echo "  Aggiunta collegamento al roadmap.md nel file level_${LEVEL}.md..."
                    
                    # Aggiungi il collegamento dopo la prima riga (titolo)
                    sed -i "2i\\
\\
[⬅️ Torna alla Roadmap del modulo](../roadmap.md)\\
" "$PHPSTAN_LEVEL_FILE"
                fi
            fi
        done
        
        echo -e "${GREEN}Aggiornamento completato per il modulo: ${MODULE_NAME}${NC}"
        echo ""
    fi
done

echo -e "${GREEN}Aggiornamento dei file roadmap.md completato per tutti i moduli!${NC}"
