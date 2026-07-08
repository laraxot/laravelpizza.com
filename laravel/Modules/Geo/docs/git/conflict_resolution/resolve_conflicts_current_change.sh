#!/bin/bash

# =========================================================================
# 🐄 SuperMucca Ultimate Conflict Resolver - Current Change Edition V5.0
# =========================================================================
# Script per risolvere automaticamente i conflitti Git scegliendo sempre la "current change"
# Posizione: bashscripts/git/conflict_resolution/
# Autore: AI Assistant con poteri della supermucca
# Versione: 5.0 - Edizione finale ottimizzata
# Data: $(date +%Y-%m-%d)
# =========================================================================

set -euo pipefail
IFS=$'\n\t'

# Colori per output
readonly RED='\033[0;31m'
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[0;33m'
readonly BLUE='\033[0;34m'
readonly PURPLE='\033[0;35m'
readonly CYAN='\033[0;36m'
readonly BOLD='\033[1m'
readonly NC='\033[0m' # No Color

# Directory di base
readonly BASE_DIR="/var/www/_bases/base_<nome progetto>_fila5_mono"
readonly SCRIPT_DIR="${BASE_DIR}/bashscripts"

# Configurazione
DRY_RUN=${DRY_RUN:-false}
VERBOSE=${VERBOSE:-false}
readonly TIMESTAMP=$(date +%Y%m%d_%H%M%S)
readonly BACKUP_DIR="${SCRIPT_DIR}/backups/conflicts_current_change_${TIMESTAMP}"
readonly LOG_DIR="${SCRIPT_DIR}/logs"
readonly LOG_FILE="${LOG_DIR}/resolve_conflicts_current_change_${TIMESTAMP}.log"

# Crea directory necessarie
mkdir -p "$LOG_DIR" "$BACKUP_DIR"

# Contatori globali
declare -i TOTAL_FILES=0
declare -i RESOLVED_FILES=0
declare -i FAILED_FILES=0
declare -i SKIPPED_FILES=0
declare -i TOTAL_CONFLICTS=0

# Banner
echo -e "${BOLD}${BLUE}=======================================================================${NC}"
echo -e "${BOLD}${BLUE}🐄 SuperMucca Ultimate Conflict Resolver - Current Change Edition V5.0${NC}"
echo -e "${BOLD}${BLUE}=======================================================================${NC}"
echo -e "${CYAN}Risolve TUTTI i conflitti scegliendo sempre la 'current change'${NC}"
echo -e "${CYAN}$(date)${NC}"
echo -e "${YELLOW}📁 Directory: ${BASE_DIR}${NC}"
echo -e "${YELLOW}📝 Log: ${LOG_FILE}${NC}"
echo -e "${YELLOW}💾 Backup: ${BACKUP_DIR}${NC}"
echo -e "${YELLOW}🧪 Dry-run: ${DRY_RUN}${NC}"
echo -e "${YELLOW}🔍 Verbose: ${VERBOSE}${NC}\n"

# Funzione per log con timestamp
log() {
    local message="$*"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[$timestamp] $message" >> "$LOG_FILE"
}

# Inizializza log
{
    echo "======================================================================="
    echo "🐄 SuperMucca Ultimate Conflict Resolver - Current Change Edition V5.0"
    echo "======================================================================="
    echo "Data: $(date)"
    echo "Dry-run: $DRY_RUN"
    echo "Verbose: $VERBOSE"
    echo "Directory: $BASE_DIR"
    echo ""
} > "$LOG_FILE"

# Funzione AWK per risolvere conflitti mantenendo solo la current change
resolve_with_current_change() {
    awk '
    BEGIN {
        state = 0
        # state 0: normale
        # state 1: dentro conflitto HEAD (da scartare)
        # state 2: dentro conflitto CURRENT (da mantenere)
    }

    # Inizio conflitto (<<<<<git marker> o altro)
    /^<<<<<<< / {
        state = 1
        next
    }

    # Separatore (=======)
    /^=======/ {
        if (state == 1) {
            state = 2
        }
        next
    }

    # Fine conflitto (>>>>>>> commit_hash)
    /^>>>>>>> / {
        if (state > 0) {
            state = 0
        }
        next
    }

    # Stampa la riga se:
    # - Non siamo in conflitto (state 0), OPPURE
    # - Siamo nella sezione current change (state 2)
    {
        if (state == 0 || state == 2) {
            print $0
        }
    }
    '
}

# Funzione per verificare se un file è binario
is_binary_file() {
    local file="$1"

    # Usa il comando file per verificare se è binario
    if file --brief --mime "$file" 2>/dev/null | grep -qi "binary"; then
        return 0  # È binario
    fi

    # Controllo aggiuntivo: se contiene caratteri null
    if grep -q $'\0' "$file" 2>/dev/null; then
        return 0  # È binario
    fi

    return 1  # Non è binario
}

# Funzione per processare un singolo file
process_file() {
    local file="$1"
    local temp_file="${file}.tmp.${TIMESTAMP}"
    local backup_file="${BACKUP_DIR}/$(basename "$file").backup"
    local conflict_count=0

    log "Elaborazione file: $file"

    # Verifica se il file esiste e ha i permessi giusti
    if [[ ! -f "$file" ]]; then
        echo -e "${RED}❌ File non trovato: $file${NC}"
        log "ERRORE: File non trovato: $file"
        return 1
    fi

    if [[ ! -r "$file" ]]; then
        echo -e "${RED}❌ File non leggibile: $file${NC}"
        log "ERRORE: File non leggibile: $file"
        return 1
    fi

    # Salta file binari
    if is_binary_file "$file"; then
        echo -e "${YELLOW}⏭️  File binario saltato: $file${NC}"
        log "SKIP: File binario: $file"
        return 2
    fi

    # Verifica se ci sono conflitti
    if ! grep -q "^<<<<<<< " "$file"; then
        [[ "$VERBOSE" == "true" ]] && echo -e "${YELLOW}ℹ️  Nessun conflitto: $file${NC}"
        log "NO-CONFLICT: $file"
        return 3
    fi

    # Conta i conflitti
    conflict_count=$(grep -c "^<<<<<<< " "$file")

    if [[ "$DRY_RUN" == "true" ]]; then
        # Modalità dry-run: solo simulazione
        local before_lines after_lines
        before_lines=$(wc -l < "$file" | tr -d ' ')

        if resolve_with_current_change < "$file" > "$temp_file"; then
            after_lines=$(wc -l < "$temp_file" | tr -d ' ')
            rm -f "$temp_file"
            echo -e "${CYAN}🔍 DRY-RUN: $file ($conflict_count conflitti, righe: ${before_lines}→${after_lines})${NC}"
            log "DRY-RUN: $file - $conflict_count conflitti, righe: ${before_lines}→${after_lines}"
            return 0
        else
            rm -f "$temp_file"
            echo -e "${RED}❌ DRY-RUN errore: $file${NC}"
            log "DRY-RUN ERRORE: $file"
            return 1
        fi
    fi

    # Verifica permessi di scrittura
    if [[ ! -w "$file" ]]; then
        echo -e "${RED}❌ File non scrivibile: $file${NC}"
        log "ERRORE: File non scrivibile: $file"
        return 1
    fi

    # Crea backup
    if ! cp "$file" "$backup_file"; then
        echo -e "${RED}❌ Impossibile creare backup per: $file${NC}"
        log "ERRORE: Impossibile creare backup per: $file"
        return 1
    fi

    [[ "$VERBOSE" == "true" ]] && echo -e "${BLUE}💾 Backup creato: $backup_file${NC}"
    log "Backup creato: $backup_file"

    # Risolvi conflitti
    if resolve_with_current_change < "$file" > "$temp_file"; then
        # Verifica che non ci siano più conflitti nel file risultante
        if grep -q "^<<<<<<< " "$temp_file"; then
            echo -e "${RED}❌ Risoluzione incompleta per: $file${NC}"
            log "ERRORE: Risoluzione incompleta per: $file"
            rm -f "$temp_file"
            return 1
        fi

        # Sostituisci il file originale
        if mv "$temp_file" "$file"; then
            echo -e "${GREEN}✅ Risolti $conflict_count conflitti in: $file${NC}"
            log "SUCCESSO: Risolti $conflict_count conflitti in: $file"
            TOTAL_CONFLICTS=$((TOTAL_CONFLICTS + conflict_count))
            return 0
        else
            echo -e "${RED}❌ Errore durante la sostituzione di: $file${NC}"
            log "ERRORE: Impossibile sostituire: $file"
            rm -f "$temp_file"
            return 1
        fi
    else
        echo -e "${RED}❌ Errore nella risoluzione di: $file${NC}"
        log "ERRORE: Errore nella risoluzione di: $file"
        rm -f "$temp_file"
        return 1
    fi
}

# Funzione per trovare tutti i file con conflitti
find_conflicted_files() {
    local search_dir="$1"
    local -a files=()

    echo -e "${BLUE}🔍 Ricerca file con conflitti in: $search_dir${NC}"
    log "Inizio ricerca conflitti in: $search_dir"

    # Usa find per trovare tutti i file con conflitti, escludendo .git
    # Usa null delimiter per gestire nomi di file con spazi
    while IFS= read -r -d '' file; do
        files+=("$file")
    done < <(find "$search_dir" -type f \
        ! -path "*/.git/*" \
        ! -path "*/node_modules/*" \
        ! -path "*/vendor/*" \
        ! -path "*/storage/logs/*" \
        -exec grep -l "^<<<<<<< " {} + 2>/dev/null | tr '\n' '\0')

    printf '%s\0' "${files[@]}"
}

# Funzione per verificare conflitti rimanenti
verify_no_conflicts() {
    local search_dir="$1"
    local remaining_count

    echo -e "${BLUE}🔍 Verifica finale: controllo conflitti rimanenti...${NC}"
    log "Verifica finale conflitti rimanenti"

    remaining_count=$(find "$search_dir" -type f \
        ! -path "*/.git/*" \
        ! -path "*/node_modules/*" \
        ! -path "*/vendor/*" \
        ! -path "*/storage/logs/*" \
        -exec grep -l "^<<<<<<< " {} + 2>/dev/null | wc -l)

    if [[ "$remaining_count" -eq 0 ]]; then
        echo -e "${GREEN}✅ Verifica completata: nessun conflitto rimanente!${NC}"
        log "SUCCESSO: Verifica completata, nessun conflitto rimanente"
        return 0
    else
        echo -e "${RED}❌ ATTENZIONE: Trovati $remaining_count file con conflitti rimanenti!${NC}"
        log "ATTENZIONE: Trovati $remaining_count file con conflitti rimanenti"

        # Mostra i file rimanenti se in modalità verbose
        if [[ "$VERBOSE" == "true" ]]; then
            echo -e "${YELLOW}File con conflitti rimanenti:${NC}"
            find "$search_dir" -type f \
                ! -path "*/.git/*" \
                ! -path "*/node_modules/*" \
                ! -path "*/vendor/*" \
                ! -path "*/storage/logs/*" \
                -exec grep -l "^<<<<<<< " {} + 2>/dev/null | head -10
        fi
        return 1
    fi
}

# Funzione principale
main() {
    echo -e "${BOLD}${PURPLE}🚀 Avvio risoluzione conflitti Git...${NC}"
    log "START: Risoluzione conflitti (dry=$DRY_RUN, verbose=$VERBOSE)"

    # Trova tutti i file con conflitti
    local -a conflicted_files=()
    while IFS= read -r -d '' file; do
        conflicted_files+=("$file")
    done < <(find_conflicted_files "$BASE_DIR")

    TOTAL_FILES=${#conflicted_files[@]}

    if [[ "$TOTAL_FILES" -eq 0 ]]; then
        echo -e "${GREEN}🎉 Nessun file con conflitti trovato!${NC}"
        log "INFO: Nessun file con conflitti trovato"
        return 0
    fi

    echo -e "${CYAN}📋 Trovati $TOTAL_FILES file con conflitti${NC}"
    log "Trovati $TOTAL_FILES file con conflitti"

    # Processa ogni file
    local file_count=0
    for file in "${conflicted_files[@]}"; do
        ((file_count++))
        echo -e "${YELLOW}[$file_count/$TOTAL_FILES] 🔧 Elaborazione: $file${NC}"

        case "$(process_file "$file"; echo $?)" in
            0)
                ((RESOLVED_FILES++))
                ;;
            1)
                ((FAILED_FILES++))
                ;;
            2|3)
                ((SKIPPED_FILES++))
                ;;
        esac
    done

    # Verifica finale solo se non è dry-run
    local verify_result=0
    if [[ "$DRY_RUN" != "true" ]]; then
        verify_no_conflicts "$BASE_DIR"
        verify_result=$?
    fi

    # Riepilogo finale
    echo -e "\n${BOLD}${BLUE}============== 📊 RIEPILOGO FINALE ==============${NC}"
    echo -e "${BLUE}📁 File totali processati: $TOTAL_FILES${NC}"
    echo -e "${GREEN}✅ File risolti con successo: $RESOLVED_FILES${NC}"
    echo -e "${YELLOW}⚠️  File saltati/senza conflitti: $SKIPPED_FILES${NC}"
    echo -e "${RED}❌ File con errori: $FAILED_FILES${NC}"
    echo -e "${PURPLE}🔧 Conflitti totali risolti: $TOTAL_CONFLICTS${NC}"

    # Salva riepilogo nel log
    {
        echo ""
        echo "============== RIEPILOGO FINALE =============="
        echo "File totali processati: $TOTAL_FILES"
        echo "File risolti con successo: $RESOLVED_FILES"
        echo "File saltati/senza conflitti: $SKIPPED_FILES"
        echo "File con errori: $FAILED_FILES"
        echo "Conflitti totali risolti: $TOTAL_CONFLICTS"
        echo "Verifica finale: $([ $verify_result -eq 0 ] && echo "SUCCESSO" || echo "ATTENZIONE")"
        echo "Dry-run: $DRY_RUN"
    } >> "$LOG_FILE"

    if [[ "$DRY_RUN" == "true" ]]; then
        echo -e "${YELLOW}🧪 DRY-RUN completato: nessuna modifica ai file.${NC}"
        echo -e "${CYAN}💡 Per eseguire realmente: DRY_RUN=false $0${NC}"
    elif [[ $verify_result -eq 0 && $RESOLVED_FILES -gt 0 ]]; then
        echo -e "${GREEN}🎉 TUTTI I CONFLITTI SONO STATI RISOLTI CON SUCCESSO!${NC}"
        echo -e "${GREEN}💾 Backup salvati in: ${BACKUP_DIR}${NC}"
        echo -e "${GREEN}📝 Log completo in: ${LOG_FILE}${NC}"
    elif [[ $FAILED_FILES -gt 0 || $verify_result -ne 0 ]]; then
        echo -e "${RED}⚠️  ALCUNI CONFLITTI POTREBBERO NON ESSERE STATI RISOLTI${NC}"
        echo -e "${YELLOW}💡 Controlla il log per dettagli: ${LOG_FILE}${NC}"
        echo -e "${YELLOW}💡 Backup disponibili in: ${BACKUP_DIR}${NC}"
        return 1
    fi

    return 0
}

# Gestione degli errori
trap 'echo -e "${RED}Script interrotto!${NC}"; exit 1' INT TERM

# Parsing argomenti opzionali
while [[ $# -gt 0 ]]; do
    case $1 in
        --dry-run)
            export DRY_RUN=true
            shift
            ;;
        --verbose)
            export VERBOSE=true
            shift
            ;;
        --help)
            echo "Uso: $0 [--dry-run] [--verbose] [--help]"
            echo "  --dry-run   Simula senza modificare file"
            echo "  --verbose   Output dettagliato"
            echo "  --help      Mostra questo aiuto"
            exit 0
            ;;
        *)
            echo "Opzione sconosciuta: $1" >&2
            exit 1
            ;;
    esac
done

# Esegui la funzione principale
main "$@"