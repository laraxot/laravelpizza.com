#!/bin/bash

# Script Semplice e Robusto per Fix Naming Docs
# Autore: Sistema di Refactoring Automatizzato
# Data: 2025-08-04

set -e

BASE_DIR="/var/www/html/_bases/base_ptvx"
LOG_FILE="$BASE_DIR/docs/refactoring/docs-naming-fix-final.log"

echo "=== FIX FINALE NAMING DOCS DRY + KISS ===" | tee -a "$LOG_FILE"
echo "Inizio: $(date)" | tee -a "$LOG_FILE"

# Funzione per logging
log() {
    echo "[$(date '+%H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Funzione per convertire nome in lowercase
to_lowercase() {
    echo "$1" | tr '[:upper:]' '[:lower:]' | sed 's/_/-/g'
}

# FASE 1: Fix file con naming non conforme
log "FASE 1: Rinominazione file non conformi"

RENAMED_COUNT=0
while IFS= read -r file; do
    if [ -f "$file" ]; then
        dir=$(dirname "$file")
        old_name=$(basename "$file")
        new_name=$(to_lowercase "$old_name")
        
        if [ "$old_name" != "$new_name" ] && [ "$old_name" != "README.md" ]; then
            new_path="$dir/$new_name"
            
            # Verifica che il file di destinazione non esista già
            if [ ! -f "$new_path" ]; then
                mv "$file" "$new_path"
                log "📝 $old_name -> $new_name"
                RENAMED_COUNT=$((RENAMED_COUNT + 1))
            else
                log "⚠️  Saltato $old_name (destinazione esiste già)"
            fi
        fi
    fi
done < <(find "$BASE_DIR" -path "*/docs/*" -name "*[A-Z]*" -type f)

# FASE 2: Fix cartelle con naming non conforme
log "FASE 2: Rinominazione cartelle non conformi"

RENAMED_DIRS=0
# Ordina per profondità decrescente
while IFS= read -r dir; do
    if [ -d "$dir" ]; then
        parent=$(dirname "$dir")
        old_name=$(basename "$dir")
        new_name=$(to_lowercase "$old_name")
        
        if [ "$old_name" != "$new_name" ]; then
            new_path="$parent/$new_name"
            
            if [ ! -d "$new_path" ]; then
                mv "$dir" "$new_path"
                log "📁 $old_name/ -> $new_name/"
                RENAMED_DIRS=$((RENAMED_DIRS + 1))
            else
                log "⚠️  Saltata cartella $old_name (destinazione esiste già)"
            fi
        fi
    fi
done < <(find "$BASE_DIR" -path "*/docs/*" -name "*[A-Z]*" -type d | sort -r)

# FASE 3: Verifica finale
log "FASE 3: Verifica finale"

FINAL_NON_COMPLIANT=$(find "$BASE_DIR" -path "*/docs/*" -name "*[A-Z]*" ! -name "README.md" | wc -l)

log "📊 RISULTATI FINALI:"
log "   File rinominati: $RENAMED_COUNT"
log "   Cartelle rinominate: $RENAMED_DIRS"
log "   File non conformi rimanenti: $FINAL_NON_COMPLIANT"

if [ "$FINAL_NON_COMPLIANT" -eq 0 ]; then
    log "🎉 SUCCESSO: 100% conformità naming raggiunta!"
else
    log "⚠️  Rimangono $FINAL_NON_COMPLIANT file da verificare manualmente"
    
    log "File rimanenti non conformi:"
    find "$BASE_DIR" -path "*/docs/*" -name "*[A-Z]*" ! -name "README.md" | head -10 | while read -r remaining; do
        log "   - $(realpath --relative-to="$BASE_DIR" "$remaining")"
    done
fi

# Report finale
cat > "$BASE_DIR/docs/refactoring/docs-naming-fix-final-report.md" << EOF
# Report Fix Finale Naming Docs

## Riepilogo
- **Data**: $(date)
- **File rinominati**: $RENAMED_COUNT
- **Cartelle rinominate**: $RENAMED_DIRS
- **Conformità finale**: $([ "$FINAL_NON_COMPLIANT" -eq 0 ] && echo "100%" || echo "Parziale")

## Regola Applicata
**TUTTI i file e cartelle in docs/ devono essere lowercase, eccetto README.md**

## Conversioni Applicate
- Maiuscole -> minuscole
- Underscore (_) -> trattini (-)
- Mantenimento estensioni originali

## Stato Finale
$([ "$FINAL_NON_COMPLIANT" -eq 0 ] && echo "✅ **COMPLETATO**: Tutti i file sono ora conformi" || echo "⚠️ **PARZIALE**: $FINAL_NON_COMPLIANT file richiedono verifica manuale")

---
*Report generato automaticamente*
EOF

log "📋 Report generato: docs/refactoring/docs-naming-fix-final-report.md"
log "🏁 Fix naming completato: $(date)"

echo ""
echo "=== RIEPILOGO FINALE ==="
echo "File rinominati: $RENAMED_COUNT"
echo "Cartelle rinominate: $RENAMED_DIRS"
echo "Conformità: $([ "$FINAL_NON_COMPLIANT" -eq 0 ] && echo "100%" || echo "$FINAL_NON_COMPLIANT file rimanenti")"
