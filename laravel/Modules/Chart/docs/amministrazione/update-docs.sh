#!/bin/bash

# Script per aggiornare la documentazione del progetto 
# Data ultima modifica: $(date +%Y-%m-%d)

echo "===== Aggiornamento Documentazione ====="
echo "Avviato: $(date)"

# Directory principale
DOCS_DIR="/var/www/html/<nome progetto>/docs"
LARAVEL_DIR="/var/www/html/<nome progetto>/laravel"
LOG_FILE="$DOCS_DIR/aggiornamento_log.txt"

# Funzione per registrare un messaggio nel log
log_message() {
    echo "[$(date +%Y-%m-%d\ %H:%M:%S)] $1" | tee -a "$LOG_FILE"
}

# Verifica esistenza directory docs
if [ ! -d "$DOCS_DIR" ]; then
    log_message "ERRORE: La directory docs non esiste: $DOCS_DIR"
    exit 1
fi

# Aggiorna il log
log_message "Avvio aggiornamento documentazione"

# 1. Aggiorna la lista dei moduli installati
log_message "Aggiornamento lista moduli installati..."
if [ -d "$LARAVEL_DIR/Modules" ]; then
    # Crea lista moduli
    MODULI_INSTALLATI=$(ls -1 "$LARAVEL_DIR/Modules")
    echo "# Moduli Installati" > "$DOCS_DIR/moduli-installati.md"
    echo "" >> "$DOCS_DIR/moduli-installati.md"
    echo "Ultimo aggiornamento: $(date)" >> "$DOCS_DIR/moduli-installati.md"
    echo "" >> "$DOCS_DIR/moduli-installati.md"
    
    # Aggiungi ogni modulo alla lista
    for MODULO in $MODULI_INSTALLATI; do
        # Verifica se il modulo ha un file module.json
        if [ -f "$LARAVEL_DIR/Modules/$MODULO/module.json" ]; then
            # Estrai descrizione dal module.json
            DESC=$(grep -o '"description": "[^"]*"' "$LARAVEL_DIR/Modules/$MODULO/module.json" | cut -d'"' -f4)
            echo "## $MODULO" >> "$DOCS_DIR/moduli-installati.md"
            echo "" >> "$DOCS_DIR/moduli-installati.md"
            echo "$DESC" >> "$DOCS_DIR/moduli-installati.md"
            echo "" >> "$DOCS_DIR/moduli-installati.md"
            
            # Verifica dipendenze
            REQUIRES=$(grep -o '"requires": \[[^]]*\]' "$LARAVEL_DIR/Modules/$MODULO/module.json")
            if [ ! -z "$REQUIRES" ]; then
                echo "**Dipendenze:**" >> "$DOCS_DIR/moduli-installati.md"
                # Estrai le dipendenze e formattale
                DEPS=$(echo "$REQUIRES" | grep -o '"[^"]*"' | tr -d '"' | sed 's/^/- /')
                echo "$DEPS" >> "$DOCS_DIR/moduli-installati.md"
                echo "" >> "$DOCS_DIR/moduli-installati.md"
            fi
            
            # Verifica documentazione del modulo
            if [ -d "$LARAVEL_DIR/Modules/$MODULO/docs" ]; then
                echo "**Documentazione disponibile:** [Visualizza](../laravel/Modules/$MODULO/docs/)" >> "$DOCS_DIR/moduli-installati.md"
                echo "" >> "$DOCS_DIR/moduli-installati.md"
            fi
        else
            echo "## $MODULO" >> "$DOCS_DIR/moduli-installati.md"
            echo "" >> "$DOCS_DIR/moduli-installati.md"
            echo "Nessuna descrizione disponibile" >> "$DOCS_DIR/moduli-installati.md"
            echo "" >> "$DOCS_DIR/moduli-installati.md"
        fi
    done
    
    log_message "Lista moduli installati aggiornata: $DOCS_DIR/moduli-installati.md"
else
    log_message "AVVISO: Directory Modules non trovata: $LARAVEL_DIR/Modules"
fi

# 2. Aggiorna il sommario con i file più recenti
log_message "Aggiornamento sommario documentazione..."

# Crea file di indice temporaneo
TEMP_INDEX=$(mktemp)
echo "# Indice Documentazione" > "$TEMP_INDEX"
echo "" >> "$TEMP_INDEX"
echo "Ultimo aggiornamento: $(date)" >> "$TEMP_INDEX"
echo "" >> "$TEMP_INDEX"

# Elenca tutti i file markdown nella directory docs
find "$DOCS_DIR" -name "*.md" -not -name "README.md" | sort | while read FILE; do
    REL_PATH=$(realpath --relative-to="$DOCS_DIR" "$FILE")
    
    # Estrai titolo dal file (prima riga # Titolo)
    TITLE=$(head -n 1 "$FILE" | sed 's/^# //')
    
    # Se non c'è titolo, usa il nome del file
    if [[ ! "$TITLE" == "#"* ]]; then
        TITLE=$(basename "$FILE" .md)
    fi
    
    echo "- [$TITLE](./$REL_PATH)" >> "$TEMP_INDEX"
