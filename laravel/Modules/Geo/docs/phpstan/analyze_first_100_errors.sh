#!/bin/bash

# Script per analizzare i primi 100 errori PHPStan senza baseline
# Creato per l'analisi sistematica dei moduli

set -e

# Configurazione
PHPSTAN="./vendor/bin/phpstan"
LEVEL="1"  # Iniziamo da livello 1
TARGET_DIR="Modules"
OUTPUT_DIR="../docs/phpstan"
MEMORY_LIMIT="8G"
DATE=$(date +"%Y%m%d_%H%M%S")

# Crea la directory di output se non esiste
mkdir -p "$OUTPUT_DIR"

echo "=== PHPStan Analysis - Prime 100 Errori (Senza Baseline) ==="
echo "Livello: $LEVEL"
echo "Target: $TARGET_DIR"
echo "Memoria: $MEMORY_LIMIT"
echo "Output: $OUTPUT_DIR"
echo

# Crea un file di configurazione temporaneo senza baseline
TEMP_CONFIG="/tmp/phpstan_no_baseline_${DATE}.neon"

cat > "$TEMP_CONFIG" << 'EOF'
includes:
    - ./vendor/larastan/larastan/extension.neon
    - ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon
    - ./vendor/phpstan/phpstan/conf/bleedingEdge.neon

parameters:
    level: 1
    
    parallel:
        maximumNumberOfProcesses: 16
        jobSize: 20
        minimumNumberOfJobsPerProcess: 2

    paths:
        - ./Modules

    ignoreErrors:
        - '#PHPDoc tag @mixin contains unknown class #'
        - '#Static call to instance method Nwidart#'
        - '#is used zero times and is not analysed#'
        - "#^Unsafe usage of new static#"

    excludePaths:
        - ./*/vendor/*
        - ./*/build/*
        - ./*/docs/*
        - ./*/Tests/*
        - ./Modules/*/phpinsights.php
        - ./Modules/*/rector.php
        - ./Modules/*/packages/*
        - ./Modules/*/tests/*
        - ./Modules/*/Tests/*

    bootstrapFiles:
        - ./bootstrap/app.php
EOF

# Funzione per analizzare e ottenere i primi 100 errori
analyze_first_100() {
    local level=$1
    local output_file="$OUTPUT_DIR/first_100_errors_level_${level}_${DATE}.json"
    
    echo "Esecuzione PHPStan livello $level senza baseline..."
    
    # Aggiorna il livello nel file di configurazione temporaneo
    sed -i "s/level: 1/level: $level/" "$TEMP_CONFIG"
    
    if php -d memory_limit=$MEMORY_LIMIT $PHPSTAN analyse \
        --configuration="$TEMP_CONFIG" \
        --error-format=json \
        --no-progress \
        $TARGET_DIR 2>/dev/null | \
        php -r "
        \$input = stream_get_contents(STDIN);
        \$json = json_decode(\$input, true);
        
        if (!isset(\$json['files'])) {
            \$result = [
                'timestamp' => date('Y-m-d H:i:s'),
                'level' => $level,
                'total_errors_found' => 0,
                'files_analyzed' => 0,
                'error' => 'No files analyzed or no errors found',
                'raw_output' => \$input
            ];
            file_put_contents('$output_file', json_encode(\$result, JSON_PRETTY_PRINT));
            echo \"Nessun errore trovato al livello $level\\n\";
            exit(0);
        }
        
        \$count = 0;
        \$result_files = [];
        
        foreach (\$json['files'] as \$file => \$data) {
            if (!isset(\$data['messages']) || empty(\$data['messages'])) continue;
            
            \$remaining = 100 - \$count;
            if (\$remaining <= 0) break;
            
            \$messages = array_slice(\$data['messages'], 0, \$remaining);
            \$count += count(\$messages);
            
            \$result_files[\$file] = [
                'errors' => count(\$messages),
                'messages' => \$messages
            ];
        }
        
        \$result = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'total_errors_found' => \$count,
            'files_analyzed' => count(\$result_files),
            'files' => \$result_files
        ];
        
        file_put_contents('$output_file', json_encode(\$result, JSON_PRETTY_PRINT));
        echo \"Analisi completata: \$count errori trovati\\n\";
        "; then
        echo "✅ Analisi livello $level completata: $output_file"
        return 0
    else
        echo "❌ Errore nell'analisi livello $level"
        return 1
    fi
}

# Esegui l'analisi per più livelli
echo "Inizio analisi PHPStan per più livelli..."

for level in 1 2 3 4 5 6 7 8 9; do
    echo "=== Analizzando livello $level ==="
    analyze_first_100 $level
    
    # Verifica se abbiamo trovato errori
    latest_file=$(ls -t "$OUTPUT_DIR"/first_100_errors_level_${level}_*.json | head -1)
    error_count=$(cat "$latest_file" | grep -o '"total_errors_found": [0-9]*' | cut -d':' -f2 | tr -d ' ')
    
    if [ "$error_count" -gt 0 ]; then
        echo "✅ Trovati $error_count errori al livello $level"
        echo "Fermiamo qui per analizzare questi errori."
        break
    else
        echo "ℹ️  Nessun errore al livello $level, proviamo il successivo..."
    fi
    
    echo
done

# Pulisci il file temporaneo
rm -f "$TEMP_CONFIG"

echo
echo "=== Analisi PHPStan completata ==="
echo "File di output disponibili in: $OUTPUT_DIR"
echo "Per visualizzare i risultati:"
echo "  cat $OUTPUT_DIR/first_100_errors_level_${LEVEL}_${DATE}.json | jq ."
