#!/bin/bash

# Script di Consolidamento Documentazione - Principi DRY + KISS
# Autore: Sistema di Refactoring Automatizzato
# Data: 2025-08-04

set -e

BASE_DIR="/var/www/html/_bases/base_ptvx"
LARAVEL_DIR="$BASE_DIR/laravel"
DOCS_ROOT="$BASE_DIR/docs"
LOG_FILE="$BASE_DIR/docs/refactoring/consolidation.log"

echo "=== CONSOLIDAMENTO DOCUMENTAZIONE DRY + KISS ===" | tee -a "$LOG_FILE"
echo "Inizio: $(date)" | tee -a "$LOG_FILE"

# Funzione per logging
log() {
    echo "[$(date '+%H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Fase 1: Backup di sicurezza
log "FASE 1: Creazione backup di sicurezza"
if [ ! -d "$BASE_DIR/backup-docs-$(date +%Y%m%d)" ]; then
    cp -r "$DOCS_ROOT" "$BASE_DIR/backup-docs-$(date +%Y%m%d)"
    log "✅ Backup creato in backup-docs-$(date +%Y%m%d)"
fi

# Fase 2: Analisi duplicazioni _docs vs docs
log "FASE 2: Analisi duplicazioni _docs vs docs"
MODULES_WITH_DUAL_DOCS=()

for module_dir in "$LARAVEL_DIR/Modules"/*; do
    if [ -d "$module_dir" ]; then
        module_name=$(basename "$module_dir")
        docs_dir="$module_dir/docs"
        _docs_dir="$module_dir/_docs"
        
        if [ -d "$docs_dir" ] && [ -d "$_docs_dir" ]; then
            MODULES_WITH_DUAL_DOCS+=("$module_name")
            log "🔍 Modulo $module_name: DUPLICAZIONE RILEVATA"
            
            # Conta file in entrambe le cartelle
            docs_count=$(find "$docs_dir" -type f | wc -l)
            _docs_count=$(find "$_docs_dir" -type f | wc -l)
            log "   docs/: $docs_count file | _docs/: $_docs_count file"
        fi
    fi
done

log "📊 Totale moduli con duplicazione: ${#MODULES_WITH_DUAL_DOCS[@]}"

# Fase 3: Consolidamento intelligente _docs -> docs
log "FASE 3: Consolidamento intelligente _docs -> docs"

for module_name in "${MODULES_WITH_DUAL_DOCS[@]}"; do
    module_dir="$LARAVEL_DIR/Modules/$module_name"
    docs_dir="$module_dir/docs"
    _docs_dir="$module_dir/_docs"
    
    log "🔄 Consolidando modulo: $module_name"
    
    # Crea cartella di integrazione temporanea
    temp_integration="$docs_dir/_integration"
    mkdir -p "$temp_integration"
    
    # Analizza contenuti _docs per integrazione
    if [ -d "$_docs_dir" ]; then
        # Cerca file .txt con contenuti utili (non vuoti, > 50 caratteri)
        find "$_docs_dir" -name "*.txt" -size +50c | while read -r txt_file; do
            filename=$(basename "$txt_file" .txt)
            
            # Converte .txt in .md e sposta in integrazione
            if [ -s "$txt_file" ]; then
                echo "# $filename" > "$temp_integration/$filename.md"
                echo "" >> "$temp_integration/$filename.md"
                echo "<!-- Contenuto migrato da _docs/$filename.txt -->" >> "$temp_integration/$filename.md"
                echo "" >> "$temp_integration/$filename.md"
                cat "$txt_file" >> "$temp_integration/$filename.md"
                log "   ✅ Migrato: $filename.txt -> $filename.md"
            fi
        done
        
        # Copia altri file utili (non .gitkeep)
        find "$_docs_dir" -type f ! -name ".gitkeep" ! -name "*.txt" | while read -r file; do
            rel_path=$(realpath --relative-to="$_docs_dir" "$file")
            target_dir="$temp_integration/$(dirname "$rel_path")"
            mkdir -p "$target_dir"
            cp "$file" "$target_dir/"
            log "   ✅ Copiato: $rel_path"
        done
    fi
    
    log "   📁 Contenuti _docs integrati in docs/_integration/"
done

# Fase 4: Eliminazione naming convention errati (uppercase)
log "FASE 4: Correzione naming convention (lowercase)"

# Trova file con naming errato in docs root
find "$DOCS_ROOT" -name "*[A-Z]*" -type f ! -name "README.md" | while read -r file; do
    dir=$(dirname "$file")
    filename=$(basename "$file")
    lowercase_name=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
    
    if [ "$filename" != "$lowercase_name" ]; then
        mv "$file" "$dir/$lowercase_name"
        log "🔧 Rinominato: $filename -> $lowercase_name"
    fi
done

# Trova cartelle con naming errato
find "$DOCS_ROOT" -name "*[A-Z]*" -type d | while read -r dir; do
    parent=$(dirname "$dir")
    dirname_only=$(basename "$dir")
    lowercase_name=$(echo "$dirname_only" | tr '[:upper:]' '[:lower:]')
    
    if [ "$dirname_only" != "$lowercase_name" ]; then
        mv "$dir" "$parent/$lowercase_name"
        log "🔧 Cartella rinominata: $dirname_only -> $lowercase_name"
    fi
done

# Fase 5: Identificazione contenuti duplicati in root docs
log "FASE 5: Identificazione contenuti duplicati in root docs"

# Cerca file con contenuti simili (stesso nome base)
declare -A file_groups
while IFS= read -r -d '' file; do
    basename_no_ext=$(basename "$file" | sed 's/\.[^.]*$//')
    # Normalizza nome (rimuove numeri, date, suffissi)
    normalized=$(echo "$basename_no_ext" | sed -E 's/[_-]?[0-9]{4}[_-]?[0-9]{2}[_-]?[0-9]{2}//g' | sed -E 's/[_-]?(summary|fix|guide|rules)$//g')
    
    if [ -n "${file_groups[$normalized]}" ]; then
        file_groups[$normalized]="${file_groups[$normalized]}|$file"
        log "🔍 Duplicazione potenziale: $normalized"
    else
        file_groups[$normalized]="$file"
    fi
done < <(find "$DOCS_ROOT" -name "*.md" -type f -print0)

# Fase 6: Creazione struttura DRY consolidata
log "FASE 6: Creazione struttura DRY consolidata"

# Crea nuova struttura secondo principi KISS
mkdir -p "$DOCS_ROOT/core"
mkdir -p "$DOCS_ROOT/development"
mkdir -p "$DOCS_ROOT/modules"
mkdir -p "$DOCS_ROOT/guides"
mkdir -p "$DOCS_ROOT/reference"
mkdir -p "$DOCS_ROOT/templates"

# Template base per documentazione modulare
cat > "$DOCS_ROOT/templates/module-readme.md" << 'EOF'
# Modulo {MODULE_NAME}

## Panoramica
Breve descrizione del modulo e del suo scopo.

## Struttura
```
{MODULE_NAME}/
├── Models/
├── Controllers/
├── Resources/
└── docs/
```

## Configurazione
Istruzioni per la configurazione del modulo.

## Utilizzo
Esempi pratici di utilizzo.

## API Reference
Link alla documentazione API specifica.

## Troubleshooting
Problemi comuni e soluzioni.

## Collegamenti
- [Documentazione Core](../../core/)
- [Guide Sviluppo](../../development/)
- [Reference API](../../reference/)
EOF

log "✅ Template base creato"

# Fase 7: Generazione indice consolidato
log "FASE 7: Generazione indice consolidato"

cat > "$DOCS_ROOT/index.md" << 'EOF'
# Indice Documentazione Progetto

## 🎯 Navigazione Rapida

### Core
- [Architettura](core/architecture.md)
- [Principi](core/principles.md)
- [Convenzioni](core/conventions.md)

### Sviluppo
- [Getting Started](development/getting-started.md)
- [Coding Standards](development/coding-standards.md)
- [Testing](development/testing.md)

### Moduli
- [Panoramica](modules/overview.md)
- [Xot](modules/xot/)
- [Moduli](modules/ptvx/)
- [UI](modules/ui/)

### Guide
- [Installazione](guides/installation.md)
- [Configurazione](guides/configuration.md)
- [Deployment](guides/deployment.md)

### Reference
- [API](reference/api.md)
- [Database](reference/database.md)
- [Comandi](reference/commands.md)

---
*Documentazione consolidata secondo principi DRY + KISS*
*Ultimo aggiornamento: $(date)*
EOF

log "✅ Indice principale creato"

# Fase 8: Report finale
log "FASE 8: Report finale consolidamento"

echo "" | tee -a "$LOG_FILE"
echo "=== REPORT FINALE CONSOLIDAMENTO ===" | tee -a "$LOG_FILE"
echo "Moduli consolidati: ${#MODULES_WITH_DUAL_DOCS[@]}" | tee -a "$LOG_FILE"
echo "Struttura DRY creata: ✅" | tee -a "$LOG_FILE"
echo "Naming convention corretta: ✅" | tee -a "$LOG_FILE"
echo "Template standardizzati: ✅" | tee -a "$LOG_FILE"
echo "Indice consolidato: ✅" | tee -a "$LOG_FILE"
echo "" | tee -a "$LOG_FILE"
echo "⚠️  PROSSIMI PASSI MANUALI:" | tee -a "$LOG_FILE"
echo "1. Revisione contenuti in docs/_integration/" | tee -a "$LOG_FILE"
echo "2. Migrazione contenuti duplicati identificati" | tee -a "$LOG_FILE"
echo "3. Aggiornamento link interni" | tee -a "$LOG_FILE"
echo "4. Eliminazione _docs dopo verifica" | tee -a "$LOG_FILE"
echo "" | tee -a "$LOG_FILE"
echo "Fine: $(date)" | tee -a "$LOG_FILE"

log "🎉 CONSOLIDAMENTO COMPLETATO!"
log "📋 Vedi report completo in: $LOG_FILE"
