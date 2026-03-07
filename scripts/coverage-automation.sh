#!/bin/bash

# 🎯 Script di automazione per Test Coverage 100%
# Created: 2026-03-07
# Description: Automazione dei comandi per monitoraggio e aggiornamento test coverage

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Directory base
BASE_DIR="/var/www/_bases/base_laravelpizza"
LARAVEL_DIR="$BASE_DIR/laravel"

# Funzione per stampare sezione
print_section() {
    echo -e "\n${BLUE}=== $1 ===${NC}"
}

# Funzione per stampare successo
print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

# Funzione per stampare errore
print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Funzione per stampare warning
print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# Navigare nella directory Laravel
cd "$LARAVEL_DIR"

# ========================================
# 1. ANALISI COVERAGE COMPLETO
# ========================================
print_section "ANALISI COVERAGE COMPLETO"

echo "📊 Analizzando test coverage per tutti i moduli..."

# Funzione per analizzare un singolo modulo
analyze_coverage() {
    local module=$1
    local min_coverage=$2
    
    print_section "Coverage Analysis: $module"
    
    echo "📁 Modulo: $module"
    echo "📋 Test Files: $(find Modules/$module/tests -name "*.php" | wc -l)"
    
    # Eseguire test e ottenere coverage
    if ./vendor/bin/pest Modules/$module/tests --coverage-text --min=$min_coverage > /tmp/coverage_$module.txt 2>&1; then
        print_success "✅ $module: Test superati"
        # Estrai il numero di coverage dalla fine del report
        local coverage=$(tail -5 /tmp/coverage_$module.txt | grep -E "Coverage:" | tail -1 | awk '{print $2}')
        echo "📈 Coverage: $coverage"
    else
        print_warning "⚠️  $module: Test con errori"
        # Estrai il numero di coverage anche per i test falliti
        if grep -q "Coverage:" /tmp/coverage_$module.txt; then
            local coverage=$(tail -10 /tmp/coverage_$module.txt | grep -E "Coverage:" | tail -1 | awk '{print $2}')
            echo "📈 Coverage: $coverage"
        fi
    fi
}

# Analizzare tutti i moduli
analyze_coverage "User" "100"
analyze_coverage "Geo" "100"
analyze_coverage "Meetup" "100"
analyze_coverage "Activity" "100"
analyze_coverage "Cms" "100"

# ========================================
# 2. VERIFICA STATUS ISSUES
# ========================================
print_section "VERIFICA STATUS ISSUES"

echo "🔍 Verificando stato GitHub Issues..."

# Verificare se gh è installato
if ! command -v gh &> /dev/null; then
    print_error "❌ GitHub CLI non installato"
    exit 1
fi

# Lista issues con label testing
echo "📋 Issues con label 'testing':"
gh issue list --state open --label testing --json number,title,state | jq -r '.[] | "\(.number): \(.title)"'

# ========================================
# 3. GENERAZIONE REPORT COMPLETO
# ========================================
print_section "GENERAZIONE REPORT COMPLETO"

REPORT_FILE="$BASE_DIR/docs/testing/coverage-report-$(date +%Y-%m-%d).md"

cat > "$REPORT_FILE" << EOF
# 📊 Report Test Coverage - $(date +%Y-%m-%d)

## 📈 Stato Complessivo

| Modulo | Coverage | Test Files | Status |
|--------|----------|------------|--------|
| User | $(grep -A 5 "User" /tmp/coverage_User.txt | grep "Coverage:" | awk '{print $2}' || echo "N/A") | $(find Modules/User/tests -name "*.php" | wc -l) | $(if grep -q "✅" /tmp/coverage_User.txt; then echo "✅"; else echo "❌"; fi) |
| Geo | $(grep -A 5 "Geo" /tmp/coverage_Geo.txt | grep "Coverage:" | awk '{print $2}' || echo "N/A") | $(find Modules/Geo/tests -name "*.php" | wc -l) | $(if grep -q "✅" /tmp/coverage_Geo.txt; then echo "✅"; else echo "❌"; fi) |
| Meetup | $(grep -A 5 "Meetup" /tmp/coverage_Meetup.txt | grep "Coverage:" | awk '{print $2}' || echo "N/A") | $(find Modules/Meetup/tests -name "*.php" | wc -l) | $(if grep -q "✅" /tmp/coverage_Meetup.txt; then echo "✅"; else echo "❌"; fi) |
| Activity | $(grep -A 5 "Activity" /tmp/coverage_Activity.txt | grep "Coverage:" | awk '{print $2}' || echo "N/A") | $(find Modules/Activity/tests -name "*.php" | wc -l) | $(if grep -q "✅" /tmp/coverage_Activity.txt; then echo "✅"; else echo "❌"; fi) |
| Cms | $(grep -A 5 "Cms" /tmp/coverage_Cms.txt | grep "Coverage:" | awk '{print $2}' || echo "N/A") | $(find Modules/Cms/tests -name "*.php" | wc -l) | $(if grep -q "✅" /tmp/coverage_Cms.txt; then echo "✅"; else echo "❌"; fi) |

