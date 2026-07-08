#!/bin/bash

# Exit on error, undefined variables, and pipe failures
set -euo pipefail

# Colori per il output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione per stampare messaggi
print_message() {
    local message=$1
    local color=$2
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${color}[${timestamp}] ${message}${NC}"
}

# Funzione per verificare le dipendenze
check_dependencies() {
    local dependencies=("php" "jq")
    local missing_deps=()

    for dep in "${dependencies[@]}"; do
        if ! command -v "$dep" &> /dev/null; then
            missing_deps+=("$dep")
        fi
    done

    if [ ${#missing_deps[@]} -ne 0 ]; then
        print_message "Errore: Le seguenti dipendenze sono mancanti: ${missing_deps[*]}" "$RED"
        print_message "Per installare jq su Ubuntu/Debian: sudo apt-get install jq" "$BLUE"
        exit 1
    fi
}

# Funzione per verificare la configurazione PHPStan
check_phpstan_config() {
    local module=$1
    local config_file="$LARAVEL_DIR/Modules/$module/phpstan.neon.dist"

    if [ ! -f "$config_file" ]; then
        print_message "Attenzione: File di configurazione PHPStan non trovato per il modulo $module" "$YELLOW"
        print_message "Creazione del file di configurazione di default..." "$BLUE"

        cat > "$config_file" << EOF
includes:
    - phpstan-baseline.neon

parameters:
    level: 3
    paths:
        - app

    excludePaths:
        - app/Filament/Pages
        - build
        - vendor
        - Tests
        - rector.php

    ignoreErrors:
        - '#Unsafe usage of new static#'
        - '#Access to an undefined property#'
        - '#Call to an undefined method#'
        - '#Call to an undefined static method#'
        - '#PHPDoc tag @mixin contains unknown class#'
        - '#should return .* but returns#'
EOF
    fi
}

# Funzione per analizzare un modulo
analyze_module() {
    local module=$1
    local level=$2

    print_message "Analisi del modulo $module al livello $level..." "$YELLOW"

    # Crea la directory per i risultati del modulo
    local module_results_dir="$LARAVEL_DIR/Modules/$module/docs/phpstan"
    mkdir -p "$module_results_dir"

    # Verifica la configurazione PHPStan
    check_phpstan_config "$module"

    # Esegui PHPStan e salva sia il formato JSON che MD
    cd "$LARAVEL_DIR" || exit 1

    # Genera il file JSON
    if ! php vendor/bin/phpstan analyse Modules/"$module"/app --level="$level" --error-format=json > "$module_results_dir/level_$level.json"; then
        print_message "Errore durante la generazione del file JSON per $module al livello $level" "$RED"
        return 1
    fi

    # Genera il file MD
    if ! php vendor/bin/phpstan analyse Modules/"$module"/app --level="$level" --error-format=prettyJson | jq -r '.[] | "\(.message) in \(.file) on line \(.line)"' > "$module_results_dir/level_$level.md"; then
        print_message "Errore durante la generazione del file MD per $module al livello $level" "$RED"
        return 1
    fi

    print_message "Analisi completata con successo per $module al livello $level" "$GREEN"
    cd - > /dev/null || exit 1
}

# Main script
main() {
    print_message "Inizio analisi PHPStan" "$BLUE"

    # Verifica le dipendenze
    check_dependencies

    # Trova la directory laravel
    LARAVEL_DIR="laravel"
    if [ ! -d "$LARAVEL_DIR" ]; then
        print_message "Errore: Directory laravel non trovata" "$RED"
        exit 1
    fi

    # Trova tutti i moduli
    MODULES=$(find "$LARAVEL_DIR/Modules" -maxdepth 1 -type d -not -path "$LARAVEL_DIR/Modules" -not -name ".*" -exec basename {} \;)

    if [ -z "$MODULES" ]; then
        print_message "Nessun modulo trovato nella directory Modules" "$YELLOW"
        exit 0
    fi

    # Livelli di analisi in ordine decrescente (da max a min)
    LEVELS=(8 7 6 5 4 3 2 1)

    # Analizza ogni modulo per ogni livello
    for module in $MODULES; do
        print_message "Inizio analisi del modulo: $module" "$YELLOW"

        for level in "${LEVELS[@]}"; do
            if ! analyze_module "$module" "$level"; then
                print_message "Saltando i livelli successivi per il modulo $module" "$YELLOW"
                break
            fi
        done
    done

    print_message "Analisi PHPStan completata per tutti i moduli" "$GREEN"
}

# Esegui lo script
main
