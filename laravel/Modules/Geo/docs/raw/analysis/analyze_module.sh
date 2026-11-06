#!/bin/bash

# Verifica che sia stato fornito un nome modulo
if [ -z "$1" ]; then
    echo "❌ Devi specificare il nome del modulo"
    echo "Uso: $0 NomeModulo"
    exit 1
fi

# Directory base
BASE_DIR="/var/www/html/ptvx"
LARAVEL_DIR="$BASE_DIR/laravel"
MODULE_NAME=$1
MODULE_DIR="$LARAVEL_DIR/Modules/$MODULE_NAME"

# Verifica che il modulo esista
if [ ! -d "$MODULE_DIR" ]; then
    echo "❌ Il modulo $MODULE_NAME non esiste in $LARAVEL_DIR/Modules/"
    exit 1
fi

# Array dei livelli PHPStan
LEVELS=(1 2 3 4 5 6 7 8 9 max)

# Crea la directory docs/phpstan se non esiste
mkdir -p "$MODULE_DIR/docs/phpstan"

echo "🚀 Inizio analisi PHPStan per il modulo $MODULE_NAME"
echo "----------------------------------------"

# Controlla se il modulo contiene file PHP
if [ -z "$(find "$MODULE_DIR/app" -name "*.php" -type f)" ]; then
    echo "⚠️  Il modulo $MODULE_NAME non contiene file PHP da analizzare"
    exit 0
fi

# Analizza per ogni livello
for level in "${LEVELS[@]}"; do
    echo "📊 Analizzando livello $level..."
    output_file="$MODULE_DIR/docs/phpstan/level_$level.json"
    temp_file="$MODULE_DIR/docs/phpstan/temp_output.txt"
    
    # Rimuovi i file se esistono già
    [ -f "$output_file" ] && rm "$output_file"
    [ -f "$temp_file" ] && rm "$temp_file"
    
    # Esegui l'analisi
    cd "$LARAVEL_DIR" && \
    ./vendor/bin/phpstan analyse \
        --level="$level" \
        --error-format=json \
        --configuration=phpstan.neon \
        "Modules/$MODULE_NAME/app" > "$output_file" 2> "$temp_file"
    
    # Verifica il risultato
    if [ -f "$output_file" ] && [ -s "$output_file" ]; then
        echo "✅ Analisi completata per il livello $level"
        echo "📁 Risultati salvati in: $output_file"
    else
        echo "❌ Errore durante l'analisi del livello $level"
        if [ -f "$temp_file" ]; then
            echo "Errore:"
            cat "$temp_file"
        fi
    fi
    
    # Rimuovi il file temporaneo
    [ -f "$temp_file" ] && rm "$temp_file"
done

echo "----------------------------------------"
echo "📈 Report finale per il modulo $MODULE_NAME:"
echo "📁 I risultati sono salvati in: $MODULE_DIR/docs/phpstan/"
echo "----------------------------------------" 