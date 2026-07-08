#!/bin/bash

# =========================================================================
# 🔧 Bad Resolution Cleanup Script V1.0
# =========================================================================
# Script per pulire file con risoluzione conflitti malriuscita
# Rimuove marker >>>> commit_hash e linee duplicate
# Posizione: bashscripts/git/conflict_resolution/
# Autore: AI Assistant
# Versione: 1.0
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
readonly BACKUP_DIR="${SCRIPT_DIR}/backups/bad_resolution_cleanup_${TIMESTAMP}"
readonly LOG_DIR="${SCRIPT_DIR}/logs"
readonly LOG_FILE="${LOG_DIR}/clean_bad_resolution_${TIMESTAMP}.log"

# Crea directory necessarie
mkdir -p "$LOG_DIR" "$BACKUP_DIR"

# Contatori globali
declare -i TOTAL_FILES=0
declare -i CLEANED_FILES=0
declare -i FAILED_FILES=0
declare -i SKIPPED_FILES=0
declare -i TOTAL_MARKERS_REMOVED=0
declare -i TOTAL_DUPLICATES_REMOVED=0

# Banner
echo -e "${BOLD}${BLUE}=======================================================================${NC}"
echo -e "${BOLD}${BLUE}🔧 Bad Resolution Cleanup Script V1.0${NC}"
echo -e "${BOLD}${BLUE}=======================================================================${NC}"
echo -e "${CYAN}Pulisce file con risoluzione conflitti malriuscita${NC}"
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
    echo "🔧 Bad Resolution Cleanup Script V1.0"
    echo "======================================================================="
    echo "Data: $(date)"
    echo "Dry-run: $DRY_RUN"
    echo "Verbose: $VERBOSE"
    echo "Directory: $BASE_DIR"
    echo ""
} > "$LOG_FILE"

# Funzione per verificare se un file è binario
is_binary_file() {
    local file="$1"

    if file --brief --mime "$file" 2>/dev/null | grep -qi "binary"; then
        return 0  # È binario
    fi

    if grep -q $'\0' "$file" 2>/dev/null; then
        return 0  # È binario
    fi

    return 1  # Non è binario
}

# Funzione AWK per pulire file con problemi di risoluzione
clean_bad_resolution() {
    awk '
    BEGIN {
        prev_line = ""
        skip_duplicate = 0
    }

    # Salta marker di commit hash (>>>>>>> commit_hash)
    /^>>>>>>> [a-f0-9]/ {
        next
    }

    # Salta marker semplici >>>>>
    /^>>>>>$/ {
        next
    }

    # Rileva e gestisce linee duplicate consecutive
    {
        # Se la linea corrente è uguale alla precedente, segna per saltare
        if ($0 == prev_line && $0 != "" && prev_line != "") {
            # Ma non saltare se sono solo commenti o linee vuote
            if ($0 !~ /^[[:space:]]*\/\*/ && $0 !~ /^[[:space:]]*\/\// && $0 !~ /^[[:space:]]*#/) {
                next
            }
        }

        # Stampa la linea e salvala come precedente
        print $0
        prev_line = $0
    }
    '
}

