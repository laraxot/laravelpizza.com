#!/bin/bash

# Script per catturare i primi 100 errori PHPStan
# Salva i risultati in docs/phpstan

set -e

# Configurazione
PHPSTAN="./vendor/bin/phpstan"
CONFIG_FILE="phpstan-simple.neon"
OUTPUT_DIR="../docs/phpstan"
MEMORY_LIMIT="8G"
DATE=$(date +"%Y%m%d_%H%M%S")

# Crea la directory di output se non esiste
mkdir -p "$OUTPUT_DIR"

echo "=== PHPStan Error Capture - Top 100 Errors ==="
echo "Config: $CONFIG_FILE"
echo "Output: $OUTPUT_DIR"
echo "Date: $DATE"
echo

# File di output
OUTPUT_FILE="$OUTPUT_DIR/top_100_errors_${DATE}.json"
SUMMARY_FILE="$OUTPUT_DIR/errors_summary_${DATE}.md"

# Funzione per catturare errori da un modulo
capture_module_errors() {
    local module_path=$1
    local module_name=$(basename "$module_path")
    
    echo "Analizzando modulo: $module_name"
    
    # Esegui PHPStan sul modulo
    local temp_file="/tmp/phpstan_${module_name}_${DATE}.json"
    
    if php -d memory_limit=$MEMORY_LIMIT $PHPSTAN analyse \
        --configuration="$CONFIG_FILE" \
        --error-format=json \
        --no-progress \
        "$module_path" > "$temp_file" 2>/dev/null; then
        
        echo "✅ $module_name analizzato con successo"
        echo "$temp_file"
        return 0
    else
        echo "❌ Errore nell'analisi di $module_name"
        return 1
    fi
}

# Lista dei moduli disponibili
MODULES=($(find Modules -maxdepth 1 -type d -name "[A-Z]*" | sort))

# Array per raccogliere tutti gli errori
ALL_ERRORS_JSON="{"
ALL_ERRORS_JSON="$ALL_ERRORS_JSON\"timestamp\":\"$(date +'%Y-%m-%d %H:%M:%S')\","
ALL_ERRORS_JSON="$ALL_ERRORS_JSON\"analysis_type\":\"top_100_errors\","
ALL_ERRORS_JSON="$ALL_ERRORS_JSON\"modules\":{"

TOTAL_ERRORS=0
FIRST_MODULE=true

echo "Inizio analisi moduli..."

for module in "${MODULES[@]}"; do
    if [ $TOTAL_ERRORS -ge 100 ]; then
        echo "Raggiunto limite di 100 errori, fermando l'analisi"
        break
    fi
    
    # Salta moduli problematici
    module_name=$(basename "$module")
    if [ "$module_name" = "Xot" ] || [ "$module_name" = "Media" ]; then
        echo "Saltando modulo $module_name (problematico)"
        continue
    fi
    
    temp_file=$(capture_module_errors "$module")
    
    if [ $? -eq 0 ] && [ -f "$temp_file" ]; then
        # Processa il risultato JSON
        error_count=$(php -r "
        \$json = json_decode(file_get_contents('$temp_file'), true);
        echo isset(\$json['totals']['file_errors']) ? \$json['totals']['file_errors'] : 0;
        ")
        
        if [ "$error_count" -gt 0 ]; then
            if [ "$FIRST_MODULE" = false ]; then
                ALL_ERRORS_JSON="$ALL_ERRORS_JSON,"
            fi
            FIRST_MODULE=false
            
            # Aggiunge il modulo al JSON principale
            ALL_ERRORS_JSON="$ALL_ERRORS_JSON\"$module_name\":$(cat "$temp_file")"
            
            TOTAL_ERRORS=$((TOTAL_ERRORS + error_count))
            echo "  → $error_count errori trovati (totale: $TOTAL_ERRORS)"
        fi
        
        # Pulisci il file temporaneo
        rm -f "$temp_file"
    fi
done

# Chiudi il JSON
ALL_ERRORS_JSON="$ALL_ERRORS_JSON},\"total_errors\":$TOTAL_ERRORS}"

# Salva il risultato
echo "$ALL_ERRORS_JSON" > "$OUTPUT_FILE"

# Crea il file di summary
echo "# PHPStan Error Analysis Summary" > "$SUMMARY_FILE"
echo "**Data:** $(date +'%Y-%m-%d %H:%M:%S')" >> "$SUMMARY_FILE"
echo "**Errori totali trovati:** $TOTAL_ERRORS" >> "$SUMMARY_FILE"
echo "**File di output:** $(basename "$OUTPUT_FILE")" >> "$SUMMARY_FILE"
echo "" >> "$SUMMARY_FILE"
echo "## Errori per modulo" >> "$SUMMARY_FILE"

# Analizza il JSON per creare il summary
php -r "
\$json = json_decode(file_get_contents('$OUTPUT_FILE'), true);
if (isset(\$json['modules'])) {
    foreach (\$json['modules'] as \$module => \$data) {
        if (isset(\$data['totals']['file_errors'])) {
            echo \"- **\$module**: \" . \$data['totals']['file_errors'] . \" errori\n\";
        }
    }
}
" >> "$SUMMARY_FILE"

echo "" >> "$SUMMARY_FILE"
echo "## File con più errori" >> "$SUMMARY_FILE"

# Estrae i file con più errori
php -r "
\$json = json_decode(file_get_contents('$OUTPUT_FILE'), true);
\$file_errors = [];

if (isset(\$json['modules'])) {
    foreach (\$json['modules'] as \$module => \$data) {
        if (isset(\$data['files'])) {
            foreach (\$data['files'] as \$file => \$fileData) {
                \$file_errors[\$file] = \$fileData['errors'];
            }
        }
    }
}

arsort(\$file_errors);
\$top_files = array_slice(\$file_errors, 0, 20, true);

foreach (\$top_files as \$file => \$errors) {
    \$short_file = str_replace('/var/www/html/_bases/base_<nome progetto>_fila5_mono/laravel/', '', \$file);
    echo \"- **\$short_file**: \$errors errori\n\";
}
" >> "$SUMMARY_FILE"

echo
echo "=== Analisi completata ==="
echo "Errori totali: $TOTAL_ERRORS"
echo "File JSON: $OUTPUT_FILE"
echo "File Summary: $SUMMARY_FILE"
echo
echo "Per visualizzare il summary:"
echo "  cat $SUMMARY_FILE"
echo
echo "Per visualizzare i primi errori:"
echo "  jq -r '.modules | to_entries | .[0].value.files | to_entries | .[0].value.messages' $OUTPUT_FILE" 