done

# Sposta il file temporaneo nella posizione finale
mv "$TEMP_INDEX" "$DOCS_DIR/sommario.md"
log_message "Sommario documentazione aggiornato: $DOCS_DIR/sommario.md"

# 3. Verifica link rotti
log_message "Verifica link nella documentazione..."
BROKEN_LINKS=0

# Cerca link interni nei file markdown
find "$DOCS_DIR" -name "*.md" | while read FILE; do
    # Estrai link relativi (escludendo link esterni e ancore)
    grep -o '\[.*\]([^http].*\.md)' "$FILE" | grep -o '(.*\.md)' | tr -d '()' | while read LINK; do
        # Calcola il percorso completo
        if [[ "$LINK" == /* ]]; then
            TARGET="$LINK"
        else
            TARGET=$(dirname "$FILE")/"$LINK"
        fi
        
        # Verifica se il file di destinazione esiste
        if [ ! -f "$TARGET" ]; then
            log_message "AVVISO: Link rotto in $FILE -> $LINK"
            ((BROKEN_LINKS++))
        fi
    done
done

if [ $BROKEN_LINKS -gt 0 ]; then
    log_message "Trovati $BROKEN_LINKS link rotti nella documentazione."
else
    log_message "Nessun link rotto trovato."
fi

# 4. Aggiorna README principale
log_message "Aggiornamento README principale con la data di ultimo aggiornamento..."

# Crea un file temporaneo per il README
TEMP_README=$(mktemp)

# Leggi il README e aggiungi la data dell'ultimo aggiornamento
sed '/^Ultimo aggiornamento:/d' "$DOCS_DIR/README.md" > "$TEMP_README"

# Cerca la riga dopo Panoramica
LINENUM=$(grep -n "^## Panoramica" "$TEMP_README" | cut -d: -f1)
if [ ! -z "$LINENUM" ]; then
    LINENUM=$((LINENUM + 2)) # Due righe dopo l'intestazione
    
    # Prepara il nuovo README con la data aggiornata
    head -n $LINENUM "$TEMP_README" > "$DOCS_DIR/README.md"
    echo "Ultimo aggiornamento: $(date)" >> "$DOCS_DIR/README.md"
    echo "" >> "$DOCS_DIR/README.md"
    tail -n +$((LINENUM + 1)) "$TEMP_README" >> "$DOCS_DIR/README.md"
    
    log_message "README principale aggiornato con la data: $DOCS_DIR/README.md"
else
    # Nessuna sezione Panoramica trovata, aggiungi in coda
    cat "$TEMP_README" > "$DOCS_DIR/README.md"
    echo "" >> "$DOCS_DIR/README.md"
    echo "Ultimo aggiornamento: $(date)" >> "$DOCS_DIR/README.md"
    
    log_message "README principale aggiornato (aggiunta data in coda)"
fi

# Elimina file temporaneo
rm -f "$TEMP_README"

# 5. Aggiorna il file di changelog
log_message "Aggiornamento changelog documentazione..."

# Verifica che la directory changelog esista
if [ ! -d "$DOCS_DIR/changelog" ]; then
    mkdir -p "$DOCS_DIR/changelog"
    log_message "Creata directory changelog: $DOCS_DIR/changelog"
fi

# Crea una nuova voce nel changelog
CHANGELOG_FILE="$DOCS_DIR/changelog/$(date +%Y-%m-%d).md"
echo "# Aggiornamento Documentazione $(date +%Y-%m-%d)" > "$CHANGELOG_FILE"
echo "" >> "$CHANGELOG_FILE"
echo "## Modifiche effettuate" >> "$CHANGELOG_FILE"
echo "" >> "$CHANGELOG_FILE"
echo "- Aggiornato elenco moduli installati" >> "$CHANGELOG_FILE"
echo "- Aggiornato sommario documentazione" >> "$CHANGELOG_FILE"
echo "- Verificati link nella documentazione" >> "$CHANGELOG_FILE"
echo "- Aggiornato README principale" >> "$CHANGELOG_FILE"
echo "" >> "$CHANGELOG_FILE"
echo "## Dettagli" >> "$CHANGELOG_FILE"
echo "" >> "$CHANGELOG_FILE"
echo "Sono stati trovati $BROKEN_LINKS link rotti nella documentazione." >> "$CHANGELOG_FILE"
echo "" >> "$CHANGELOG_FILE"
echo "Moduli installati:" >> "$CHANGELOG_FILE"
echo "\`\`\`" >> "$CHANGELOG_FILE"
echo "$MODULI_INSTALLATI" >> "$CHANGELOG_FILE"
echo "\`\`\`" >> "$CHANGELOG_FILE"

log_message "Changelog aggiornato: $CHANGELOG_FILE"

# Conclusione
log_message "Aggiornamento documentazione completato!"
echo ""
echo "Aggiornamento documentazione completato con successo!"
echo "Log salvato in: $LOG_FILE"
echo "Completato: $(date)" 