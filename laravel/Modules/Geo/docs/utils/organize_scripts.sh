#!/bin/bash

# Script per organizzare i file nella root di bashscripts nelle sottocartelle appropriate
# Mantiene i file esistenti e rimuove i duplicati

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

echo "🔧 Organizzazione script bash in corso..."

# Funzione per spostare file mantenendo quelli esistenti
move_file_safe() {
    local source="$1"
    local dest="$2"
    local dest_dir="$(dirname "$dest")"
    
    # Crea la directory di destinazione se non esiste
    mkdir -p "$dest_dir"
    
    # Se il file di destinazione esiste, mantieni quello e rimuovi il sorgente
    if [[ -f "$dest" ]]; then
        echo "⚠️  File esistente mantenuto: $dest"
        echo "🗑️  Rimuovendo duplicato: $source"
        rm "$source"
    else
        # Sposta il file
        mv "$source" "$dest"
        echo "✅ Spostato: $source -> $dest"
    fi
}

# Categoria: Git operations
echo "📁 Organizzando script Git..."
for file in git_*.sh git_*.md git_*.txt init-subtrees.sh sync_submodules.sh sync_to_disk.sh resolve_git_*.sh rebase_*.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "git/$file"
    fi
done

# Categoria: PHPStan analysis
echo "📁 Organizzando script PHPStan..."
for file in phpstan_*.sh run_phpstan*.sh analyze_*.sh check_before_phpstan.sh create_phpstan_*.sh generate_phpstan_*.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "phpstan/$file"
    fi
done

# Categoria: Documentation
echo "📁 Organizzando script documentazione..."
for file in fix_docs_*.sh rename_docs_*.sh generate_doc_*.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "docs/$file"
    fi
done

# Categoria: Translations
echo "📁 Organizzando script traduzioni..."
for file in *translation*.sh *translation*.php rewrite_*_translations.sh improve_*_translations.sh fix_*_translations.sh check_duplicate_translations.sh update_enums.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "translations/$file"
    fi
done

# Categoria: MCP (Model Context Protocol)
echo "📁 Organizzando script MCP..."
for file in mcp_*.sh start-mysql-mcp.sh check_mcp_*.php mysql-db-connector.js; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "mcp/$file"
    fi
done

# Categoria: Composer
echo "📁 Organizzando script Composer..."
for file in composer_*.sh get_composer.sh composer.json; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "composer/$file"
    fi
done

# Categoria: MySQL/Database
echo "📁 Organizzando script MySQL..."
for file in check_mysql*.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "mysql/$file"
    fi
done

# Categoria: Maintenance
echo "📁 Organizzando script manutenzione..."
for file in backup.sh fix_*.sh fix.txt; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "maintenance/$file"
    fi
done

# Categoria: Setup/Configuration
echo "📁 Organizzando script setup..."
for file in server_setup.md package.json phpunit.xml postcss.config.js rector.php; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "setup/$file"
    fi
done

# Categoria: Utilities
echo "📁 Organizzando script utility..."
for file in parse_gitmodules_ini.sh copy_to_mono.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "utils/$file"
    fi
done

# Categoria: Testing
echo "📁 Organizzando script testing..."
for file in check_form_schema.php; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "testing/$file"
    fi
done

# Categoria: Prompts
echo "📁 Organizzando file prompts..."
for file in prompt.txt prompt*.txt; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "prompts/$file"
    fi
done

# Categoria: Logs
echo "📁 Organizzando file di log..."
for file in *.log; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "logs/$file"
    fi
done

# Categoria: Markdown files
echo "📁 Organizzando file markdown..."
for file in *.md; do
    if [[ -f "$file" && "$file" != "README.md" ]]; then
        move_file_safe "$file" "docs/$file"
    fi
done

# Categoria: Temporary files
echo "📁 Organizzando file temporanei..."
for file in prova*.txt *.test; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "temp/$file"
    fi
done

echo ""
echo "✅ Organizzazione completata!"
echo ""
echo "📊 File rimanenti nella root:"
ls -la | grep -E '\.(sh|php|js|json|xml|md)$' | head -10

echo ""
echo "📋 Struttura finale:"
echo "bashscripts/"
echo "├── git/           # Operazioni Git e subtree"
echo "├── phpstan/       # Analisi PHPStan"
echo "├── docs/          # Documentazione e script docs"
echo "├── translations/  # Script traduzioni"
echo "├── mcp/           # Model Context Protocol"
echo "├── composer/      # Gestione Composer"
echo "├── mysql/         # Script MySQL/Database"
echo "├── maintenance/   # Script manutenzione"
echo "├── setup/         # Setup e configurazione"
echo "├── utils/         # Utility generali"
echo "├── testing/       # Script testing"
echo "├── prompts/       # File prompts"
echo "├── logs/          # File di log"
echo "├── temp/          # File temporanei"
echo "└── README.md      # Documentazione principale" 