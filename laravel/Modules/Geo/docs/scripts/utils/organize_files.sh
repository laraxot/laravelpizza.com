#!/bin/bash

# Script per organizzare i file nella cartella bashscripts
# Mantiene solo README.md nella root, sposta tutto il resto in sottocartelle

set -e

BASE_DIR="/var/www/html/_bases/base_<nome progetto>/bashscripts"
cd "$BASE_DIR"

echo "=== ORGANIZZAZIONE FILES BASHSCRIPTS ==="
echo "Directory base: $BASE_DIR"
echo ""

# Funzione per spostare o rimuovere file
move_or_remove() {
    local file="$1"
    local target_dir="$2"
    local filename=$(basename "$file")
    
    # Crea la directory di destinazione se non esiste
    mkdir -p "$target_dir"
    
    # Controlla se il file esiste già nella destinazione
    if [ -f "$target_dir/$filename" ]; then
        echo "  ❌ RIMUOVO: $file (già presente in $target_dir/)"
        rm "$file"
    else
        echo "  ✅ SPOSTO: $file -> $target_dir/"
        mv "$file" "$target_dir/"
    fi
}

echo "📁 CATEGORIZZAZIONE E SPOSTAMENTO FILES:"
echo ""

# BACKUP SCRIPTS
echo "🔄 Backup Scripts:"
move_or_remove "./backup.sh" "./backup"

# DOCUMENTATION SCRIPTS
echo "📚 Documentation Scripts:"
move_or_remove "./ORGANIZATION.md" "./docs"
move_or_remove "./docs-audit-dry-kiss.sh" "./docs"
move_or_remove "./docs-consolidation.sh" "./docs"
move_or_remove "./docs-final-optimization.sh" "./docs"
move_or_remove "./docs-naming-audit.sh" "./docs"
move_or_remove "./docs-naming-violations.txt" "./docs"
move_or_remove "./fix-docs-naming-final.sh" "./docs"
move_or_remove "./fix-docs-naming.sh" "./docs"
move_or_remove "./fix_docs_naming.sh" "./docs"
move_or_remove "./fix_docs_naming_final.sh" "./docs"
move_or_remove "./fix_docs_naming_v2.sh" "./docs"
move_or_remove "./fix_docs_naming_violations.sh" "./docs"
move_or_remove "./organize_docs_structure.sh" "./docs"
move_or_remove "./radical-docs-refactor.sh" "./docs"
move_or_remove "./rename_docs_files.sh" "./docs"
move_or_remove "./update_docs.sh" "./docs"

# PHPSTAN SCRIPTS
echo "🔍 PHPStan Scripts:"
move_or_remove "./check_before_phpstan.sh" "./phpstan"
move_or_remove "./create_phpstan_readme.sh" "./phpstan"
move_or_remove "./generate_phpstan_summary.sh" "./phpstan"
move_or_remove "./phpstan_docs_generator.sh" "./phpstan"
move_or_remove "./phpstan_docs_generator_single.sh" "./phpstan"
move_or_remove "./update_roadmap_phpstan_links.sh" "./phpstan"

# FIX SCRIPTS
echo "🔧 Fix Scripts:"
move_or_remove "./fix-psr4-autoloading-violations.sh" "./fix"
move_or_remove "./fix.txt" "./fix"
move_or_remove "./fix_directory_structure.sh" "./fix"
move_or_remove "./fix_errors.sh" "./fix"
move_or_remove "./fix_structure.sh" "./fix"
move_or_remove "./fix_translations.sh" "./fix"

# MCP SCRIPTS
echo "🔌 MCP Scripts:"
move_or_remove "./check_mcp_config.php" "./mcp"
move_or_remove "./mcp-manager-v2.sh" "./mcp"
move_or_remove "./mcp-manager.sh" "./mcp"
move_or_remove "./start-mysql-mcp.sh" "./mcp"

# GIT SCRIPTS
echo "📦 Git Scripts:"
move_or_remove "./git_reset.txt" "./git"
move_or_remove "./parse_gitmodules_ini.sh" "./git"

# UTILITIES
echo "🛠️ Utilities:"
move_or_remove "./check_docs_naming_convention.sh" "./utilities"
move_or_remove "./check_form_schema.php" "./utilities"
move_or_remove "./cleanup-markdown-duplicates.sh" "./utilities"
move_or_remove "./copy_to_mono.sh" "./utilities"
move_or_remove "./sync_to_disk.sh" "./utilities"
move_or_remove "./test_parse.sh" "./utilities"
move_or_remove "./update_enums.sh" "./utilities"
move_or_remove "./update_module_roadmaps_links.sh" "./utilities"

# CONFIG FILES
echo "⚙️ Config Files:"
move_or_remove "./.gitignore" "./config"
move_or_remove "./package.json" "./config"
move_or_remove "./phpunit.xml" "./config"
move_or_remove "./postcss.config.js" "./config"
move_or_remove "./rector.php" "./config"
move_or_remove "./tailwind.config.js" "./config"

# DOCUMENTATION FILES
echo "📄 Documentation Files:"
move_or_remove "./replaces.md" "./docs"
move_or_remove "./server_setup.md" "./docs"

# PROMPT FILES
echo "💬 Prompt Files:"
move_or_remove "./prompt.txt" "./prompts"

# TEMPORARY/TEST FILES
echo "🧪 Temporary/Test Files:"
move_or_remove "./prova123.txt" "./temp"
move_or_remove "./test-2025-02-28.txt" "./temp"
move_or_remove "./test.txt" "./temp"
move_or_remove "./test_2025_03_24.txt" "./temp"
move_or_remove "./tips.txt" "./temp"

echo ""
echo "✅ ORGANIZZAZIONE COMPLETATA!"
echo ""
echo "📋 VERIFICA FINALE:"
echo "Files rimasti nella root:"
ls -la | grep "^-" | grep -v "README.md" || echo "  ✅ Solo README.md presente nella root"

echo ""
echo "📁 Struttura delle sottocartelle:"
find . -maxdepth 2 -type d | sort

echo ""
echo "🎯 OPERAZIONE COMPLETATA CON SUCCESSO!"
