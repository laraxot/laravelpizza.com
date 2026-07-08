#!/bin/bash

# PHPStan Code Quality Analyzer
# Analizza la qualità del codice di tutti i moduli Laravel

set -euo pipefail

# Configurazione
LARAVEL_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono/laravel"
PHPSTAN_BIN="./vendor/bin/phpstan"
DOCS_PHPSTAN_DIR="/var/www/html/_bases/base_<nome progetto>_fila5_mono/docs/phpstan"
MAX_ERRORS=100
MEMORY_LIMIT="2G"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzioni di logging
log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verifica prerequisiti
check_prerequisites() {
    log_info "Verifica prerequisiti..."
    
    if [[ ! -d "$LARAVEL_DIR" ]]; then
        log_error "Directory Laravel non trovata: $LARAVEL_DIR"
        exit 1
    fi
    
    cd "$LARAVEL_DIR"
    
    if [[ ! -f "$PHPSTAN_BIN" ]]; then
        log_error "PHPStan non trovato: $PHPSTAN_BIN"
        exit 1
    fi
    
    if [[ ! -d "Modules" ]]; then
        log_error "Directory Modules non trovata"
        exit 1
    fi
    
    # Crea directory docs se non esiste
    mkdir -p "$DOCS_PHPSTAN_DIR"
    
    log_success "Prerequisiti verificati"
}

# Ottieni lista moduli
get_modules() {
    find Modules/ -maxdepth 1 -type d | grep -v "^Modules/$" | sort
}

# Analizza singolo modulo
analyze_module() {
    local module_dir=$1
    local module_name=$(basename "$module_dir")
    
    log_info "Analisi modulo: $module_name"
    
    # Crea directory per i report del modulo
    local module_docs_dir="$DOCS_PHPSTAN_DIR/$module_name"
    mkdir -p "$module_docs_dir"
    
    # File di output
    local output_file="$module_docs_dir/analysis_${TIMESTAMP}.json"
    local errors_file="$module_docs_dir/top_errors_${TIMESTAMP}.txt"
    local summary_file="$module_docs_dir/summary_${TIMESTAMP}.md"
    
    log_info "Esecuzione PHPStan per $module_name..."
    
    # Esegui PHPStan con output JSON
    if $PHPSTAN_BIN analyse \
        --memory-limit="$MEMORY_LIMIT" \
        --error-format=json \
        --no-progress \
        "$module_dir" > "$output_file" 2>/dev/null; then
        
        log_success "Analisi completata per $module_name"
        
        # Estrai i primi errori più critici
        extract_top_errors "$output_file" "$errors_file" "$module_name"
        
        # Genera summary
        generate_module_summary "$output_file" "$summary_file" "$module_name"
        
    else
        log_warning "Errori trovati in $module_name, ma analisi completata"
        
        # Anche in caso di errori, estrai le informazioni
        extract_top_errors "$output_file" "$errors_file" "$module_name"
        generate_module_summary "$output_file" "$summary_file" "$module_name"
    fi
}

# Estrai i primi errori più critici
extract_top_errors() {
    local json_file=$1
    local errors_file=$2
    local module_name=$3
    
    log_info "Estrazione top errori per $module_name..."
    
    # Usa jq per estrarre gli errori se disponibile, altrimenti parsing manuale
    if command -v jq &> /dev/null; then
        jq -r '.files[].messages[] | "\(.line): \(.message)"' "$json_file" | \
        head -n "$MAX_ERRORS" > "$errors_file" 2>/dev/null || true
    else
        # Parsing manuale se jq non disponibile
        grep -o '"message":"[^"]*"' "$json_file" | \
        sed 's/"message":"//g' | \
        sed 's/"$//g' | \
        head -n "$MAX_ERRORS" > "$errors_file" 2>/dev/null || true
    fi
    
    local error_count=$(wc -l < "$errors_file" 2>/dev/null || echo "0")
    log_info "Estratti $error_count errori per $module_name"
}

