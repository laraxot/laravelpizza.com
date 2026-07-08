#!/bin/bash

# Script per analizzare i primi 100 errori PHPStan
# Versione migliorata con gestione errori e fallback

set -e

# Configurazione
PHPSTAN="./vendor/bin/phpstan"
LEVEL="3"  # Iniziamo da livello 3 per evitare errori
TARGET_DIR="Modules"
OUTPUT_DIR="../docs/phpstan"
MEMORY_LIMIT="8G"
DATE=$(date +"%Y%m%d_%H%M%S")

# Crea la directory di output se non esiste
mkdir -p "$OUTPUT_DIR"

echo "=== PHPStan Analysis - Prime 100 Errori ==="
echo "Livello: $LEVEL"
echo "Target: $TARGET_DIR"
echo "Memoria: $MEMORY_LIMIT"
echo "Output: $OUTPUT_DIR"
echo

# Funzione per analizzare tutti i moduli
analyze_all_modules() {
    local level=$1
    local output_file="$OUTPUT_DIR/level_${level}_first_100_${DATE}.json"
    
    echo "Esecuzione PHPStan livello $level su tutti i moduli..."
    
    if php -d memory_limit=$MEMORY_LIMIT $PHPSTAN analyse \
        --level=$level \
        --error-format=json \
        --no-progress \
        $TARGET_DIR 2>/dev/null | \
        php -r "
        \$input = stream_get_contents(STDIN);
        \$json = json_decode(\$input, true);
        
        if (!isset(\$json['files'])) {
            file_put_contents('$output_file', json_encode([
                'error' => 'No files analyzed',
                'raw_output' => \$input
            ], JSON_PRETTY_PRINT));
            exit(1);
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

# Funzione per analizzare modulo per modulo
analyze_by_modules() {
    local level=$1
    local output_file="$OUTPUT_DIR/modules_level_${level}_first_100_${DATE}.json"
    
    echo "Esecuzione PHPStan livello $level modulo per modulo..."
    
    local modules=($(ls -d $TARGET_DIR/*/ | xargs -n 1 basename))
    local all_errors=[]
    local total_count=0
    
    echo "{"
    echo "  \"timestamp\": \"$(date +'%Y-%m-%d %H:%M:%S')\","
    echo "  \"level\": $level,"
    echo "  \"analysis_type\": \"by_modules\","
    echo "  \"modules\": {"
    
    local first=true
    
    for module in "${modules[@]}"; do
        if [ $total_count -ge 100 ]; then
            break
        fi
        
        # Salta il modulo Xot che spesso ha problemi
        if [ "$module" = "Xot" ]; then
            continue
        fi
        
        echo "Analizzando modulo: $module"
        
        if [ "$first" = false ]; then
            echo ","
        fi
        first=false
        
        local temp_output="/tmp/phpstan_${module}_${DATE}.json"
        
        if php -d memory_limit=$MEMORY_LIMIT $PHPSTAN analyse \
            --level=$level \
            --error-format=json \
            --no-progress \
            "$TARGET_DIR/$module" 2>/dev/null > "$temp_output"; then
            
            # Elabora il risultato
            php -r "
            \$json = json_decode(file_get_contents('$temp_output'), true);
            \$module_errors = [];
            \$count = 0;
            \$remaining = 100 - $total_count;
            
            if (isset(\$json['files'])) {
                foreach (\$json['files'] as \$file => \$data) {
                    if (!isset(\$data['messages']) || empty(\$data['messages'])) continue;
                    
                    \$messages = array_slice(\$data['messages'], 0, \$remaining - \$count);
                    \$count += count(\$messages);
                    
                    \$module_errors[\$file] = [
                        'errors' => count(\$messages),
                        'messages' => \$messages
                    ];
                    
                    if (\$count >= \$remaining) break;
                }
            }
            
            echo '    \"$module\": {';
            echo '      \"errors_count\": ' . \$count . ',';
            echo '      \"files\": ' . json_encode(\$module_errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            echo '    }';
            "
            
            # Aggiorna il conteggio totale
            local module_count=$(php -r "
            \$json = json_decode(file_get_contents('$temp_output'), true);
            \$count = 0;
            if (isset(\$json['files'])) {
                foreach (\$json['files'] as \$file => \$data) {
                    if (isset(\$data['messages'])) {
                        \$count += count(\$data['messages']);
                    }
                }
            }
            echo min(\$count, 100 - $total_count);
            ")
            
            total_count=$((total_count + module_count))
            
        else
            echo "    \"$module\": {"
            echo "      \"error\": \"Analysis failed\""
            echo "    }"
        fi
        
        rm -f "$temp_output"
    done
    
    echo
    echo "  },"
    echo "  \"total_errors\": $total_count"
    echo "}" > "$output_file"
    
    echo "✅ Analisi per moduli completata: $output_file ($total_count errori)"
}

# Esecuzione principale
echo "Tentativo di analisi completa..."
if ! analyze_all_modules $LEVEL; then
    echo
    echo "Analisi completa fallita, provo modulo per modulo..."
    analyze_by_modules $LEVEL
fi

echo
echo "=== Analisi PHPStan completata ==="
echo "File di output disponibili in: $OUTPUT_DIR"
echo "Per visualizzare i risultati:"
echo "  cat $OUTPUT_DIR/level_*_first_100_*.json | head -50" 