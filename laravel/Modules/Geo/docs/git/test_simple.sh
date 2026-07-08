#!/bin/bash

# =============================================================================
# Test Semplice per resolve_head_conflicts.sh
# =============================================================================

set -euo pipefail

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Directory di test
TEST_DIR="/tmp/git_conflict_simple_test_$$"
SCRIPT_PATH="/var/www/_bases/base_<nome progetto>_fila5_mono/bashscripts/git/resolve_head_conflicts.sh"

# Funzione per logging
log() {
    local level="$1"
    shift
    local message="$*"
    local timestamp=$(date '+%H:%M:%S')
    
    case "$level" in
        "ERROR") echo -e "${RED}❌ [$timestamp] $message${NC}" ;;
        "SUCCESS") echo -e "${GREEN}✅ [$timestamp] $message${NC}" ;;
        "WARNING") echo -e "${YELLOW}⚠️ [$timestamp] $message${NC}" ;;
        "INFO") echo -e "${BLUE}ℹ️ [$timestamp] $message${NC}" ;;
        *) echo -e "[$timestamp] $message" ;;
    esac
}

# Funzione per creare file di test
create_test_files() {
    log "INFO" "Creando file di test in: $TEST_DIR"
    
    mkdir -p "$TEST_DIR"
    cd "$TEST_DIR"
    
    # File PHP con conflitto
    cat > test.php << 'EOF'
<?php

class TestClass
{
    public function getData()
    {
        return $this->data;
    }
}
EOF

    # File Markdown con conflitto
    cat > test.md << 'EOF'
# Test Document

## Introduction
This is the original content.
EOF

    log "SUCCESS" "File di test creati"
}

# Funzione per testare la risoluzione manuale
test_manual_resolution() {
    log "INFO" "Testando risoluzione manuale con AWK..."
    
    # Test PHP
    echo "=== File PHP PRIMA ==="
    cat test.php
    echo
    
    echo "=== File PHP DOPO (dovrebbe mantenere current change) ==="
    awk '
    in_head { next }
    in_current || (!in_head && !in_current) { print }
    ' test.php
    echo
    
    # Test Markdown
    echo "=== File Markdown PRIMA ==="
    cat test.md
    echo
    
    echo "=== File Markdown DOPO (dovrebbe mantenere current change) ==="
    awk '
    in_head { next }
    in_current || (!in_head && !in_current) { print }
    ' test.md
    echo
}

# Funzione per testare lo script principale
test_main_script() {
    log "INFO" "Testando script principale..."
    
    # Copia i file di test nel progetto per testare lo script
    local test_files_dir="$TEST_DIR/test_files"
    mkdir -p "$test_files_dir"
    cp test.php test.md "$test_files_dir/"
    
    # Testa lo script nella directory di test
    cd "$test_files_dir"
    
    # Esegue dry run con directory personalizzata
    log "INFO" "Eseguendo dry run..."
    if "$SCRIPT_PATH" --dry-run --verbose --directory "$test_files_dir"; then
        log "SUCCESS" "Dry run completato"
    else
        log "ERROR" "Dry run fallito"
        return 1
    fi
    
    # Esegue risoluzione reale con directory personalizzata
    log "INFO" "Eseguendo risoluzione reale..."
    if "$SCRIPT_PATH" --backup --verbose --directory "$test_files_dir"; then
        log "SUCCESS" "Risoluzione completata"
    else
        log "ERROR" "Risoluzione fallita"
        return 1
    fi
    
    # Verifica risultati
    log "INFO" "Verificando risultati..."
    
        log "ERROR" "Conflitti ancora presenti"
        return 1
    else
        log "SUCCESS" "Tutti i conflitti risolti"
    fi
    
    # Verifica contenuto corretto
    if grep -q "filter(function" test.php && grep -q "improved content" test.md; then
        log "SUCCESS" "Contenuto corretto (current change mantenuto)"
    else
        log "ERROR" "Contenuto non corretto"
        return 1
    fi
    
    # Mostra file finali
    echo "=== File PHP FINALE ==="
    cat test.php
    echo
    echo "=== File Markdown FINALE ==="
    cat test.md
    echo
}

# Funzione per cleanup
cleanup() {
    log "INFO" "Pulizia file di test..."
    rm -rf "$TEST_DIR"
    log "SUCCESS" "Cleanup completato"
}

# Main execution
main() {