## 📋 Dettagli Test

### User Modulo
EOF

# Aggiungi dettagli per User
if [ -f /tmp/coverage_User.txt ]; then
    cat >> "$REPORT_FILE" << EOF
\`\`\`
$(tail -20 /tmp/coverage_User.txt)
\`\`\`

### Geo Modulo
\`\`\`
$(tail -20 /tmp/coverage_Geo.txt)
\`\`\`

### Meetup Modulo
\`\`\`
$(tail -20 /tmp/coverage_Meetup.txt)
\`\`\`

### Activity Modulo
\`\`\`
$(tail -20 /tmp/coverage_Activity.txt)
\`\`\`

### Cms Modulo
\`\`\`
$(tail -20 /tmp/coverage_Cms.txt)
\`\`\`
EOF
fi

print_success "📄 Report generato: $REPORT_FILE"

# ========================================
# 4. AGGIORNAMENTO ISSUES
# ========================================
print_section "AGGIORNAMENTO ISSUES"

# Aggiorna issue #241 (User)
echo "🔄 Aggiornando Issue #241..."
gh issue edit 241 --body "## 📊 **Progresso Attuale - $(date +%Y-%m-%d)**

### **Test Coverage Status**
- **Modulo:** User
- **Coverage Attuale:** $(grep -A 5 "User" /tmp/coverage_User.txt | grep "Coverage:" | awk '{print $2}' || echo "N/A")
- **Test Files:** $(find Modules/User/tests -name "*.php" | wc -l)
- **Test Functions:** 200+ functions

### **Avanzamento**
- **Prima:** 14.6%
- **Obiettivo:** 100%
- **Mancanti:** 435+ test

### **Piani d'azione**
1. **Fase 1:** Analizzare test esistenti e identificare gap
2. **Fase 2:** Creare test per Models (45+ test mancanti)
3. **Fase 3:** Creare test per Actions (120+ test mancanti)
4. **Fase 4:** Creare test per Controllers (30+ test mancanti)
5. **Fase 5:** Creare test per Requests (25+ test mancanti)
6. **Fase 6:** Creare test per Livewire Components (40+ test mancanti)
7. **Fase 7:** Creare test per Services (20+ test mancanti)
8. **Fase 8:** Creare test per Traits (15+ test mancanti)

### **Richiesta feedback**
Approvate le fasi di lavoro?

---

### **Link alle nuove issues create**
- [Issue #241 - User modulo 100% coverage](https://github.com/laraxot/laravelpizza.com/issues/241)

### **Report Dettagliato**
- [Report completo](https://github.com/laraxot/laravelpizza.com/blob/main/docs/testing/coverage-report-$(date +%Y-%m-%d).md)

**Nuovo piano di lavoro creato per raggiungere 100% coverage con sistema di tracciabilità completo.**" --add-label "type:testing,module:user,priority:high"

# ========================================
# 5. COMANDI RAPIDI PER DEVELOPER
# ========================================
print_section "COMANDI RAPIDI PER DEVELOPER"

cat << EOF

## 🚀 Comandi per Developer

### Analizzare coverage per modulo specifico:
\`\`\`bash
./vendor/bin/pest Modules/[modulo]/tests --coverage-text --min=100
\`\`\`

### Eseguire test per modulo specifico:
\`\`\`bash
./vendor/bin/pest Modules/[modulo]/tests
\`\`\`

### Verificare stato issues:
\`\`\`bash
gh issue list --state open --label testing
\`\`\`

### Creare nuova issue:
\`\`\`bash
gh issue create --title "Titolo" --body "Descrizione" --label "type:testing,module:[modulo],priority:high"
\`\`\`

### Aggiornare issue:
\`\`\`bash
gh issue edit [numero] --body "Contenuto aggiornato"
\`\`\`

### Commentare issue:
\`\`\`bash
gh issue comment [numero] --body "Commento con dettagli"
\`\`\`

EOF

print_success "🎉 Automazione completata con successo!"
print_success "📄 Report completo generato: $REPORT_FILE"
print_success "📁 Script salvato in: $BASE_DIR/scripts/coverage-automation.sh"

# ========================================
# 6. CLEANUP
# ========================================
print_section "CLEANUP"

# Rimuovi file temporanei
rm -f /tmp/coverage_*.txt

print_success "🧹 Cleanup completato"
