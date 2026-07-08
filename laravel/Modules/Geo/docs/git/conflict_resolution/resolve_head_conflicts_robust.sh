#!/bin/bash

# =========================================================================
# 🐄 Robust HEAD Conflict Resolver - Never Fails Edition
# =========================================================================
# Script robusto che non fallisce mai e risolve tutti i conflitti possibili
# Posizione: bashscripts/git/conflict_resolution/
# Versione: Robust - Never Fails
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
LOG_FILE="${BASE_DIR}/bashscripts/logs/resolve_head_conflicts_robust_${TIMESTAMP}.log"

# Crea directory log se non esiste
mkdir -p "${BASE_DIR}/bashscripts/logs"

echo -e "${BLUE}🐄 Robust HEAD Conflict Resolver - Never Fails Edition${NC}"
echo -e "${YELLOW}📝 Log: ${LOG_FILE}${NC}"
echo -e "${YELLOW}📅 $(date)${NC}\n"

# Funzione per log
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

# Funzione per processare singolo file
resolve_file_conflicts() {
    local file="$1"
    local temp_file="${file}.tmp.$$"

    # Usa sed per rimuovere blocchi di conflitto mantenendo solo current change
    sed '/^<<<<<<< /,/^=======$/d; /^>>>>>>> /d' "$file" > "$temp_file"

    # Se il file temp è valido, sostituisci
    if [[ -s "$temp_file" ]]; then
        mv "$temp_file" "$file"
        return 0
    else
        rm -f "$temp_file"
        return 1
    fi
}

# Conta conflitti iniziali
echo -e "${BLUE}🔍 Ricerca file con conflitti...${NC}"

# Trova file con conflitti usando una ricerca più sicura
mapfile -t conflicted_files < <(
    find "$BASE_DIR" -type f -name "*.php" -o -name "*.md" -o -name "*.js" -o -name "*.ts" -o -name "*.json" -o -name "*.yml" -o -name "*.yaml" -o -name "*.sh" -o -name "*.txt" |
    xargs -r grep -l "^<<<<<<< " 2>/dev/null || true
)

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
skipped=0

# Processa ogni file
for i in "${!conflicted_files[@]}"; do
    file="${conflicted_files[$i]}"
    file_num=$((i + 1))

    echo -e "${YELLOW}[$file_num/$total_files] 🔧 $file${NC}"

    # Verifica se il file esiste e è leggibile
    if [[ ! -f "$file" ]] || [[ ! -r "$file" ]]; then
        echo -e "${RED}❌ File non accessibile${NC}"
        ((skipped++))
        continue
    fi

    # Salta file binari
    if file --brief --mime "$file" 2>/dev/null | grep -qi "binary"; then
        echo -e "${YELLOW}⏭️  File binario saltato${NC}"
        ((skipped++))
        continue
    fi

    # Conta conflitti nel file
    conflicts=$(grep -c "^<<<<<<< " "$file" 2>/dev/null || echo "0")

    if [[ $conflicts -eq 0 ]]; then
        echo -e "${YELLOW}ℹ️  Nessun conflitto${NC}"
        ((skipped++))
        continue
    fi

    # Crea backup
    cp "$file" "${file}.backup.${TIMESTAMP}" 2>/dev/null || true

    # Risolvi conflitti usando sed (più robusto)
    if sed -i.tmp "/^<<<<<<< /,/^=======$/d; /^>>>>>>> /d" "$file" 2>/dev/null; then
        # Verifica che il file sia ancora valido
        if [[ -s "$file" ]]; then
            # Verifica che non ci siano più conflitti
            remaining_conflicts=$(grep -c "^<<<<<<< " "$file" 2>/dev/null || echo "0")
            if [[ $remaining_conflicts -eq 0 ]]; then
                echo -e "${GREEN}✅ Risolti $conflicts conflitti${NC}"
                log "SUCCESSO: Risolti $conflicts conflitti in: $file"
                ((resolved++))
            else
                echo -e "${YELLOW}⚠️  Risolti parzialmente ($remaining_conflicts rimanenti)${NC}"
                log "PARZIALE: Risolti alcuni conflitti in: $file"
                ((resolved++))
            fi
        else
            echo -e "${RED}❌ File vuoto dopo risoluzione${NC}"
            # Ripristina backup
            if [[ -f "${file}.backup.${TIMESTAMP}" ]]; then
                cp "${file}.backup.${TIMESTAMP}" "$file"
            fi
            ((failed++))
        fi
    else
        echo -e "${RED}❌ Errore sed${NC}"
        ((failed++))
    fi

    # Rimuovi file temporaneo sed se esiste
    rm -f "${file}.tmp" 2>/dev/null || true
done

# Verifica finale
echo -e "\n${BLUE}🔍 Verifica finale...${NC}"
remaining=$(find "$BASE_DIR" -type f \( -name "*.php" -o -name "*.md" -o -name "*.js" -o -name "*.ts" -o -name "*.json" -o -name "*.yml" -o -name "*.yaml" -o -name "*.sh" -o -name "*.txt" \) -exec grep -l "^<<<<<<< " {} + 2>/dev/null | wc -l)

# Riepilogo
echo -e "\n${PURPLE}============== 📊 RIEPILOGO ==============${NC}"
echo -e "${BLUE}📁 File totali processati: $total_files${NC}"
echo -e "${GREEN}✅ File risolti: $resolved${NC}"
echo -e "${YELLOW}⏭️  File saltati: $skipped${NC}"
echo -e "${RED}❌ File con errori: $failed${NC}"
echo -e "${YELLOW}📋 Conflitti rimanenti: $remaining${NC}"

log "RIEPILOGO: File processati: $total_files, Risolti: $resolved, Saltati: $skipped, Errori: $failed, Rimanenti: $remaining"

if [[ $remaining -eq 0 ]]; then
    echo -e "${GREEN}🎉 TUTTI I CONFLITTI SONO STATI RISOLTI!${NC}"
    log "SUCCESSO: Tutti i conflitti risolti"
    exit 0
elif [[ $resolved -gt 0 ]]; then
    echo -e "${GREEN}🎉 $resolved file risolti, $remaining rimanenti${NC}"
    log "SUCCESSO PARZIALE: $resolved file risolti, $remaining rimanenti"
    exit 0
else
    echo -e "${YELLOW}⚠️  Nessun file risolto, $remaining conflitti rimanenti${NC}"
    log "ATTENZIONE: Nessun file risolto"
    exit 1
fi

echo -e "${YELLOW}📝 Log completo: ${LOG_FILE}${NC}"