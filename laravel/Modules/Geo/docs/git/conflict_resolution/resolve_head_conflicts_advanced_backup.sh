#!/bin/bash
set -euo pipefail

# Script avanzato per risolvere automaticamente i conflitti Git scegliendo sempre la versione HEAD
# Questo script trova tutti i file con marcatori di conflitto <git marker> e risolve automaticamente
# prendendo la versione corrente (HEAD) in modo sicuro e controllato
#
# Uso: ./resolve_head_conflicts_advanced.sh [OPZIONI]
#
# Opzioni:
#   --dry-run    Mostra solo i file che verrebbero risolti senza modificarli
#   --verbose    Mostra output dettagliato durante l'esecuzione
#   --backup     Crea backup dei file originali (default: true)
#   --no-backup  Non creare backup
#   --help       Mostra questo messaggio di aiuto

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Variabili
DRY_RUN=false
VERBOSE=false
CREATE_BACKUP=true
CONFLICTS_FOUND=0
CONFLICTS_RESOLVED=0
CONFLICTS_FAILED=0
SCRIPT_NAME="$(basename "$0")"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Funzione per stampare messaggi colorati
print_message() {
    local color="$1"
    local message="$2"
    echo -e "${color}${message}${NC}"
}

# Funzione per mostrare l'help
show_help() {
    echo "Script avanzato per risolvere automaticamente i conflitti Git scegliendo la versione HEAD"
    echo ""
    echo "Uso: $SCRIPT_NAME [OPZIONI]"
    echo ""
    echo "Opzioni:"
    echo "  --dry-run    Mostra solo i file che verrebbero risolti senza modificarli"
    echo "  --verbose    Mostra output dettagliato durante l'esecuzione"
    echo "  --backup     Crea backup dei file originali (default)"
    echo "  --no-backup  Non creare backup"
    echo "  --help       Mostra questo messaggio di aiuto"
    echo ""
    echo "Funzionalità:"
    echo "  - Trova tutti i file con marcatori di conflitto <git marker>"
    echo "  - Risolve automaticamente prendendo la versione HEAD"
    echo "  - Crea backup dei file originali"
    echo "  - Supporta modalità dry-run per testing"
    echo "  - Output colorato e dettagliato"
    echo ""
    echo "Esempi:"
    echo "  $SCRIPT_NAME                    # Risolve tutti i conflitti"
    echo "  $SCRIPT_NAME --dry-run          # Mostra solo i file con conflitti"
    echo "  $SCRIPT_NAME --verbose          # Risolve con output dettagliato"
    echo "  $SCRIPT_NAME --no-backup        # Risolve senza creare backup"
}

# Parsing degli argomenti
while [[ $# -gt 0 ]]; do
    case $1 in
        --dry-run)
            DRY_RUN=true
            shift
            ;;
        --verbose)
            VERBOSE=true
            shift
            ;;
        --backup)
            CREATE_BACKUP=true
            shift
            ;;
        --no-backup)
            CREATE_BACKUP=false
            shift
            ;;
        --help)
            show_help
            exit 0
            ;;
        -*)
            print_message "$RED" "Errore: Opzione sconosciuta '$1'"
            show_help
            exit 1
            ;;
        *)
            print_message "$RED" "Errore: Argomento non supportato '$1'"
            show_help
            exit 1
            ;;
    esac
done

# Funzione per verificare se siamo in un repository Git
check_git_repo() {
    if ! git rev-parse --git-dir > /dev/null 2>&1; then
        print_message "$RED" "Errore: Non siamo in un repository Git"
        exit 1
    fi
}

# Funzione per trovare tutti i file con conflitti usando ripgrep (più efficiente)
find_conflicted_files() {
    local conflicted_files=()

    # Usa ripgrep per trovare file con marcatori di conflitto
    if command -v rg &> /dev/null; then
        # Con ripgrep (più veloce)
        while IFS= read -r -d '' file; do
            conflicted_files+=("$file")
    else
        # Fallback a grep
        while IFS= read -r file; do
            conflicted_files+=("$file")
    fi

    printf '%s\n' "${conflicted_files[@]}"
}

# Funzione per creare backup del file
create_backup() {
    local file_path="$1"
    local backup_path="${file_path}.conflict-backup.$(date +%Y%m%d_%H%M%S)"

    if [[ "$CREATE_BACKUP" == "true" ]]; then
        cp "$file_path" "$backup_path"
        if [[ "$VERBOSE" == "true" ]]; then
            print_message "$CYAN" "Backup creato: $backup_path"
        fi
    fi
}

# Funzione per risolvere un singolo conflitto prendendo la versione HEAD
resolve_conflict_head() {
    local file_path="$1"
    local temp_file="${file_path}.tmp"

    if [[ "$VERBOSE" == "true" ]]; then
        print_message "$BLUE" "Analizzando: $file_path"
    fi

    # Crea backup del file originale
    create_backup "$file_path"

    # Prima prova con git checkout --ours (metodo nativo Git)
    if git checkout --ours "$file_path" 2>/dev/null; then
        # Verifica che i marcatori di conflitto siano stati rimossi
            if [[ "$VERBOSE" == "true" ]]; then
                print_message "$GREEN" "✓ Conflitto risolto con git checkout --ours: $file_path"
            fi
            return 0
        fi
    fi

    # Se git checkout fallisce o non rimuove tutti i marcatori, usa risoluzione manuale
    if resolve_conflict_manual "$file_path"; then
        if [[ "$VERBOSE" == "true" ]]; then
            print_message "$GREEN" "✓ Conflitto risolto manualmente: $file_path"
        fi
        return 0
    else
        print_message "$RED" "✗ Errore nella risoluzione di: $file_path"
        return 1
    fi
}