# Genera summary per modulo
generate_module_summary() {
    local json_file=$1
    local summary_file=$2
    local module_name=$3
    
    log_info "Generazione summary per $module_name..."
    
    local total_errors=0
    local total_files=0
    
    # Calcola statistiche
    if command -v jq &> /dev/null; then
        total_errors=$(jq '[.files[].messages[]] | length' "$json_file" 2>/dev/null || echo "0")
        total_files=$(jq '.files | length' "$json_file" 2>/dev/null || echo "0")
    else
        total_errors=$(grep -c '"message":' "$json_file" 2>/dev/null || echo "0")
        total_files=$(grep -c '"file":' "$json_file" 2>/dev/null || echo "0")
    fi
    
    # Calcola errori per file (evita divisione per zero)
    local errors_per_file="N/A"
    if [[ $total_files -gt 0 ]]; then
        errors_per_file=$(echo "scale=2; $total_errors / $total_files" | bc 2>/dev/null || echo "N/A")
    fi
    
    # Determina stato qualità
    local quality_status="❓ N/A"
    if [[ $total_errors -lt 10 ]]; then
        quality_status="🟢 Buono"
    elif [[ $total_errors -lt 50 ]]; then
        quality_status="🟡 Medio"
    else
        quality_status="🔴 Critico"
    fi
    
    # Genera summary markdown
    cat > "$summary_file" << EOF
# PHPStan Analysis Summary - $module_name

## Panoramica
- **Data analisi**: $(date)
- **Modulo**: $module_name
- **Totale errori**: $total_errors
- **File coinvolti**: $total_files

## Metriche Qualità

### Priorità Correzione
1. **Critici**: Type safety, undefined methods
2. **Sicurezza**: Input validation, SQL injection
3. **Performance**: N+1 queries, loops inefficienti
4. **Manutenibilità**: Code duplication, complessità

### Quality Score
- **Errori per file**: $errors_per_file
- **Stato qualità**: $quality_status

## Raccomandazioni

### Immediate
- Implementare type hints rigorosi
- Aggiungere PHPDoc documentation
- Verificare esistenza metodi/proprietà

### A medio termine
- Refactoring classi complesse
- Miglioramento architettura modulare
- Implementazione test automatici

### Link Correlati
- [Documentazione Modulo](./../../Modules/$module_name/docs/)
- [Best Practices PHPStan](./../../docs/phpstan/)
- [Guida Qualità Codice](./../../docs/code-quality.md)

## File Analisi
- **Report JSON**: analysis_${TIMESTAMP}.json
- **Top Errori**: top_errors_${TIMESTAMP}.txt
- **Summary**: summary_${TIMESTAMP}.md
EOF
    
    log_success "Summary generato per $module_name"
}

# Genera report globale
generate_global_report() {
    log_info "Generazione report globale..."
    
    local global_report="$DOCS_PHPSTAN_DIR/global_analysis_${TIMESTAMP}.md"
    local modules=($(get_modules))
    local total_modules=${#modules[@]}
    local total_errors=0
    
    # Header del report globale
    cat > "$global_report" << EOF
# PHPStan Global Analysis Report

## Panoramica Progetto
- **Data analisi**: $(date)
- **Totale moduli analizzati**: $total_modules
- **PHPStan versione**: $($PHPSTAN_BIN --version)
- **Memory limit**: $MEMORY_LIMIT

## Moduli Analizzati

| Modulo | Errori | Stato | Link Summary |
|--------|--------|-------|--------------|
EOF
    
    # Analizza ogni modulo per il report globale
    for module_dir in "${modules[@]}"; do
        local module_name=$(basename "$module_dir")
        local module_docs_dir="$DOCS_PHPSTAN_DIR/$module_name"
        local latest_summary=$(find "$module_docs_dir" -name "summary_*.md" 2>/dev/null | sort | tail -1)
        
        if [[ -f "$latest_summary" ]]; then
            local errors=$(grep "Totale errori" "$latest_summary" | grep -o '[0-9]\+' || echo "0")
            local status=$(grep "Stato qualità" "$latest_summary" | cut -d':' -f2 | xargs || echo "N/A")
            total_errors=$((total_errors + errors))
            
            echo "| $module_name | $errors | $status | [Summary](./$module_name/$(basename "$latest_summary")) |" >> "$global_report"
        else
            echo "| $module_name | N/A | ❓ Non analizzato | N/A |" >> "$global_report"
        fi
    done
    
    # Footer con statistiche globali
    cat >> "$global_report" << EOF

## Statistiche Globali
- **Totale errori**: $total_errors
- **Media errori per modulo**: $(echo "scale=2; $total_errors / $total_modules" | bc 2>/dev/null || echo "N/A")
- **Qualità progetto**: $(if [[ $total_errors -lt 100 ]]; then echo "🟢 Buono"; elif [[ $total_errors -lt 500 ]]; then echo "🟡 Medio"; else echo "🔴 Critico"; fi)

## Prossimi Passi
1. **Priorità Alta**: Moduli con più di 50 errori
2. **Priorità Media**: Moduli con 10-50 errori  
3. **Manutenzione**: Moduli con meno di 10 errori

## Workflow Raccomandato
1. Correzione errori critici (type safety)
2. Implementazione type hints
3. Documentazione PHPDoc
4. Refactoring architetturale
5. Test automatici

## Automazione
- Script di analisi: \`bashscripts/phpstan/analyze_modules_quality.sh\`
- Configurazione: \`laravel/phpstan.neon\` (non modificare)
- Documentazione: [PHPStan Guide](./../../bashscripts/prompts/phpstan.txt)
EOF
    
    log_success "Report globale generato: $global_report"
}

# Funzione principale
main() {
    echo "==================================="
    echo "PHPStan Code Quality Analyzer"
    echo "==================================="
    
    check_prerequisites
    
    log_info "Inizio analisi di tutti i moduli..."
    
    local modules=($(get_modules))
    local total_modules=${#modules[@]}
    local current=0
    
    log_info "Trovati $total_modules moduli da analizzare"
    
    # Analizza ogni modulo
    for module_dir in "${modules[@]}"; do
        current=$((current + 1))
        log_info "Progresso: $current/$total_modules"
        analyze_module "$module_dir"
    done
    
    # Genera report globale
    generate_global_report
    
    log_success "Analisi completata!"
    log_info "Risultati salvati in: $DOCS_PHPSTAN_DIR"
    log_info "Report globale: global_analysis_${TIMESTAMP}.md"
}

# Esegui script
main "$@" 