#!/bin/bash

# Script di Audit Completo Documentazione - DRY + KISS + Lowercase
# Autore: Sistema di Refactoring Automatizzato
# Data: 2025-08-04

set -e

BASE_DIR="/var/www/html/_bases/base_ptvx"
LARAVEL_DIR="$BASE_DIR/laravel"
DOCS_ROOT="$BASE_DIR/docs"
AUDIT_LOG="$BASE_DIR/docs/refactoring/audit-dry-kiss-$(date +%Y%m%d-%H%M).log"

echo "=== AUDIT COMPLETO DOCUMENTAZIONE DRY + KISS ===" | tee -a "$AUDIT_LOG"
echo "Inizio: $(date)" | tee -a "$AUDIT_LOG"

# Funzione per logging
log() {
    echo "[$(date '+%H:%M:%S')] $1" | tee -a "$AUDIT_LOG"
}

# Contatori per statistiche
TOTAL_FILES=0
TOTAL_DIRS=0
UPPERCASE_FILES=0
UPPERCASE_DIRS=0
DUPLICATE_CONTENT=0
VIOLATIONS_DRY=0
VIOLATIONS_KISS=0

log "🔍 FASE 1: Controllo naming convention (lowercase only)"

# Funzione per controllare naming convention
check_naming() {
    local search_path="$1"
    local context="$2"
    
    log "   Controllo $context: $search_path"
    
    # Controlla file con caratteri maiuscoli (eccetto README.md)
    while IFS= read -r -d '' file; do
        filename=$(basename "$file")
        if [[ "$filename" != "README.md" && "$filename" =~ [A-Z] ]]; then
            log "   ❌ FILE UPPERCASE: $file"
            UPPERCASE_FILES=$((UPPERCASE_FILES + 1))
            
            # Suggerisci nome corretto
            lowercase_name=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
            log "      Suggerimento: $lowercase_name"
        fi
        TOTAL_FILES=$((TOTAL_FILES + 1))
    done < <(find "$search_path" -type f -print0 2>/dev/null)
    
    # Controlla cartelle con caratteri maiuscoli
    while IFS= read -r -d '' dir; do
        dirname_only=$(basename "$dir")
        if [[ "$dirname_only" =~ [A-Z] ]]; then
            log "   ❌ CARTELLA UPPERCASE: $dir"
            UPPERCASE_DIRS=$((UPPERCASE_DIRS + 1))
            
            # Suggerisci nome corretto
            lowercase_name=$(echo "$dirname_only" | tr '[:upper:]' '[:lower:]')
            log "      Suggerimento: $lowercase_name"
        fi
        TOTAL_DIRS=$((TOTAL_DIRS + 1))
    done < <(find "$search_path" -type d -print0 2>/dev/null)
}

# Controlla docs root
if [ -d "$DOCS_ROOT" ]; then
    check_naming "$DOCS_ROOT" "DOCS ROOT"
fi

# Controlla docs di tutti i moduli
for module_dir in "$LARAVEL_DIR/Modules"/*; do
    if [ -d "$module_dir" ]; then
        module_name=$(basename "$module_dir")
        docs_dir="$module_dir/docs"
        
        if [ -d "$docs_dir" ]; then
            check_naming "$docs_dir" "MODULO $module_name"
        fi
    fi
done

log "📊 FASE 2: Analisi violazioni principi DRY"

# Funzione per identificare contenuti duplicati
identify_duplicates() {
    log "   Ricerca contenuti duplicati..."
    
    # Crea hash di tutti i file .md per identificare duplicati
    declare -A file_hashes
    declare -A duplicate_groups
    
    while IFS= read -r -d '' file; do
        if [[ "$file" == *.md ]]; then
            # Calcola hash del contenuto (escludendo metadati)
            content_hash=$(grep -v "^---$" "$file" 2>/dev/null | grep -v "^*Ultimo aggiornamento:" | md5sum | cut -d' ' -f1)
            
            if [[ -n "${file_hashes[$content_hash]}" ]]; then
                # Duplicato trovato
                original="${file_hashes[$content_hash]}"
                log "   🔍 DUPLICATO POTENZIALE:"
                log "      Original: $original"
                log "      Duplicate: $file"
                DUPLICATE_CONTENT=$((DUPLICATE_CONTENT + 1))
                VIOLATIONS_DRY=$((VIOLATIONS_DRY + 1))
            else
                file_hashes[$content_hash]="$file"
            fi
        fi
    done < <(find "$DOCS_ROOT" "$LARAVEL_DIR/Modules/*/docs" -type f -print0 2>/dev/null)
}

identify_duplicates

log "🧩 FASE 3: Analisi violazioni principi KISS"