# Funzione per risolvere manualmente i conflitti prendendo la versione HEAD
resolve_conflict_manual() {
    local file_path="$1"
    local temp_file="${file_path}.tmp"

    # Legge il file e risolve i conflitti mantenendo solo la parte HEAD
    awk '
    BEGIN { in_ours = 0; in_theirs = 0; }
        if (in_theirs) {
            in_theirs = 0;
        }
        next
    }
    in_ours { print; next }
    in_theirs { next }
    !in_ours && !in_theirs { print }
    ' "$file_path" > "$temp_file"

    # Sostituisce il file originale
    mv "$temp_file" "$file_path"

    # Verifica che non ci siano più marcatori di conflitto
        return 1
    fi

    return 0
}

# Funzione per verificare la risoluzione dei conflitti
verify_resolution() {
    local file_path="$1"

    # Controlla se ci sono ancora marcatori di conflitto
        print_message "$RED" "✗ Verifica fallita: marcatori di conflitto ancora presenti in $file_path"
        return 1
    fi

    return 0
}

# Funzione per mostrare il riepilogo
show_summary() {
    echo ""
    print_message "$PURPLE" "=== RIEPILOGO RISOLUZIONE CONFLITTI ==="
    print_message "$YELLOW" "File con conflitti trovati: $CONFLICTS_FOUND"

    if [[ "$DRY_RUN" == "true" ]]; then
        print_message "$YELLOW" "Modalità dry-run: nessun file è stato modificato"
    else
        print_message "$GREEN" "Conflitti risolti con successo: $CONFLICTS_RESOLVED"
        print_message "$RED" "Conflitti falliti: $CONFLICTS_FAILED"

        if [[ $CONFLICTS_RESOLVED -gt 0 ]]; then
            print_message "$YELLOW" "⚠️  Ricorda di verificare le modifiche prima di committare!"
            if [[ "$CREATE_BACKUP" == "true" ]]; then
                print_message "$CYAN" "📦 I file originali sono stati salvati con estensione .conflict-backup.*"
            fi
        fi
    fi
}

# Funzione principale
main() {
    print_message "$PURPLE" "=== RISOLUTORE AVANZATO CONFLITTI GIT ==="
    print_message "$BLUE" "Sempre scegliendo la versione HEAD (current)"
    print_message "$CYAN" "Script: $SCRIPT_NAME"
    print_message "$CYAN" "Directory: $(pwd)"
    echo ""

    # Verifica che siamo in un repository Git
    check_git_repo

    # Trova tutti i file con conflitti
    print_message "$YELLOW" "🔍 Ricerca file con marcatori di conflitto <git marker>..."
    mapfile -t conflicted_files < <(find_conflicted_files)

    CONFLICTS_FOUND=${#conflicted_files[@]}

    if [[ $CONFLICTS_FOUND -eq 0 ]]; then
        print_message "$GREEN" "✅ Nessun conflitto trovato!"
        exit 0
    fi

    print_message "$YELLOW" "📋 Trovati $CONFLICTS_FOUND file con conflitti:"
    for file in "${conflicted_files[@]}"; do
        echo "  - $file"
    done
    echo ""

    if [[ "$DRY_RUN" == "true" ]]; then
        print_message "$YELLOW" "🚫 Modalità dry-run attivata - nessun file verrà modificato"
        show_summary
        exit 0
    fi

    # Risolve ogni conflitto
    print_message "$YELLOW" "🔄 Risoluzione conflitti in corso..."
    for file in "${conflicted_files[@]}"; do
        if resolve_conflict_head "$file"; then
            if verify_resolution "$file"; then
                ((CONFLICTS_RESOLVED++))
            else
                ((CONFLICTS_FAILED++))
            fi
        else
            ((CONFLICTS_FAILED++))
        fi
    done

    # Mostra il riepilogo
    show_summary

    # Suggerisce i prossimi passi
    if [[ $CONFLICTS_RESOLVED -gt 0 ]]; then
        echo ""
        print_message "$BLUE" "📝 Prossimi passi suggeriti:"
        echo "  1. Verifica le modifiche: git diff"
        echo "  2. Aggiungi i file risolti: git add <file>"
        echo "  3. Completa il merge: git commit"
        if [[ "$CREATE_BACKUP" == "true" ]]; then
            echo "  4. Se necessario, rimuovi i backup: find . -name '*.conflict-backup.*' -delete"
        fi
    fi

    # Exit code basato sul successo
    if [[ $CONFLICTS_FAILED -gt 0 ]]; then
        exit 1
    else
        exit 0
    fi
}

# Gestione degli errori
trap 'print_message "$RED" "Script interrotto dall\'utente!"; exit 1' INT TERM

# Esegue la funzione principale
