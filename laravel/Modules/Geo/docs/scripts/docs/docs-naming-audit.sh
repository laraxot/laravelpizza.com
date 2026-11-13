#!/bin/bash

# Script per l'audit e correzione delle convenzioni di naming nelle cartelle docs
# Regola: tutti i file e cartelle in docs/ devono essere lowercase, tranne README.md
# Data: 2025-07-30
# Autore: Cascade AI Assistant

set -e

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
LOG_FILE="$PROJECT_ROOT/bashscripts/docs-naming-audit.log"
VIOLATIONS_FILE="$PROJECT_ROOT/bashscripts/docs-naming-violations.txt"

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== AUDIT CONVENZIONI NAMING CARTELLE DOCS ===${NC}"
echo "Data: $(date)"
echo "Progetto: base_<nome progetto>_fila5_mono"
echo "Log: $LOG_FILE"
echo ""

# Inizializza log
echo "=== DOCS NAMING AUDIT - $(date) ===" > "$LOG_FILE"
echo "" > "$VIOLATIONS_FILE"

# Funzione per controllare se un nome è conforme (lowercase o README.md)
is_compliant() {
    local name="$1"
    
    # README.md è sempre permesso
    if [[ "$name" == "README.md" ]]; then
        return 0
    fi
    
    # Controlla se contiene caratteri maiuscoli
    if [[ "$name" =~ [A-Z] ]]; then
        return 1
    fi
    
    return 0
}

# Funzione per convertire in lowercase mantenendo estensioni
to_lowercase() {
    local name="$1"
    echo "$name" | tr '[:upper:]' '[:lower:]'
}

# Contatori
total_docs_dirs=0
total_files=0
total_violations=0
total_fixed=0

echo -e "${YELLOW}Ricerca cartelle docs...${NC}"

# Trova tutte le cartelle docs
while IFS= read -r -d '' docs_dir; do
    ((total_docs_dirs++))
    
    echo -e "${BLUE}Analizzando: $docs_dir${NC}"
    echo "=== ANALISI: $docs_dir ===" >> "$LOG_FILE"
    
    # Analizza tutti i file e cartelle nella directory docs
    find "$docs_dir" -mindepth 1 -type f -o -type d | while IFS= read -r item; do
        ((total_files++))
        
        # Estrae solo il nome del file/cartella (non il path completo)
        basename_item=$(basename "$item")
        
        if ! is_compliant "$basename_item"; then
            ((total_violations++))
            
            # Calcola il nuovo nome
            new_name=$(to_lowercase "$basename_item")
            parent_dir=$(dirname "$item")
            new_path="$parent_dir/$new_name"
            
            echo -e "${RED}VIOLAZIONE: $item${NC}"
            echo -e "${YELLOW}  Suggerito: $new_path${NC}"
            
            # Log della violazione
            echo "VIOLAZIONE: $item -> $new_path" >> "$LOG_FILE"
            echo "$item|$new_path" >> "$VIOLATIONS_FILE"
            
            # Opzione per correzione automatica (commentata per sicurezza)
            # if [[ ! -e "$new_path" ]]; then
            #     echo "  Rinominando: $item -> $new_path"
            #     mv "$item" "$new_path"
            #     ((total_fixed++))
            #     echo "CORRETTO: $item -> $new_path" >> "$LOG_FILE"
            # else
            #     echo "  ERRORE: $new_path già esistente!" >> "$LOG_FILE"
            # fi
        else
            echo -e "${GREEN}OK: $basename_item${NC}"
            echo "OK: $item" >> "$LOG_FILE"
        fi
    done
    
    echo "" >> "$LOG_FILE"
    
done < <(find "$PROJECT_ROOT" -type d -name "docs" -print0)

echo ""
echo -e "${BLUE}=== RIEPILOGO AUDIT ===${NC}"
echo "Cartelle docs analizzate: $total_docs_dirs"
echo "File/cartelle totali: $total_files"
echo "Violazioni trovate: $total_violations"
echo "Correzioni applicate: $total_fixed"

if [[ $total_violations -gt 0 ]]; then
    echo ""
    echo -e "${YELLOW}ATTENZIONE: Trovate $total_violations violazioni!${NC}"
    echo "Dettagli in: $VIOLATIONS_FILE"
    echo ""
    echo "Per applicare le correzioni automaticamente, decommentare le righe di mv nello script."
    echo "ATTENZIONE: Verificare sempre prima di applicare correzioni automatiche!"
else
    echo -e "${GREEN}Tutte le cartelle docs sono conformi alla policy lowercase!${NC}"
fi

echo ""
echo "Log completo: $LOG_FILE"
echo "Audit completato: $(date)"

# Genera script di correzione se ci sono violazioni
if [[ $total_violations -gt 0 ]]; then
    CORRECTION_SCRIPT="$PROJECT_ROOT/bashscripts/docs-naming-fix.sh"
    echo "#!/bin/bash" > "$CORRECTION_SCRIPT"
    echo "# Script di correzione automatica generato il $(date)" >> "$CORRECTION_SCRIPT"
    echo "# ATTENZIONE: Verificare sempre prima di eseguire!" >> "$CORRECTION_SCRIPT"
    echo "" >> "$CORRECTION_SCRIPT"
    
    while IFS='|' read -r old_path new_path; do
        echo "echo \"Rinominando: $old_path -> $new_path\"" >> "$CORRECTION_SCRIPT"
        echo "mv \"$old_path\" \"$new_path\"" >> "$CORRECTION_SCRIPT"
    done < "$VIOLATIONS_FILE"
    
    chmod +x "$CORRECTION_SCRIPT"
    echo "Script di correzione generato: $CORRECTION_SCRIPT"
fi