# Funzione per processare un singolo file
process_file() {
    local file="$1"
    local temp_file="${file}.tmp.${TIMESTAMP}"
    local backup_file="${BACKUP_DIR}/$(basename "$file").backup"
    local markers_count=0
    local duplicates_removed=0

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

    # Verifica se ci sono marker da rimuovere
    if ! grep -q ">>>>>" "$file"; then
        [[ "$VERBOSE" == "true" ]] && echo -e "${YELLOW}ℹ️  Nessun marker da rimuovere: $file${NC}"
        log "NO-MARKERS: $file"
        return 3
    fi

    # Conta i marker da rimuovere
    markers_count=$(grep -c ">>>>>" "$file" || true)

    if [[ "$DRY_RUN" == "true" ]]; then
        # Modalità dry-run: solo simulazione
        local before_lines after_lines
        before_lines=$(wc -l < "$file" | tr -d ' ')

        if clean_bad_resolution < "$file" > "$temp_file"; then
            after_lines=$(wc -l < "$temp_file" | tr -d ' ')
            duplicates_removed=$((before_lines - after_lines + markers_count))
            rm -f "$temp_file"
            echo -e "${CYAN}🔍 DRY-RUN: $file ($markers_count marker, ~$duplicates_removed duplicati, righe: ${before_lines}→${after_lines})${NC}"
            log "DRY-RUN: $file - $markers_count marker, $duplicates_removed duplicati, righe: ${before_lines}→${after_lines}"
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

    # Pulisci il file
    local before_lines after_lines
    before_lines=$(wc -l < "$file")

    if clean_bad_resolution < "$file" > "$temp_file"; then
        after_lines=$(wc -l < "$temp_file")
        duplicates_removed=$((before_lines - after_lines + markers_count))

        # Verifica che non ci siano più marker nel file risultante
        if grep -q ">>>>>" "$temp_file"; then
            echo -e "${RED}❌ Pulizia incompleta per: $file${NC}"
            log "ERRORE: Pulizia incompleta per: $file"
            rm -f "$temp_file"
            return 1
        fi

        # Sostituisci il file originale
        if mv "$temp_file" "$file"; then
            echo -e "${GREEN}✅ Pulito $file: $markers_count marker, $duplicates_removed duplicati rimossi${NC}"
            log "SUCCESSO: Pulito $file - $markers_count marker, $duplicates_removed duplicati"
            TOTAL_MARKERS_REMOVED=$((TOTAL_MARKERS_REMOVED + markers_count))
            TOTAL_DUPLICATES_REMOVED=$((TOTAL_DUPLICATES_REMOVED + duplicates_removed))
            return 0
        else
            echo -e "${RED}❌ Errore durante la sostituzione di: $file${NC}"
            log "ERRORE: Impossibile sostituire: $file"
            rm -f "$temp_file"
            return 1
        fi
    else
        echo -e "${RED}❌ Errore nella pulizia di: $file${NC}"
        log "ERRORE: Errore nella pulizia di: $file"
        rm -f "$temp_file"
        return 1
    fi
}

# Funzione per trovare tutti i file con marker >>>>>
find_files_with_markers() {
    local search_dir="$1"
    local -a files=()

    echo -e "${BLUE}🔍 Ricerca file con marker >>>>> in: $search_dir${NC}"
    log "Inizio ricerca marker in: $search_dir"

    # Usa find per trovare tutti i file con marker >>>>>, escludendo binari e directory inutili
    while IFS= read -r -d '' file; do
        files+=("$file")
    done < <(find "$search_dir" -type f \
        \( -name "*.php" -o -name "*.md" -o -name "*.sh" -o -name "*.json" -o -name "*.yml" -o -name "*.yaml" -o -name "*.blade.php" \) \
        ! -path "*/.git/*" \
        ! -path "*/node_modules/*" \
        ! -path "*/vendor/*" \
        -exec grep -l ">>>>>" {} + 2>/dev/null | tr '\n' '\0')

    printf '%s\0' "${files[@]}"
}

# Funzione per verificare marker rimanenti
verify_cleanup() {
    local search_dir="$1"
    local remaining_count

    echo -e "${BLUE}🔍 Verifica finale: controllo marker rimanenti...${NC}"
    log "Verifica finale marker rimanenti"

    remaining_count=$(find "$search_dir" -type f \
        \( -name "*.php" -o -name "*.md" -o -name "*.sh" -o -name "*.json" -o -name "*.yml" -o -name "*.yaml" -o -name "*.blade.php" \) \
        ! -path "*/.git/*" \
        ! -path "*/node_modules/*" \
        ! -path "*/vendor/*" \
        -exec grep -l ">>>>>" {} + 2>/dev/null | wc -l)

    if [[ "$remaining_count" -eq 0 ]]; then
        echo -e "${GREEN}✅ Verifica completata: nessun marker rimanente!${NC}"
        log "SUCCESSO: Verifica completata, nessun marker rimanente"
        return 0
    else
        echo -e "${RED}❌ ATTENZIONE: Trovati $remaining_count file con marker rimanenti!${NC}"
        log "ATTENZIONE: Trovati $remaining_count file con marker rimanenti"

        # Mostra i file rimanenti se in modalità verbose
        if [[ "$VERBOSE" == "true" ]]; then
            echo -e "${YELLOW}File con marker rimanenti:${NC}"
            find "$search_dir" -type f \
                \( -name "*.php" -o -name "*.md" -o -name "*.sh" -o -name "*.json" -o -name "*.yml" -o -name "*.yaml" -o -name "*.blade.php" \) \
                ! -path "*/.git/*" \
                ! -path "*/node_modules/*" \
                ! -path "*/vendor/*" \
                -exec grep -l ">>>>>" {} + 2>/dev/null | head -10
        fi
        return 1
    fi
}

