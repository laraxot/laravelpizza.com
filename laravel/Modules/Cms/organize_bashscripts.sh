#!/bin/bash

# Script per organizzare i file nella cartella bashscripts
# Mantiene solo README.md nella root e sposta tutto il resto in sottocartelle

BASHSCRIPTS_DIR="/var/www/html/_bases/base_saluteora/bashscripts"
cd "$BASHSCRIPTS_DIR"

echo "Inizio organizzazione dei file bashscripts..."

# Funzione per spostare un file, eliminando il duplicato se esiste
move_file() {
    local source="$1"
    local dest_dir="$2"
    local filename=$(basename "$source")
    
    # Crea la directory di destinazione se non esiste
    mkdir -p "$dest_dir"
    
    # Se il file esiste già nella destinazione, elimina quello che stiamo per spostare
    if [ -f "$dest_dir/$filename" ]; then
        echo "File $filename già esistente in $dest_dir - eliminando il duplicato dalla root"
        rm "$source"
    else
        echo "Spostando $filename in $dest_dir/"
        mv "$source" "$dest_dir/"
    fi
}

# Git-related files
echo "Organizzando file Git..."
for file in git_*.sh git_*.md git-*.md git_*.txt git-*.txt init-subtrees.sh reset_subtrees.sh parse_gitmodules_ini.sh sync_submodules.sh; do
    [ -f "$file" ] && move_file "$file" "git"
done

# PHPStan files
echo "Organizzando file PHPStan..."
for file in phpstan_*.sh phpstan_*.php run_phpstan*.sh generate_phpstan*.sh create_phpstan*.sh; do
    [ -f "$file" ] && move_file "$file" "phpstan"
done

# Translation files
echo "Organizzando file traduzioni..."
for file in fix_*translations*.sh verify_translations*.sh; do
    [ -f "$file" ] && move_file "$file" "translations"
done

# Fix/maintenance files
echo "Organizzando file fix e manutenzione..."
for file in fix_*.sh fix_*.md fix.txt fix_*.txt; do
    [ -f "$file" ] && move_file "$file" "fix"
done

# Documentation files
echo "Organizzando file documentazione..."
for file in docs_*.sh docs_*.md docs_*.txt rename_docs_files.sh update_docs.sh update_*_links.sh *_docs_*.md *_docs_*.sh; do
    [ -f "$file" ] && move_file "$file" "docs"
done

# Analysis files
echo "Organizzando file analisi..."
for file in analys*.sh analys*.md check_*.sh check_*.php; do
    [ -f "$file" ] && move_file "$file" "utils"
done

# Configuration files
echo "Organizzando file configurazione..."
for file in *.json *.js *.xml *.php rector.php composer.json package.json phpunit.xml postcss.config.js tailwind.config.js; do
    [ -f "$file" ] && move_file "$file" "config"
done

# Backup files
echo "Organizzando file backup..."
for file in backup*.sh sync_to_disk.sh copy_to_mono.sh; do
    [ -f "$file" ] && move_file "$file" "backup"
done

# Composer files
echo "Organizzando file Composer..."
for file in composer*.sh get_composer.sh; do
    [ -f "$file" ] && move_file "$file" "composer"
done

# Conflict resolution files
echo "Organizzando file risoluzione conflitti..."
for file in conflict*.md conflict*.sh resolve_*.sh scripts*conflict*.md; do
    [ -f "$file" ] && move_file "$file" "utils"
done

# Test files
echo "Organizzando file test..."
for file in test*.sh test*.txt test_*.txt *test*.txt test-*.txt; do
    [ -f "$file" ] && move_file "$file" "testing"
done

# Documentation and readme files
echo "Organizzando file readme e documentazione..."
for file in readme.*.md *.md; do
    # Escludi README.md (deve rimanere nella root)
    if [ "$file" != "README.md" ]; then
        [ -f "$file" ] && move_file "$file" "docs"
    fi
done

# Prompt files
echo "Organizzando file prompt..."
for file in prompt*.txt prompt*.md nuovo_formato_prompt.md; do
    [ -f "$file" ] && move_file "$file" "prompts"
done

# Log files
echo "Organizzando file log..."
for file in *.log aggiornamento_log.txt; do
    [ -f "$file" ] && move_file "$file" "logs"
done

# Rebase files
echo "Organizzando file rebase..."
for file in rebase*.sh; do
    [ -f "$file" ] && move_file "$file" "git"
done

# Temporary and test files
echo "Organizzando file temporanei..."
for file in prova*.txt tips.txt zibibbo-*.test; do
    [ -f "$file" ] && move_file "$file" "temp"
done

# Remaining files (utilities)
echo "Spostando i file rimanenti in utils..."
for file in *; do
    # Salta directory e README.md
    if [ -f "$file" ] && [ "$file" != "README.md" ]; then
        move_file "$file" "utils"
    fi
done

echo "Organizzazione completata!"
echo "Verifica dei file rimasti nella root:"
ls -la | grep -v "^d" | grep -v "README.md" || echo "Nessun file rimasto nella root (eccetto README.md)"