# Funzione per identificare complessità eccessiva
analyze_complexity() {
    log "   Analisi complessità strutturale..."
    
    # Controlla profondità directory (max raccomandato: 4 livelli)
    while IFS= read -r -d '' dir; do
        # Conta livelli di profondità
        depth=$(echo "$dir" | grep -o "/" | wc -l)
        relative_path=${dir#$BASE_DIR/}
        
        if [ "$depth" -gt 6 ]; then  # Considerando /var/www/html/_bases/base_ptvx come base
            log "   ⚠️  STRUTTURA TROPPO PROFONDA: $relative_path (livelli: $depth)"
            VIOLATIONS_KISS=$((VIOLATIONS_KISS + 1))
        fi
    done < <(find "$DOCS_ROOT" "$LARAVEL_DIR/Modules/*/docs" -type d -print0 2>/dev/null)
    
    # Controlla file con nomi troppo lunghi (>50 caratteri)
    while IFS= read -r -d '' file; do
        filename=$(basename "$file")
        if [ ${#filename} -gt 50 ]; then
            log "   ⚠️  NOME FILE TROPPO LUNGO: $filename (${#filename} caratteri)"
            VIOLATIONS_KISS=$((VIOLATIONS_KISS + 1))
        fi
    done < <(find "$DOCS_ROOT" "$LARAVEL_DIR/Modules/*/docs" -type f -print0 2>/dev/null)
    
    # Controlla file .md con contenuto eccessivamente lungo (>10000 righe)
    while IFS= read -r -d '' file; do
        if [[ "$file" == *.md ]]; then
            line_count=$(wc -l < "$file" 2>/dev/null || echo 0)
            if [ "$line_count" -gt 10000 ]; then
                log "   ⚠️  FILE TROPPO LUNGO: $file ($line_count righe)"
                VIOLATIONS_KISS=$((VIOLATIONS_KISS + 1))
            fi
        fi
    done < <(find "$DOCS_ROOT" "$LARAVEL_DIR/Modules/*/docs" -type f -print0 2>/dev/null)
}

analyze_complexity

log "🔧 FASE 4: Generazione script di correzione automatica"

# Crea script per correggere violazioni naming
cat > "$BASE_DIR/bashscripts/fix-docs-naming.sh" << 'EOF'
#!/bin/bash
# Script generato automaticamente per correggere naming convention

set -e

BASE_DIR="/var/www/html/_bases/base_ptvx"

echo "🔧 Correzione automatica naming convention docs..."

# Funzione per rinominare file e cartelle
fix_naming() {
    local path="$1"
    
    # Prima rinomina i file
    find "$path" -type f -name "*[A-Z]*" ! -name "README.md" | while read -r file; do
        dir=$(dirname "$file")
        filename=$(basename "$file")
        lowercase_name=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
        
        if [ "$filename" != "$lowercase_name" ]; then
            echo "Rinomino file: $filename -> $lowercase_name"
            mv "$file" "$dir/$lowercase_name"
        fi
    done
    
    # Poi rinomina le cartelle (dal più profondo al meno profondo)
    find "$path" -type d -name "*[A-Z]*" | sort -r | while read -r dir; do
        parent=$(dirname "$dir")
        dirname_only=$(basename "$dir")
        lowercase_name=$(echo "$dirname_only" | tr '[:upper:]' '[:lower:]')
        
        if [ "$dirname_only" != "$lowercase_name" ]; then
            echo "Rinomino cartella: $dirname_only -> $lowercase_name"
            mv "$dir" "$parent/$lowercase_name"
        fi
    done
}

# Applica correzioni
if [ -d "$BASE_DIR/docs" ]; then
    fix_naming "$BASE_DIR/docs"
fi

for module_docs in "$BASE_DIR/laravel/Modules/*/docs"; do
    if [ -d "$module_docs" ]; then
        fix_naming "$module_docs"
    fi
done

echo "✅ Correzioni naming completate!"
EOF

chmod +x "$BASE_DIR/bashscripts/fix-docs-naming.sh"
log "   ✅ Script di correzione creato: bashscripts/fix-docs-naming.sh"

log "📋 FASE 5: Generazione raccomandazioni DRY + KISS"

# Crea file con raccomandazioni
cat > "$BASE_DIR/docs/refactoring/dry-kiss-recommendations.md" << EOF
# Raccomandazioni DRY + KISS per Documentazione

## 📊 Risultati Audit $(date +%Y-%m-%d)

### Statistiche Generali
- **File totali**: $TOTAL_FILES
- **Cartelle totali**: $TOTAL_DIRS
- **File con naming errato**: $UPPERCASE_FILES
- **Cartelle con naming errato**: $UPPERCASE_DIRS
- **Contenuti duplicati**: $DUPLICATE_CONTENT
- **Violazioni DRY**: $VIOLATIONS_DRY
- **Violazioni KISS**: $VIOLATIONS_KISS

### Conformità Principi
- **DRY Compliance**: $(( (TOTAL_FILES - VIOLATIONS_DRY) * 100 / TOTAL_FILES ))%
- **KISS Compliance**: $(( (TOTAL_FILES - VIOLATIONS_KISS) * 100 / TOTAL_FILES ))%
- **Naming Compliance**: $(( (TOTAL_FILES - UPPERCASE_FILES) * 100 / TOTAL_FILES ))%

## 🎯 Raccomandazioni Immediate

### Naming Convention
$(if [ $UPPERCASE_FILES -gt 0 ] || [ $UPPERCASE_DIRS -gt 0 ]; then
    echo "- ❌ Eseguire script di correzione: \`bashscripts/fix-docs-naming.sh\`"
    echo "- ⚠️  Aggiornare tutti i link interni dopo la rinominazione"
else
    echo "- ✅ Naming convention già conforme (100% lowercase eccetto README.md)"
fi)

### Principi DRY
$(if [ $VIOLATIONS_DRY -gt 0 ]; then
    echo "- ❌ Consolidare contenuti duplicati identificati"
    echo "- ⚠️  Implementare template riutilizzabili per contenuti simili"
else
    echo "- ✅ Principi DRY rispettati (nessun contenuto duplicato)"
fi)

### Principi KISS
$(if [ $VIOLATIONS_KISS -gt 0 ]; then
    echo "- ❌ Semplificare strutture troppo complesse"
    echo "- ⚠️  Ridurre lunghezza file e nomi eccessivamente lunghi"
else
    echo "- ✅ Principi KISS rispettati (struttura semplice e chiara)"
fi)

## 🔄 Prossimi Passi

1. **Correzioni Immediate**
   - Eseguire script di correzione naming se necessario
   - Consolidare eventuali duplicazioni
   - Semplificare strutture complesse

2. **Implementazione Controlli**
   - Aggiungere validazione automatica in CI/CD
   - Implementare pre-commit hooks per naming
   - Creare dashboard di monitoraggio qualità

3. **Manutenzione Continua**
   - Audit mensile automatizzato
   - Revisione trimestrale template
   - Aggiornamento standard e linee guida

---
*Audit generato automaticamente: $(date)*
*Principi: DRY + KISS + Lowercase Naming*
EOF

log "   ✅ Raccomandazioni generate: docs/refactoring/dry-kiss-recommendations.md"

# Report finale
log "📊 FASE 6: Report finale audit"

echo "" | tee -a "$AUDIT_LOG"
echo "=== REPORT FINALE AUDIT DRY + KISS ===" | tee -a "$AUDIT_LOG"
echo "File analizzati: $TOTAL_FILES" | tee -a "$AUDIT_LOG"
echo "Cartelle analizzate: $TOTAL_DIRS" | tee -a "$AUDIT_LOG"
echo "" | tee -a "$AUDIT_LOG"
echo "🔤 NAMING CONVENTION:" | tee -a "$AUDIT_LOG"
echo "File con naming errato: $UPPERCASE_FILES" | tee -a "$AUDIT_LOG"
echo "Cartelle con naming errato: $UPPERCASE_DIRS" | tee -a "$AUDIT_LOG"
echo "" | tee -a "$AUDIT_LOG"
echo "🔄 PRINCIPI DRY:" | tee -a "$AUDIT_LOG"
echo "Contenuti duplicati: $DUPLICATE_CONTENT" | tee -a "$AUDIT_LOG"
echo "Violazioni totali: $VIOLATIONS_DRY" | tee -a "$AUDIT_LOG"
echo "" | tee -a "$AUDIT_LOG"
echo "🧩 PRINCIPI KISS:" | tee -a "$AUDIT_LOG"
echo "Violazioni complessità: $VIOLATIONS_KISS" | tee -a "$AUDIT_LOG"
echo "" | tee -a "$AUDIT_LOG"

if [ $UPPERCASE_FILES -eq 0 ] && [ $UPPERCASE_DIRS -eq 0 ] && [ $VIOLATIONS_DRY -eq 0 ] && [ $VIOLATIONS_KISS -eq 0 ]; then
    echo "🎉 CONFORMITÀ TOTALE: Documentazione perfettamente conforme a DRY + KISS!" | tee -a "$AUDIT_LOG"
else
    echo "⚠️  AZIONI RICHIESTE: Vedere raccomandazioni per miglioramenti" | tee -a "$AUDIT_LOG"
fi

echo "" | tee -a "$AUDIT_LOG"
echo "📋 File generati:" | tee -a "$AUDIT_LOG"
echo "- Log audit: $AUDIT_LOG" | tee -a "$AUDIT_LOG"
echo "- Script correzione: bashscripts/fix-docs-naming.sh" | tee -a "$AUDIT_LOG"
echo "- Raccomandazioni: docs/refactoring/dry-kiss-recommendations.md" | tee -a "$AUDIT_LOG"
echo "" | tee -a "$AUDIT_LOG"
echo "Fine: $(date)" | tee -a "$AUDIT_LOG"

log "🎯 AUDIT COMPLETATO!"
log "📋 Vedi report completo in: $AUDIT_LOG"
