#!/bin/bash

# Script per organizzare i file rimanenti nella root di bashscripts

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

echo "🔧 Organizzazione file rimanenti in corso..."

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

# Categoria: MCP (Model Context Protocol) - file rimanenti
echo "📁 Organizzando script MCP rimanenti..."
for file in mcp-manager*.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "mcp/$file"
    fi
done

# Categoria: PHPStan - file rimanenti
echo "📁 Organizzando script PHPStan rimanenti..."
for file in analyse_module.sh generate_phpstan_docs.php update_roadmap_phpstan_links.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "phpstan/$file"
    fi
done

# Categoria: Git - file rimanenti
echo "📁 Organizzando script Git rimanenti..."
for file in reset_subtrees.sh test_parse.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "git/$file"
    fi
done

# Categoria: Documentation - file rimanenti
echo "📁 Organizzando script documentazione rimanenti..."
for file in update_docs.sh update_module_roadmaps_links.sh tips.txt; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "docs/$file"
    fi
done

# Categoria: Setup/Configuration - file rimanenti
echo "📁 Organizzando script setup rimanenti..."
for file in tailwind.config.js; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "setup/$file"
    fi
done

# Categoria: Temporary files - file rimanenti
echo "📁 Organizzando file temporanei rimanenti..."
for file in test*.txt; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "temp/$file"
    fi
done

# Categoria: Script di organizzazione
echo "📁 Organizzando script di organizzazione..."
for file in organize_*.sh; do
    if [[ -f "$file" ]]; then
        move_file_safe "$file" "utils/$file"
    fi
done

echo ""
echo "✅ Organizzazione file rimanenti completata!"
echo ""
echo "📊 File rimanenti nella root:"
ls -la | grep -E '\.(sh|php|js|json|xml|md|txt)$' | head -10

echo ""
echo "📋 Struttura finale organizzata:"
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