#!/bin/bash
set -euo pipefail

# Script per risolvere automaticamente tutti i conflitti Git scegliendo sempre la versione HEAD (current)
# Questo script trova tutti i file con conflitti e risolve automaticamente prendendo la versione corrente
#
# Uso: ./auto_resolve_head_conflicts.sh [--dry-run] [--verbose]
#
# Opzioni:
#   --dry-run    Mostra solo i file che verrebbero risolti senza modificarli
#   --verbose    Mostra output dettagliato durante l'esecuzione

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Variabili
DRY_RUN=false
VERBOSE=false
CONFLICTS_FOUND=0
CONFLICTS_RESOLVED=0

# Funzione per stampare messaggi colorati
print_message() {
    local color=$1
    local message=$2
    echo -e "${color}${message}${NC}"
}

# Funzione per mostrare l'help
show_help() {
    echo "Script per risolvere automaticamente i conflitti Git scegliendo la versione HEAD"
    echo ""
    echo "Uso: $0 [OPZIONI]"
    echo ""
    echo "Opzioni:"
    echo "  --dry-run    Mostra solo i file che verrebbero risolti senza modificarli"
    echo "  --verbose    Mostra output dettagliato durante l'esecuzione"
    echo "  --help       Mostra questo messaggio di aiuto"
    echo ""
    echo "Esempi:"
    echo "  $0                    # Risolve tutti i conflitti"
    echo "  $0 --dry-run          # Mostra solo i file con conflitti"
    echo "  $0 --verbose          # Risolve con output dettagliato"
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
        --help)
            show_help
            exit 0
            ;;
        *)
            print_message $RED "Errore: Opzione sconosciuta '$1'"
            show_help
            exit 1
            ;;
    esac
done

# Funzione per verificare se siamo in un repository Git
check_git_repo() {
    if ! git rev-parse --git-dir > /dev/null 2>&1; then
        print_message $RED "Errore: Non siamo in un repository Git"
        exit 1
    fi
}

# Funzione per trovare tutti i file con conflitti
find_conflicted_files() {
    local conflicted_files=()

    # Trova file con conflitti usando git status (metodo affidabile)
    while IFS= read -r line; do
        if [[ "$line" =~ ^(UU|AA|DD) ]]; then
            local file="${line:3}"
            if [[ -n "$file" ]]; then
                conflicted_files+=("$file")
            fi
        fi
    done < <(git status --porcelain)

    printf '%s\n' "${conflicted_files[@]}"
}

# Funzione per risolvere un singolo conflitto prendendo la versione HEAD
resolve_conflict_head() {
    local file_path="$1"
    local temp_file="${file_path}.tmp"
    
    if [[ "$VERBOSE" == "true" ]]; then
        print_message $BLUE "Risolvendo conflitto in: $file_path"
    fi
    
    # Crea un backup del file originale
    cp "$file_path" "${file_path}.backup"
    
    # Usa git checkout per prendere la versione HEAD
    if git checkout --ours "$file_path" 2>/dev/null; then
        if [[ "$VERBOSE" == "true" ]]; then
            print_message $GREEN "✓ Conflitto risolto per: $file_path"
        fi
        return 0
    else
        # Se git checkout fallisce, prova con una risoluzione manuale
        if resolve_conflict_manual "$file_path"; then
            if [[ "$VERBOSE" == "true" ]]; then
                print_message $GREEN "✓ Conflitto risolto manualmente per: $file_path"
            fi
            return 0
        else
            print_message $RED "✗ Errore nella risoluzione di: $file_path"
            return 1
        fi
    fi
}

# Funzione per risolvere manualmente i conflitti prendendo la versione HEAD
resolve_conflict_manual() {
    local file_path="$1"
    local temp_file="${file_path}.tmp"
    
    # Legge il file e risolve i conflitti
    awk '
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

# Funzione per mostrare il riepilogo
show_summary() {
    echo ""
    print_message $BLUE "=== RIEPILOGO ==="
    print_message $YELLOW "File con conflitti trovati: $CONFLICTS_FOUND"
    
    if [[ "$DRY_RUN" == "true" ]]; then
        print_message $YELLOW "Modalità dry-run: nessun file è stato modificato"
    else
        print_message $GREEN "Conflitti risolti: $CONFLICTS_RESOLVED"
        if [[ $CONFLICTS_RESOLVED -gt 0 ]]; then
            print_message $YELLOW "Ricorda di verificare le modifiche prima di committare!"
            print_message $YELLOW "I file originali sono stati salvati con estensione .backup"
        fi
    fi
}

# Funzione principale
main() {
    print_message $BLUE "=== RISOLUTORE AUTOMATICO CONFLITTI GIT ==="
    print_message $BLUE "Sempre scegliendo la versione HEAD (current)"
    echo ""
    
    # Verifica che siamo in un repository Git
    check_git_repo
    
    # Trova tutti i file con conflitti
    print_message $YELLOW "Ricerca file con conflitti..."
    mapfile -t conflicted_files < <(find_conflicted_files)
    
    CONFLICTS_FOUND=${#conflicted_files[@]}
    
    if [[ $CONFLICTS_FOUND -eq 0 ]]; then
        print_message $GREEN "✓ Nessun conflitto trovato!"
        exit 0
    fi
    
    print_message $YELLOW "Trovati $CONFLICTS_FOUND file con conflitti:"
    for file in "${conflicted_files[@]}"; do
        echo "  - $file"
    done
    echo ""
    
    if [[ "$DRY_RUN" == "true" ]]; then
        print_message $YELLOW "Modalità dry-run attivata - nessun file verrà modificato"
        show_summary
        exit 0
    fi
    
    # Risolve ogni conflitto
    print_message $YELLOW "Risoluzione conflitti in corso..."
    for file in "${conflicted_files[@]}"; do
        if resolve_conflict_head "$file"; then
            ((CONFLICTS_RESOLVED++))
        fi
    done
    
    # Mostra il riepilogo
    show_summary
    
    # Suggerisce i prossimi passi
    if [[ $CONFLICTS_RESOLVED -gt 0 ]]; then
        echo ""
        print_message $BLUE "Prossimi passi suggeriti:"
        echo "  1. Verifica le modifiche: git diff"
        echo "  2. Aggiungi i file risolti: git add <file>"
        echo "  3. Completa il merge: git commit"
        echo "  4. Se necessario, rimuovi i backup: rm *.backup"
    fi
}

# Gestione degli errori
trap 'print_message $RED "Script interrotto!"; exit 1' INT TERM

# Esegue la funzione principale
main "$@"