# Funzione principale
main() {
    echo -e "${BOLD}${PURPLE}🚀 Avvio pulizia marker di risoluzione malriuscita...${NC}"
    log "START: Pulizia marker malriusciti (dry=$DRY_RUN, verbose=$VERBOSE)"

    # Trova tutti i file con marker >>>>>
    local -a files_with_markers=()
    while IFS= read -r -d '' file; do
        files_with_markers+=("$file")
    done < <(find_files_with_markers "$BASE_DIR")

    TOTAL_FILES=${#files_with_markers[@]}

    if [[ "$TOTAL_FILES" -eq 0 ]]; then
        echo -e "${GREEN}🎉 Nessun file con marker >>>>> trovato!${NC}"
        log "INFO: Nessun file con marker trovato"
        return 0
    fi

    echo -e "${CYAN}📋 Trovati $TOTAL_FILES file con marker >>>>>>${NC}"
    log "Trovati $TOTAL_FILES file con marker"

    # Processa ogni file
    local file_count=0
    for file in "${files_with_markers[@]}"; do
        ((file_count++))
        echo -e "${YELLOW}[$file_count/$TOTAL_FILES] 🔧 Elaborazione: $file${NC}"

        case "$(process_file "$file"; echo $?)" in
            0)
                ((CLEANED_FILES++))
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
        verify_cleanup "$BASE_DIR"
        verify_result=$?
    fi

    # Riepilogo finale
    echo -e "\n${BOLD}${BLUE}============== 📊 RIEPILOGO PULIZIA ==============${NC}"
    echo -e "${BLUE}📁 File totali processati: $TOTAL_FILES${NC}"
    echo -e "${GREEN}✅ File puliti con successo: $CLEANED_FILES${NC}"
    echo -e "${YELLOW}⚠️  File saltati: $SKIPPED_FILES${NC}"
    echo -e "${RED}❌ File con errori: $FAILED_FILES${NC}"
    echo -e "${PURPLE}🏷️  Marker >>>>> rimossi: $TOTAL_MARKERS_REMOVED${NC}"
    echo -e "${PURPLE}🔄 Linee duplicate rimosse: $TOTAL_DUPLICATES_REMOVED${NC}"

    # Salva riepilogo nel log
    {
        echo ""
        echo "============== RIEPILOGO PULIZIA =============="
        echo "File totali processati: $TOTAL_FILES"
        echo "File puliti con successo: $CLEANED_FILES"
        echo "File saltati: $SKIPPED_FILES"
        echo "File con errori: $FAILED_FILES"
        echo "Marker rimossi: $TOTAL_MARKERS_REMOVED"
        echo "Duplicati rimossi: $TOTAL_DUPLICATES_REMOVED"
        echo "Verifica finale: $([ $verify_result -eq 0 ] && echo "SUCCESSO" || echo "ATTENZIONE")"
        echo "Dry-run: $DRY_RUN"
    } >> "$LOG_FILE"

    if [[ "$DRY_RUN" == "true" ]]; then
        echo -e "${YELLOW}🧪 DRY-RUN completato: nessuna modifica ai file.${NC}"
        echo -e "${CYAN}💡 Per eseguire realmente: DRY_RUN=false $0${NC}"
    elif [[ $verify_result -eq 0 && $CLEANED_FILES -gt 0 ]]; then
        echo -e "${GREEN}🎉 TUTTI I MARKER SONO STATI RIMOSSI CON SUCCESSO!${NC}"
        echo -e "${GREEN}💾 Backup salvati in: ${BACKUP_DIR}${NC}"
        echo -e "${GREEN}📝 Log completo in: ${LOG_FILE}${NC}"
    elif [[ $FAILED_FILES -gt 0 || $verify_result -ne 0 ]]; then
        echo -e "${RED}⚠️  ALCUNI FILE POTREBBERO NON ESSERE STATI PULITI${NC}"
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