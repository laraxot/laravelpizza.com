#!/bin/bash

# Docs Radical Refactor Script - <nome progetto>
# Principi: DRY + KISS + Lowercase Naming Convention
# Data: 2025-08-04

set -e

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>"
LARAVEL_ROOT="$PROJECT_ROOT/laravel"

echo "======================================================="
echo "DOCS RADICAL REFACTOR - DRY + KISS + LOWERCASE"
echo "======================================================="

# Funzione per convertire nomi in lowercase
to_lowercase() {
    echo "$1" | tr '[:upper:]' '[:lower:]'
}

# Funzione per rinominare file mantenendo README.md
rename_file() {
    local file="$1"
    local dir=$(dirname "$file")
    local basename=$(basename "$file")
    
    # Skip README.md (unica eccezione)
    if [[ "$basename" == "README.md" ]]; then
        return 0
    fi
    
    local new_basename=$(to_lowercase "$basename")
    
    if [[ "$basename" != "$new_basename" ]]; then
        local new_file="$dir/$new_basename"
        echo "Rinomino: $basename -> $new_basename"
        mv "$file" "$new_file"
        
        # Aggiorna i link nei file markdown
        find "$PROJECT_ROOT" -name "*.md" -type f -not -path "*/vendor/*" -exec sed -i "s|$basename|$new_basename|g" {} \;
    fi
}

# Funzione per rinominare cartelle
rename_directory() {
    local dir="$1"
    local parent=$(dirname "$dir")
    local basename=$(basename "$dir")
    local new_basename=$(to_lowercase "$basename")
    
    if [[ "$basename" != "$new_basename" ]]; then
        local new_dir="$parent/$new_basename"
        echo "Rinomino cartella: $basename -> $new_basename"
        mv "$dir" "$new_dir"
        
        # Aggiorna i link nei file markdown
        find "$PROJECT_ROOT" -name "*.md" -type f -not -path "*/vendor/*" -exec sed -i "s|/$basename/|/$new_basename/|g" {} \;
    fi
}

echo "1. FASE 1: Rinomina file con caratteri maiuscoli (eccetto README.md)"
echo "=============================================================="

# Trova e rinomina tutti i file con caratteri maiuscoli nelle cartelle docs
find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type f -not -name "README.md" -not -path "*/vendor/*" | while read -r file; do
    rename_file "$file"
done

echo ""
echo "2. FASE 2: Rinomina cartelle con caratteri maiuscoli"
echo "=================================================="

# Trova e rinomina tutte le cartelle con caratteri maiuscoli nelle cartelle docs
find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type d -not -path "*/vendor/*" | sort -r | while read -r dir; do
    rename_directory "$dir"
done

echo ""
echo "3. FASE 3: Consolidamento contenuti duplicati"
echo "============================================="

# Identifica e consolida file duplicati comuni
consolidate_files() {
    local pattern="$1"
    local target_name="$2"
    local search_path="$3"
    
    echo "Consolidando file con pattern: $pattern -> $target_name"
    
    find "$search_path" -path "*/docs/*" -name "*$pattern*" -type f -not -path "*/vendor/*" | while read -r file; do
        local dir=$(dirname "$file")
        local target_file="$dir/$target_name"
        
        if [[ "$file" != "$target_file" && -f "$file" ]]; then
            if [[ -f "$target_file" ]]; then
                # Append content if target exists
                echo "" >> "$target_file"
                echo "<!-- Contenuto consolidato da $(basename "$file") -->" >> "$target_file"
                cat "$file" >> "$target_file"
                rm "$file"
                echo "Consolidato: $file -> $target_file"
            else
                # Rename if target doesn't exist
                mv "$file" "$target_file"
                echo "Rinominato: $file -> $target_file"
            fi
        fi
    done
}

# Consolida file comuni
consolidate_files "architecture" "architecture.md" "$PROJECT_ROOT"
consolidate_files "installation" "installation.md" "$PROJECT_ROOT"
consolidate_files "configuration" "configuration.md" "$PROJECT_ROOT"
consolidate_files "migration" "migrations.md" "$PROJECT_ROOT"
consolidate_files "translation" "translations.md" "$PROJECT_ROOT"
consolidate_files "testing" "testing.md" "$PROJECT_ROOT"

