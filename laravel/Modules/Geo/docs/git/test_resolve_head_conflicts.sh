#!/bin/bash

# =============================================================================
# Script di Test per resolve_head_conflicts.sh
# =============================================================================
# 
# DESCRIZIONE:
# Crea file di test con conflitti Git e verifica che lo script li risolva correttamente
#
# USAGE:
#   ./test_resolve_head_conflicts.sh
#
# =============================================================================

set -euo pipefail

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Directory di test
TEST_DIR="/tmp/git_conflict_test_$$"
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

    # File JSON con conflitto
    cat > test.json << 'EOF'
{
    "name": "test",
    "version": "1.0.0"
}
EOF

    # File Bash con conflitto
    cat > test.sh << 'EOF'
#!/bin/bash

# Test script
echo "Original message"
EOF

    chmod +x test.sh
    
    log "SUCCESS" "File di test creati"
}

# Funzione per verificare conflitti
check_conflicts() {
    local file="$1"
        log "WARNING" "Conflitti ancora presenti in: $file"
        return 1
    else
        log "SUCCESS" "Conflitti risolti in: $file"
        return 0
    fi
}

# Funzione per verificare contenuto
check_content() {
    local file="$1"
    local expected="$2"
    
    if grep -q "$expected" "$file"; then
        log "SUCCESS" "Contenuto corretto in: $file"
        return 0
    else
        log "ERROR" "Contenuto non corretto in: $file"
        log "ERROR" "Atteso: $expected"
        return 1
    fi
}

# Funzione per eseguire test
run_tests() {
    log "INFO" "Eseguendo test..."
    
    local test_count=0
    local passed_count=0
    
    # Test 1: Dry run
    log "INFO" "Test 1: Dry run"
    ((test_count++))
    if "$SCRIPT_PATH" --dry-run >/dev/null 2>&1; then
        log "SUCCESS" "Dry run completato"
        ((passed_count++))
    else
        log "ERROR" "Dry run fallito"
    fi
    
    # Test 2: Risoluzione con backup
    log "INFO" "Test 2: Risoluzione con backup"
    ((test_count++))
    if "$SCRIPT_PATH" --backup --verbose >/dev/null 2>&1; then
        log "SUCCESS" "Risoluzione con backup completata"
        ((passed_count++))
    else
        log "ERROR" "Risoluzione con backup fallita"
    fi
    
    # Test 3: Verifica conflitti risolti
    log "INFO" "Test 3: Verifica conflitti risolti"
    ((test_count++))
    local conflicts_resolved=true
    for file in test.php test.md test.json test.sh; do
        if ! check_conflicts "$file"; then
            conflicts_resolved=false
        fi
    done
    
    if [ "$conflicts_resolved" = true ]; then
        log "SUCCESS" "Tutti i conflitti risolti"
        ((passed_count++))
    else
        log "ERROR" "Alcuni conflitti non risolti"
    fi
    
    # Test 4: Verifica contenuto corretto
    log "INFO" "Test 4: Verifica contenuto corretto"
    ((test_count++))
    local content_correct=true
    
    # Verifica PHP - dovrebbe contenere la versione "current change"
    if ! check_content "test.php" "filter(function"; then
        content_correct=false
    fi
    
    # Verifica Markdown - dovrebbe contenere la versione "current change"
    if ! check_content "test.md" "improved content"; then
        content_correct=false
    fi
    
    # Verifica JSON - dovrebbe contenere la versione "current change"
    if ! check_content "test.json" "2.0.0"; then
        content_correct=false
    fi
    
    # Verifica Bash - dovrebbe contenere la versione "current change"
    if ! check_content "test.sh" "Updated message"; then
        content_correct=false
    fi
    
    if [ "$content_correct" = true ]; then
        log "SUCCESS" "Contenuto corretto in tutti i file"
        ((passed_count++))
    else
        log "ERROR" "Contenuto non corretto in alcuni file"
    fi
    
    # Test 5: Verifica backup creati
    log "INFO" "Test 5: Verifica backup creati"
    ((test_count++))
    local backup_count=$(find . -name "*.backup.*" | wc -l)
    if [ "$backup_count" -gt 0 ]; then
        log "SUCCESS" "Backup creati: $backup_count"
        ((passed_count++))
    else
        log "ERROR" "Nessun backup creato"
    fi
    
    # Risultati finali
    echo
    log "INFO" "Risultati test:"
    log "INFO" "  Test eseguiti: $test_count"
    log "INFO" "  Test superati: $passed_count"
    log "INFO" "  Test falliti: $((test_count - passed_count))"
    
    if [ $passed_count -eq $test_count ]; then
        log "SUCCESS" "Tutti i test superati!"
        return 0
    else
        log "ERROR" "Alcuni test falliti"
        return 1
    fi
}

# Funzione per cleanup
cleanup() {
    log "INFO" "Pulizia file di test..."
    rm -rf "$TEST_DIR"
    log "SUCCESS" "Cleanup completato"
}

# Funzione per mostrare file di test
show_test_files() {
    log "INFO" "File di test creati:"
    echo
    for file in test.php test.md test.json test.sh; do
        if [ -f "$file" ]; then
            echo "=== $file ==="
            cat "$file"
            echo
        fi
    done
}

# Main execution
main() {
