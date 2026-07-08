#!/bin/bash

# BMAD + GSD Helper Script
# Script di supporto per l'utilizzo combinato di BMAD e GSD

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzioni di output
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

# Funzioni principali

# Genera project context per BMAD
generate_context() {
    log_info "Generando project context per BMAD..."
    cd _bmad
    if command -v bmad-generate-project-context &> /dev/null; then
        bmad-generate-project-context
        log_success "Project context generato"
    else
        log_warning "bmad-generate-project-context non trovato, uso versione esistente"
        cat bmm/workflows/bmad-generate-project-context/project-context-ptvx.md
    fi
    cd ..
}

# Crea PRD con BMAD
create_prd() {
    local topic="$1"
    if [ -z "$topic" ]; then
        log_error "Specificare un topic per il PRD"
        echo "Usage: $0 create-prd <topic>"
        exit 1
    fi

    log_info "Creando PRD per: $topic"
    cd _bmad
    if command -v bmad-create-prd &> /dev/null; then
        bmad-create-prd --topic "$topic"
        log_success "PRD creato"
    else
        log_warning "bmad-create-prd non disponibile, creazione manuale"
        echo "# PRD per: $topic" > "../.planning/PRD-$topic.md"
        echo "Da completare manualmente" >> "../.planning/PRD-$topic.md"
    fi
    cd ..
}

# Avvia fase di planning con GSD
plan_phase() {
    local phase="$1"
    if [ -z "$phase" ]; then
        log_error "Specificare la fase di planning"
        echo "Usage: $0 plan-phase <numero-fase>"
        exit 1
    fi

    log_info "Avviando planning fase $phase con GSD..."
    # Simula comando GSD
    echo "Simulazione: /gsd:plan-phase $phase"
    generate_context
}

# Esegue sviluppo rapido con BMAD
quick_dev() {
    local intent="$1"
    if [ -z "$intent" ]; then
        log_error "Specificare l'intento per lo sviluppo"
        echo "Usage: $0 quick-dev <intent>"
        exit 1
    fi

    log_info "Eseguendo sviluppo rapido: $intent"
    cd _bmad
    if command -v bmad-quick-dev &> /dev/null; then
        bmad-quick-dev --intent "$intent"
        log_success "Sviluppo rapido completato"
    else
        log_warning "bmad-quick-dev non disponibile"
        echo "Intent: $intent" > "../.planning/quick-dev-$intent.md"
        echo "Da implementare manualmente" >> "../.planning/quick-dev-$intent.md"
    fi
    cd ..
}

# Brainstorming con BMAD
brainstorm() {
    local topic="$1"
    if [ -z "$topic" ]; then
        log_error "Specificare un topic per il brainstorming"
        echo "Usage: $0 brainstorm <topic>"
        exit 1
    fi

    log_info "Avviando brainstorming per: $topic"
    cd _bmad
    if command -v bmad-brainstorming &> /dev/null; then
        bmad-brainstorming --topic "$topic"
        log_success "Brainstorming completato"
    else
        log_warning "bmad-brainstorming non disponibile"
        echo "# Brainstorming per: $topic" > "../.planning/brainstorm-$topic.md"
        echo "Da completare manualmente" >> "../.planning/brainstorm-$topic.md"
    fi
    cd ..
}

# Code review con BMAD
code_review() {
    local path="$1"
    local focus="$2"

    log_info "Eseguendo code review per: $path"
    if [ -n "$focus" ]; then
        log_info "Focus specifico: $focus"
    fi

    cd _bmad
    if command -v bmad-code-review &> /dev/null; then
        bmad-code-review --path "$path" --focus "$focus"
        log_success "Code review completata"
    else
        log_warning "bmad-code-review non disponibile"
        echo "# Code Review per: $path" > "../.planning/code-review-$path.md"
        echo "Focus: $focus" >> "../.planning/code-review-$path.md"
        echo "Da completare manualmente" >> "../.planning/code-review-$path.md"
    fi
    cd ..
}

# Mostra status integrato
show_status() {
    log_info "=== Status GSD + BMAD ==="
    echo ""
    echo "GSD Status:"
    if [ -f ".planning/STATE.md" ]; then
        echo "  Stato attuale: $(grep -E "^State:" .planning/STATE.md | head -1)"
    fi

    echo ""
    echo "BMAD Status:"
    if [ -f "_bmad/core/config.yaml" ]; then
        echo "  Versione: $(grep version _bmad/core/config.yaml | cut -d' ' -f2)"
    fi

    echo ""
    echo "Output directory:"
    if [ -d "_bmad-output" ]; then
        ls -la _bmad-output/ | head -10
    fi
}

# Mostra help
show_help() {
    cat << EOF
BMAD + GSD Helper Script

Uso: $0 <comando> [opzioni]

Comandi disponibili:
  context                 Genera project context per BMAD
  create-prd <topic>     Crea un PRD con BMAD
  plan-phase <num>       Avvia planning fase con GSD
  quick-dev <intent>     Esegue sviluppo rapido con BMAD
  brainstorm <topic>     Avvia brainstorming con BMAD
  code-review <path> [focus]  Esegue code review con BMAD
  status                 Mostra status integrato
  help                   Mostra questo help

Esempi:
  $0 context
  $0 create-prd "Nuovo modulo di performance evaluation"
  $0 plan-phase 1
  $0 quick-dev "Fix bug login"
  $0 brainstorm "Nuove funzionalità HR"
  $0 code-review laravel/Modules/Auth/
EOF
}

# Main script
case "${1:-}" in
    "context")
        generate_context
        ;;
    "create-prd")
        create_prd "$2"
        ;;
    "plan-phase")
        plan_phase "$2"
        ;;
    "quick-dev")
        quick_dev "$2"
        ;;
    "brainstorm")
        brainstorm "$2"
        ;;
    "code-review")
        code_review "$2" "$3"
        ;;
    "status")
        show_status
        ;;
    "help"|"-h"|"--help"|""|"")
        show_help
        ;;
    *)
        log_error "Comando sconosciuto: $1"
        show_help
        exit 1
        ;;
esac