echo ""
echo "4. FASE 4: Rimozione file obsoleti e duplicati"
echo "=============================================="

# Rimuovi file obsoleti comuni
remove_obsolete_files() {
    local pattern="$1"
    echo "Rimuovendo file obsoleti con pattern: $pattern"
    
    find "$PROJECT_ROOT" -path "*/docs/*" -name "*$pattern*" -type f -not -path "*/vendor/*" | while read -r file; do
        echo "Rimosso file obsoleto: $file"
        rm "$file"
    done
}

# Rimuovi file temporanei e backup
remove_obsolete_files "*.backup"
remove_obsolete_files "*.old"
remove_obsolete_files "*.tmp"
remove_obsolete_files "*~"

echo ""
echo "5. FASE 5: Creazione indici e collegamenti bidirezionali"
echo "======================================================"

# Crea indice principale per ogni modulo
create_module_index() {
    local module_docs="$1"
    local module_name=$(basename $(dirname "$module_docs"))
    local index_file="$module_docs/index.md"
    
    if [[ -d "$module_docs" ]]; then
        echo "Creando indice per modulo: $module_name"
        
        cat > "$index_file" << EOF
# Documentazione Modulo $module_name

## Panoramica
Documentazione completa per il modulo $module_name del progetto <nome progetto>.

## File di Documentazione

EOF
        
        # Elenca tutti i file markdown nella cartella docs del modulo
        find "$module_docs" -name "*.md" -type f -not -name "index.md" | sort | while read -r file; do
            local basename=$(basename "$file" .md)
            local relative_path=$(realpath --relative-to="$module_docs" "$file")
            echo "- [$basename]($relative_path)" >> "$index_file"
        done
        
        cat >> "$index_file" << EOF

## Collegamenti
- [Documentazione Root](../../../docs/index.md)
- [Modulo Xot](../../Xot/docs/index.md)

*Ultimo aggiornamento: $(date +%Y-%m-%d)*
EOF
    fi
}

# Crea indici per tutti i moduli
find "$LARAVEL_ROOT/Modules" -name "docs" -type d | while read -r module_docs; do
    create_module_index "$module_docs"
done

echo ""
echo "6. FASE 6: Validazione finale"
echo "============================="

# Verifica che non ci siano più file con caratteri maiuscoli (eccetto README.md)
uppercase_files=$(find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type f -not -name "README.md" -not -path "*/vendor/*" | wc -l)

if [[ $uppercase_files -eq 0 ]]; then
    echo "✅ SUCCESSO: Nessun file con caratteri maiuscoli trovato (eccetto README.md)"
else
    echo "⚠️  ATTENZIONE: Trovati ancora $uppercase_files file con caratteri maiuscoli"
    find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type f -not -name "README.md" -not -path "*/vendor/*"
fi

# Verifica che non ci siano più cartelle con caratteri maiuscoli
uppercase_dirs=$(find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type d -not -path "*/vendor/*" | wc -l)

if [[ $uppercase_dirs -eq 0 ]]; then
    echo "✅ SUCCESSO: Nessuna cartella con caratteri maiuscoli trovata"
else
    echo "⚠️  ATTENZIONE: Trovate ancora $uppercase_dirs cartelle con caratteri maiuscoli"
    find "$PROJECT_ROOT" -path "*/docs/*" -name "*[A-Z]*" -type d -not -path "*/vendor/*"
fi

echo ""
echo "======================================================="
echo "REFACTOR COMPLETATO!"
echo "======================================================="
echo "Principi applicati:"
echo "- DRY: Eliminazione duplicazioni e consolidamento contenuti"
echo "- KISS: Semplificazione struttura e rimozione complessità"
echo "- Lowercase: Tutti i file e cartelle in minuscolo (eccetto README.md)"
echo "- Collegamenti: Creati indici e collegamenti bidirezionali"
echo "======================================================="
