#!/bin/bash

# =========================================================================
# 🐄 Simple but Effective Conflict Resolver - Current Change Only
# =========================================================================
# Script semplice ma efficace per risolvere conflitti Git con current change
# Posizione: bashscripts/git/conflict_resolution/
# Versione: Semplice e Testata
# =========================================================================

set -euo pipefail

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m'

# Configurazione
BASE_DIR="/var/www/_bases/base_<nome progetto>_fila5_mono"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
LOG_FILE="${BASE_DIR}/bashscripts/logs/fix_head_conflicts_${TIMESTAMP}.log"

# Crea directory log se non esiste
mkdir -p "${BASE_DIR}/bashscripts/logs"

echo -e "${BLUE}🐄 Simple Conflict Resolver - Current Change Only${NC}"
echo -e "${YELLOW}📝 Log: ${LOG_FILE}${NC}"
echo -e "${YELLOW}📅 $(date)${NC}\n"

# Funzione per log
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

# Funzione AWK per risolvere conflitti
resolve_conflicts() {
    awk '
    BEGIN { in_conflict = 0; in_current = 0 }
    /^<<<<<<< / { in_conflict = 1; next }
    /^=======/ { if (in_conflict) in_current = 1; next }
    /^>>>>>>> / { in_conflict = 0; in_current = 0; next }
    { if (!in_conflict || in_current) print }
    '
}

# Conta conflitti iniziali
echo -e "${BLUE}🔍 Ricerca file con conflitti...${NC}"
conflicted_files=($(find "$BASE_DIR" -type f \
    ! -path "*/.git/*" \
    ! -path "*/node_modules/*" \
    ! -path "*/vendor/*" \
    ! -path "*/storage/logs/*" \
    -exec grep -l "^<<<<<<< " {} + 2>/dev/null || true))

total_files=${#conflicted_files[@]}

if [[ $total_files -eq 0 ]]; then
    echo -e "${GREEN}🎉 Nessun file con conflitti trovato!${NC}"
    log "INFO: Nessun file con conflitti trovato"
    exit 0
fi

echo -e "${YELLOW}📋 Trovati $total_files file con conflitti${NC}"
log "Trovati $total_files file con conflitti"

# Contatori
resolved=0
failed=0

# Processa ogni file
for i in "${!conflicted_files[@]}"; do
    file="${conflicted_files[$i]}"
    file_num=$((i + 1))

    echo -e "${YELLOW}[$file_num/$total_files] 🔧 Elaborazione: $file${NC}"

    # Salta file binari
    if file --brief --mime "$file" 2>/dev/null | grep -qi "binary"; then
        echo -e "${YELLOW}⏭️  File binario saltato${NC}"
        continue
    fi

    # Conta conflitti nel file
    conflicts=$(grep -c "^<<<<<<< " "$file" 2>/dev/null || echo "0")

    if [[ $conflicts -eq 0 ]]; then
        echo -e "${YELLOW}ℹ️  Nessun conflitto in questo file${NC}"
        continue
    fi

    # Crea backup
    cp "$file" "${file}.backup.${TIMESTAMP}"

    # Risolvi conflitti
    if resolve_conflicts < "$file" > "${file}.tmp"; then
        # Verifica che non ci siano più conflitti
        if ! grep -q "^<<<<<<< " "${file}.tmp"; then
            mv "${file}.tmp" "$file"
            echo -e "${GREEN}✅ Risolti $conflicts conflitti${NC}"
            log "SUCCESSO: Risolti $conflicts conflitti in: $file"
            ((resolved++))
        else
            echo -e "${RED}❌ Risoluzione incompleta${NC}"
            log "ERRORE: Risoluzione incompleta: $file"
            rm -f "${file}.tmp"
            ((failed++))
        fi
    else
        echo -e "${RED}❌ Errore nella risoluzione${NC}"
        log "ERRORE: Errore nella risoluzione: $file"
        rm -f "${file}.tmp"
        ((failed++))
    fi
done

# Verifica finale
echo -e "\n${BLUE}🔍 Verifica finale...${NC}"
remaining=$(find "$BASE_DIR" -type f \
    ! -path "*/.git/*" \
    ! -path "*/node_modules/*" \
    ! -path "*/vendor/*" \
    ! -path "*/storage/logs/*" \
    -exec grep -l "^<<<<<<< " {} + 2>/dev/null | wc -l)

# Riepilogo
echo -e "\n${PURPLE}============== 📊 RIEPILOGO ==============${NC}"
echo -e "${BLUE}📁 File totali processati: $total_files${NC}"
echo -e "${GREEN}✅ File risolti: $resolved${NC}"
echo -e "${RED}❌ File con errori: $failed${NC}"
echo -e "${YELLOW}📋 Conflitti rimanenti: $remaining${NC}"

log "RIEPILOGO: File processati: $total_files, Risolti: $resolved, Errori: $failed, Rimanenti: $remaining"

if [[ $remaining -eq 0 ]]; then
    echo -e "${GREEN}🎉 TUTTI I CONFLITTI SONO STATI RISOLTI!${NC}"
    log "SUCCESSO: Tutti i conflitti risolti"
else
    echo -e "${YELLOW}⚠️  $remaining file hanno ancora conflitti${NC}"
    log "ATTENZIONE: $remaining file hanno ancora conflitti"
fi

echo -e "${YELLOW}📝 Log completo: ${LOG_FILE}${NC}"