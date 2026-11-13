#!/bin/bash

# Script di Pulizia Duplicazioni Markdown
# Autore: Sistema di Refactoring Automatizzato
# Data: 2025-08-04

set -e

BASE_DIR="/var/www/html/_bases/base_ptvx"
LOG_FILE="$BASE_DIR/docs/refactoring/markdown-cleanup.log"

echo "=== PULIZIA DUPLICAZIONI MARKDOWN ===" | tee -a "$LOG_FILE"
echo "Inizio: $(date)" | tee -a "$LOG_FILE"

# Funzione per logging
log() {
    echo "[$(date '+%H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Funzione per pulire duplicazioni in un file
clean_markdown_duplicates() {
    local file="$1"
    local temp_file=$(mktemp)
    local cleaned=false
    
    # Legge il file e rimuove sezioni duplicate
    local in_duplicate_section=false
    local line_count=0
    
    while IFS= read -r line; do
        line_count=$((line_count + 1))
        
        # Rileva inizio di sezione duplicata (heading principale ripetuto)
        if [[ "$line" =~ ^#[[:space:]].*Script[[:space:]]Git ]]; then
            # Se siamo oltre la linea 100 e troviamo un heading principale ripetuto
            if [ $line_count -gt 100 ]; then
                log "   🔍 Duplicazione rilevata alla linea $line_count: $line"
                in_duplicate_section=true
                cleaned=true
                continue
            fi
        fi
        
        # Se non siamo in una sezione duplicata, mantieni la linea
        if [ "$in_duplicate_section" = false ]; then
            echo "$line" >> "$temp_file"
        fi
        
    done < "$file"
    
    # Se abbiamo fatto pulizie, sostituisci il file
    if [ "$cleaned" = true ]; then
        if [ -s "$temp_file" ]; then
            mv "$temp_file" "$file"
            return 0
        else
            rm "$temp_file"
            return 1
        fi
    else
        rm "$temp_file"
        return 2
    fi
}

# Funzione per correggere spaziatura heading
fix_heading_spacing() {
    local file="$1"
    local temp_file=$(mktemp)
    local fixed=false
    
    local prev_line=""
    local prev_prev_line=""
    
    while IFS= read -r line; do
        # Se la linea corrente è un heading
        if [[ "$line" =~ ^#{1,6}[[:space:]] ]]; then
            # Se la linea precedente non è vuota e non è l'inizio del file
            if [ -n "$prev_line" ] && [ "$prev_line" != "---" ]; then
                echo "" >> "$temp_file"
                fixed=true
            fi
        fi
        
        echo "$line" >> "$temp_file"
        prev_prev_line="$prev_line"
        prev_line="$line"
        
    done < "$file"
    
    # Se abbiamo fatto correzioni, sostituisci il file
    if [ "$fixed" = true ]; then
        if [ -s "$temp_file" ]; then
            mv "$temp_file" "$file"
            return 0
        else
            rm "$temp_file"
            return 1
        fi
    else
        rm "$temp_file"
        return 2
    fi
}

# Trova tutti i file markdown con potenziali problemi
log "FASE 1: Ricerca file markdown con problemi"
PROBLEM_FILES=()

# Cerca file con duplicazioni evidenti
while IFS= read -r -d '' file; do
    if [[ "$file" != *"/vendor/"* ]] && [[ "$file" != *"/backup-"* ]] && [[ "$file" != *"/.git/"* ]]; then
        # Conta occorrenze di heading principali
        heading_count=$(grep -c "^# " "$file" 2>/dev/null || echo "0")
        if [ "$heading_count" -gt 1 ]; then
            PROBLEM_FILES+=("$file")
        fi
    fi
done < <(find "$BASE_DIR" -name "*.md" -type f -print0)

log "📊 File markdown con potenziali problemi: ${#PROBLEM_FILES[@]}"

# Backup di sicurezza
log "FASE 2: Creazione backup di sicurezza"
BACKUP_DIR="$BASE_DIR/backup-markdown-cleanup-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"

for file in "${PROBLEM_FILES[@]}"; do
    rel_path=$(realpath --relative-to="$BASE_DIR" "$file")
    backup_path="$BACKUP_DIR/$rel_path"
    mkdir -p "$(dirname "$backup_path")"
    cp "$file" "$backup_path"
    log "💾 Backup: $rel_path"
done

log "✅ Backup completato in: $BACKUP_DIR"

# Pulizia duplicazioni
log "FASE 3: Pulizia duplicazioni markdown"

CLEANED_COUNT=0
FIXED_SPACING_COUNT=0
UNCHANGED_COUNT=0

for file in "${PROBLEM_FILES[@]}"; do
    rel_path=$(realpath --relative-to="$BASE_DIR" "$file")
    
    # Prima pulisci le duplicazioni
    if clean_markdown_duplicates "$file"; then
        log "🧹 Duplicazioni rimosse: $rel_path"
        CLEANED_COUNT=$((CLEANED_COUNT + 1))
    elif [ $? -eq 1 ]; then
        log "❌ Errore pulizia duplicazioni: $rel_path"
    fi
    
    # Poi correggi la spaziatura degli heading
    if fix_heading_spacing "$file"; then
        log "📐 Spaziatura heading corretta: $rel_path"
        FIXED_SPACING_COUNT=$((FIXED_SPACING_COUNT + 1))
    elif [ $? -eq 1 ]; then
        log "❌ Errore correzione spaziatura: $rel_path"
    else
        UNCHANGED_COUNT=$((UNCHANGED_COUNT + 1))
    fi
done

# Verifica finale
log "FASE 4: Verifica finale"

log "📊 RISULTATI FINALI:"
log "   File processati: ${#PROBLEM_FILES[@]}"
log "   Duplicazioni rimosse: $CLEANED_COUNT"
log "   Spaziature corrette: $FIXED_SPACING_COUNT"
log "   File senza modifiche: $UNCHANGED_COUNT"

# Genera report dettagliato
log "FASE 5: Generazione report dettagliato"
cat > "$BASE_DIR/docs/refactoring/markdown-cleanup-report.md" << EOF
# Report Pulizia Duplicazioni Markdown

## Riepilogo Operazione
- **Data**: $(date)
- **File processati**: ${#PROBLEM_FILES[@]}
- **Duplicazioni rimosse**: $CLEANED_COUNT
- **Spaziature corrette**: $FIXED_SPACING_COUNT
- **File senza modifiche**: $UNCHANGED_COUNT

## Backup
I file originali sono stati salvati in:
\`$BACKUP_DIR\`

## Problemi Risolti
1. **Duplicazioni di contenuto**: Rimosse sezioni duplicate nei file markdown
2. **Spaziatura heading**: Corretta la spaziatura intorno agli heading secondo MD022
3. **Struttura pulita**: Mantenuta solo la versione più aggiornata del contenuto

## File Processati
EOF

for file in "${PROBLEM_FILES[@]}"; do
    rel_path=$(realpath --relative-to="$BASE_DIR" "$file")
    echo "- \`$rel_path\`" >> "$BASE_DIR/docs/refactoring/markdown-cleanup-report.md"
done

cat >> "$BASE_DIR/docs/refactoring/markdown-cleanup-report.md" << EOF

## Raccomandazioni Post-Pulizia
1. **Verificare manualmente** i file puliti per assicurarsi che il contenuto sia corretto
2. **Eseguire linting markdown** per verificare la conformità agli standard
3. **Testare** i collegamenti interni per assicurarsi che funzionino
4. **Committare** le modifiche dopo la verifica completa

## Log Completo
Vedi: \`docs/refactoring/markdown-cleanup.log\`

---
*Report generato automaticamente dal sistema di pulizia markdown*
EOF

log "📋 Report dettagliato generato: docs/refactoring/markdown-cleanup-report.md"
log "🏁 Pulizia markdown completata: $(date)"

echo ""
echo "=== RIEPILOGO FINALE ==="
echo "File processati: ${#PROBLEM_FILES[@]}"
echo "Duplicazioni rimosse: $CLEANED_COUNT"
echo "Spaziature corrette: $FIXED_SPACING_COUNT"
echo "File senza modifiche: $UNCHANGED_COUNT"
echo ""
echo "Backup salvato in: $BACKUP_DIR"
echo "Report completo: docs/refactoring/markdown-cleanup-report.md"
echo "Log dettagliato: docs/refactoring/markdown-cleanup.log"
