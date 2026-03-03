#!/bin/bash
# Script per correggere naming conventions in TUTTI i moduli
# Applica: kebab-case, no date, no maiuscole (eccetto README.md)

set -e

MODULES_DIR="/var/www/_bases/base_quaeris_fila5_mono/laravel/Modules"

echo "🔍 Correzione Naming Conventions - Tutti i Moduli"
echo "================================================"
echo ""

# Funzione per convertire filename
convert_filename() {
    local file="$1"
    local basename=$(basename "$file")
    local dirname=$(dirname "$file")
    
    # Skip README.md (unica eccezione)
    if [ "$basename" = "README.md" ]; then
        return 0
    fi
    
    # Converti in lowercase e sostituisci underscore con trattino
    local newname=$(echo "$basename" | tr '[:upper:]' '[:lower:]' | sed 's/_/-/g')
    
    # Rimuovi date (pattern YYYY-MM-DD)
    newname=$(echo "$newname" | sed -E 's/-[0-9]{4}-[0-9]{2}-[0-9]{2}//g')
    
    # Se il nome è cambiato, rinomina
    if [ "$basename" != "$newname" ]; then
        local newpath="$dirname/$newname"
        # Se il file di destinazione esiste già, sposta in archive
        if [ -f "$newpath" ]; then
            local archivedir="$dirname/archive"
            mkdir -p "$archivedir"
            echo "  ⚠️  Duplicato: $basename -> archive/"
            mv "$file" "$archivedir/$basename"
        else
            echo "  ✅ Rinomino: $basename -> $newname"
            mv "$file" "$newpath"
        fi
    fi
}

# Backup completo prima di modificare
BACKUP_FILE="/tmp/modules-docs-backup-$(date +%Y%m%d_%H%M%S).tar.gz"
echo "📦 Creazione backup: $BACKUP_FILE"
cd "$MODULES_DIR"
tar -czf "$BACKUP_FILE" */docs/ 2>/dev/null || true
echo ""

# Processa ogni modulo
for module in Activity AI Blog Chart CloudStorage Cms Comment DbForge Fixcity Gdpr Geo Job Lang Limesurvey Media Notify Quaeris Rating Seo Tenant UI User Xot; do
    if [ ! -d "$MODULES_DIR/$module/docs" ]; then
        continue
    fi
    
    echo "📁 Modulo: $module"
    
    # Trova tutti i .md (eccetto archive/)
    find "$MODULES_DIR/$module/docs" -type f -name "*.md" ! -path "*/archive/*" | while read file; do
        convert_filename "$file"
    done
    
    echo ""
done

echo "✅ Correzione completata!"
echo ""
echo "📊 Statistiche:"
echo "  Backup salvato in: $BACKUP_FILE"
echo ""
echo "🔍 Verifica finale:"
cd "$MODULES_DIR"
for module in */docs; do
    if [ -d "$module" ]; then
        modname=$(basename $(dirname "$module"))
        uppercase=$(find "$module" -type f -name "*.md" ! -path "*/archive/*" | grep -E "[A-Z]" | grep -v "README.md" | wc -l)
        if [ "$uppercase" -gt 0 ]; then
            echo "  ⚠️  $modname: $uppercase file ancora con maiuscole"
        else
            echo "  ✅ $modname: tutti i file corretti"
        fi
    fi
done
echo ""
echo "🎯 Next: Verificare manualmente alcuni file e testare link"

