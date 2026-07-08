#!/bin/bash
# PHPStan Memory-Optimized Module Analysis
# Due to WSL2 memory constraints, analyzes each module individually
# Usage: ./phpstan-analyze-modules.sh [module-name] or ./phpstan-analyze-modules.sh all

set -e

MODULES_DIR="Modules"
MODULE_TO_ANALYZE="${1:-all}"

# List of modules to analyze
MODULES=(
    Activity
    CertFisc
    ContoAnnuale
    DbForge
    Europa
    Gdpr
    Inail
    Incentivi
    IndennitaCondizioniLavoro
    IndennitaResponsabilita
    Job
    Lang
    Legge104
    Legge109
    Media
    Mensa
    MobilitaVolontaria
    Notify
    Pdnd
    Performance
    Prenotazioni
    PresenzeAssenze
    Progressioni
    Ptv
    Questionari
    Rating
    Setting
    Sigma
    Sindacati
    Tenant
    UI
    User
    Xot
)

analyze_module() {
    local module=$1
    echo ""
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Analyzing: $module"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

    if [ ! -d "$MODULES_DIR/$module" ]; then
        echo "⚠️  Module not found: $MODULES_DIR/$module"
        return 1
    fi

    php -d memory_limit=-1 ./vendor/bin/phpstan analyse "$MODULES_DIR/$module" \
        --memory-limit=4G \
        --no-progress 2>&1 | tail -20

    echo "✓ Analysis complete for: $module"
}

if [ "$MODULE_TO_ANALYZE" = "all" ]; then
    echo "Analyzing all modules (this may take a while)..."
    ERROR_COUNT=0
    for module in "${MODULES[@]}"; do
        if ! analyze_module "$module"; then
            ((ERROR_COUNT++))
        fi
    done

    echo ""
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "Summary: Analyzed ${#MODULES[@]} modules, $ERROR_COUNT errors"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
else
    analyze_module "$MODULE_TO_ANALYZE"
fi
