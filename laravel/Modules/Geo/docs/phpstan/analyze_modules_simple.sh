#!/bin/bash

# Script semplificato per analizzare i moduli PHPStan
# Ignora completamente la configurazione esistente

set -e

# Configurazione
PHPSTAN="./vendor/bin/phpstan"
TARGET_DIR="Modules"
OUTPUT_DIR="../docs/phpstan"
MEMORY_LIMIT="8G"
DATE=$(date +"%Y%m%d_%H%M%S")

# Crea la directory di output se non esiste
mkdir -p "$OUTPUT_DIR"

echo "=== PHPStan Analysis - Moduli Singoli ==="
echo "Target: $TARGET_DIR"
echo "Memoria: $MEMORY_LIMIT"
echo "Output: $OUTPUT_DIR"
echo

# Lista dei moduli da analizzare (escludiamo Xot come da configurazione)
modules=($(ls -d $TARGET_DIR/*/ | xargs -n 1 basename | grep -v "^Xot$"))

echo "Moduli trovati: ${#modules[@]}"
echo "Moduli: ${modules[*]}"
echo

# Funzione per analizzare un singolo modulo
analyze_module() {
    local module=$1
    local level=$2
    local output_file="$OUTPUT_DIR/${module}_level_${level}_${DATE}.json"
    
    echo "Analizzando modulo $module al livello $level..."
    
    # Esegui PHPStan con configurazione minimale
    if php -d memory_limit=$MEMORY_LIMIT $PHPSTAN analyse \
        --level=$level \
        --error-format=json \
        --no-progress \
        --no-interaction \
        "$TARGET_DIR/$module" 2>/dev/null > "$output_file.tmp"; then
        
        # Processa il risultato
        php -r "
        \$input = file_get_contents('$output_file.tmp');
        \$json = json_decode(\$input, true);
        
        \$result = [
            'timestamp' => date('Y-m-d H:i:s'),
            'module' => '$module',
            'level' => $level,
            'total_errors_found' => 0,
            'files_analyzed' => 0,
            'files' => []
        ];
        
        if (isset(\$json['files']) && !empty(\$json['files'])) {
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
            
            \$result['total_errors_found'] = \$count;
            \$result['files_analyzed'] = count(\$result_files);
            \$result['files'] = \$result_files;
        } else {
            \$result['note'] = 'No errors found or no files analyzed';
            \$result['raw_output'] = \$input;
        }
        
        file_put_contents('$output_file', json_encode(\$result, JSON_PRETTY_PRINT));
        echo \$result['total_errors_found'] . ' errori trovati';
        "
        
        rm -f "$output_file.tmp"
        
        # Restituisci il numero di errori trovati
        cat "$output_file" | grep -o '"total_errors_found": [0-9]*' | cut -d':' -f2 | tr -d ' '
    else
        echo "0"
        rm -f "$output_file.tmp"
    fi
}

# Cerca errori partendo dal livello 6 (più restrittivo)
total_errors_found=0
modules_with_errors=()

for level in 6 7 8 9; do
    echo "=== Testando livello $level ==="
    
    for module in "${modules[@]}"; do
        if [ $total_errors_found -ge 100 ]; then
            break 2
        fi
        
        echo -n "  $module: "
        errors=$(analyze_module "$module" "$level")
        
        if [ "$errors" -gt 0 ]; then
            echo "✅ $errors errori"
            modules_with_errors+=("$module:$level:$errors")
            total_errors_found=$((total_errors_found + errors))
        else
            echo "✓ pulito"
        fi
    done
    
    if [ $total_errors_found -gt 0 ]; then
        echo "Trovati $total_errors_found errori totali al livello $level"
        break
    fi
    
    echo "Nessun errore al livello $level, proviamo il successivo..."
    echo
done

echo
echo "=== Riepilogo Analisi ==="
echo "Errori totali trovati: $total_errors_found"
echo "Moduli con errori:"
for entry in "${modules_with_errors[@]}"; do
    IFS=':' read -r mod lev err <<< "$entry"
    echo "  - $mod (livello $lev): $err errori"
done

echo
echo "File di output disponibili in: $OUTPUT_DIR"
echo "Per visualizzare i risultati:"
echo "  find $OUTPUT_DIR -name '*_${DATE}.json' -exec echo '=== {} ===' \; -exec cat {} \;"
