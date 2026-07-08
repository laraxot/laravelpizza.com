#!/bin/bash

# Directory base
BASE_DIR="/var/www/html/ptvx"
LARAVEL_DIR="$BASE_DIR/laravel"
MODULES_DIR="$LARAVEL_DIR/Modules"
PHPSTAN_PATH="$LARAVEL_DIR/vendor/bin/phpstan"

# Array dei livelli PHPStan
LEVELS=(1 2 3 4 5 6 7 8 9 max)

# Funzione per analizzare un modulo
analyze_module() {
    local module_name=$1
    local module_dir="$MODULES_DIR/$module_name"
    local docs_dir="$module_dir/docs/phpstan"
    
    echo "🚀 Inizio analisi PHPStan per il modulo $module_name"
    echo "----------------------------------------"
    
    # Crea la directory per la documentazione PHPStan se non esiste
    mkdir -p "$docs_dir"
    
    # Analizza per ogni livello
    for level in "${LEVELS[@]}"; do
        echo "📊 Analizzando livello $level..."
        cd "$LARAVEL_DIR" && php "$PHPSTAN_PATH" analyse "$module_dir/app" --level="$level" --error-format=json > "$docs_dir/level_$level.json"
        echo "✅ Analisi completata per il livello $level"
        echo "📁 Risultati salvati in: $docs_dir/level_$level.json"
    done
    
    echo "----------------------------------------"
    echo "📈 Report finale per il modulo $module_name:"
    echo "📁 I risultati sono salvati in: $docs_dir/"
    echo "----------------------------------------"
}

# Ottieni tutti i moduli
modules=($(ls -d "$MODULES_DIR"/*/ | xargs -n1 basename))

# Analizza ogni modulo
for module in "${modules[@]}"; do
    # Escludi la directory docs_template
    if [ "$module" != "docs_template" ]; then
        analyze_module "$module"
    fi
done

echo "✅ Analisi completata per tutti i moduli!" 