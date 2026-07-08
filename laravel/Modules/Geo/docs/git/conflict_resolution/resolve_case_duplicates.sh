#!/bin/bash

# Script per risolvere automaticamente i duplicati critici (case-insensitive)
# Risolve solo i duplicati più critici che possono causare problemi

echo "🔧 Risoluzione automatica duplicati critici..."
echo ""

# Directory di lavoro
PROJECT_ROOT="/var/www/_bases/base_fixcity_fila5_mono"
cd "$PROJECT_ROOT"

# Contatore
resolved_count=0
total_checked=0

echo "📋 RISOLUZIONE DUPLICATI CRITICI:"
echo "================================="
echo ""

# 1. Risolvi duplicati PHP critici
echo "🔴 1. Risolvendo duplicati PHP critici..."

# ChangeStatus.php duplicato
if [[ -f "laravel/Modules/Fixcity/app/Filament/Actions/ChangeStatus.php" && -f "laravel/Modules/Fixcity/app/Actions/ChangeStatus.php" ]]; then
    echo "   - Rimuovendo ChangeStatus.php duplicato..."
    rm -f "laravel/Modules/Fixcity/app/Actions/ChangeStatus.php"
    resolved_count=$((resolved_count + 1))
fi

# DummyTestModel.php duplicato
if [[ -f "laravel/Modules/Xot/tests/Unit/Support/DummyTestModel.php" && -f "laravel/Modules/Xot/tests/Unit/DummyTestModel.php" ]]; then
    echo "   - Rimuovendo DummyTestModel.php duplicato..."
    rm -f "laravel/Modules/Xot/tests/Unit/DummyTestModel.php"
    resolved_count=$((resolved_count + 1))
fi

# ActivityPolicy.php duplicato
if [[ -f "laravel/Modules/Activity/app/Models/Policies/ActivityPolicy.php" && -f "laravel/Modules/Fixcity/app/Models/Policies/ActivityPolicy.php" ]]; then
    echo "   - Rimuovendo ActivityPolicy.php duplicato da Fixcity..."
    rm -f "laravel/Modules/Fixcity/app/Models/Policies/ActivityPolicy.php"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 2. Risolvi duplicati Livewire
echo "🔴 2. Risolvendo duplicati Livewire..."

# Tableto_formx duplicato (case sensitivity)
if [[ -d "laravel/Modules/Xot/app/Http/Livewire/tableto_formx" && -d "laravel/Modules/Xot/app/Http/Livewire/Tableto_formx" ]]; then
    echo "   - Rimuovendo tableto_formx (lowercase) duplicato..."
    rm -rf "laravel/Modules/Xot/app/Http/Livewire/tableto_formx"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 3. Risolvi duplicati SVG flags
echo "🔴 3. Risolvendo duplicati SVG flags..."

# Rimuovi bandiere duplicate dal modulo Lang (mantieni quelle in UI)
FLAGS_TO_REMOVE=("ca.svg" "ma.svg" "ae.svg" "bh.svg" "mc.svg" "bs.svg" "ag.svg" "ck.svg")

for flag in "${FLAGS_TO_REMOVE[@]}"; do
    if [[ -f "laravel/Modules/Lang/resources/svg/flag/$flag" && -f "laravel/Modules/UI/resources/svg/flags/$flag" ]]; then
        echo "   - Rimuovendo bandiera duplicata: $flag"
        rm -f "laravel/Modules/Lang/resources/svg/flag/$flag"
        resolved_count=$((resolved_count + 1))
    fi
done

echo ""

# 4. Risolvi duplicati documentazione
echo "🔴 4. Risolvendo duplicati documentazione..."

# Rimuovi documentazione PHPStan duplicata (mantieni quella in Xot)
DOCS_TO_REMOVE=("phpstan.md" "model-factory-seeder-audit.md")

for doc in "${DOCS_TO_REMOVE[@]}"; do
    # Rimuovi da tutti i moduli tranne Xot
    find laravel/Modules -name "$doc" -not -path "*/Xot/*" -delete 2>/dev/null
    if [[ $? -eq 0 ]]; then
        echo "   - Rimossa documentazione duplicata: $doc"
        resolved_count=$((resolved_count + 1))
    fi
done

echo ""

# 5. Risolvi duplicati file di configurazione
echo "🔴 5. Risolvendo duplicati configurazione..."

# Rimuovi file di configurazione duplicati in bashscripts
if [[ -f "bashscripts/lang/pt_BR/exceptions.php" && -f "laravel/Modules/Xot/lang/pt_BR/exceptions.php" ]]; then
    echo "   - Rimuovendo configurazioni duplicate in bashscripts..."
    rm -rf bashscripts/lang/
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 6. Risolvi duplicati file di test
echo "🔴 6. Risolvendo duplicati file di test..."

# Rimuovi file di test duplicati
if [[ -f "bashscripts/testing/zibibbo04.test" && -f "bashscripts/temp/zibibbo04.test" ]]; then
    echo "   - Rimuovendo file di test duplicati..."
    rm -f "bashscripts/temp/zibibbo04.test"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 7. Risolvi duplicati file di documentazione
echo "🔴 7. Risolvendo duplicati documentazione..."

# Rimuovi documentazione duplicata
if [[ -f "bashscripts/docs/source/docs/install_from_zero.md" && -f "bashscripts/docs/install/install_from_zero.md" ]]; then
    echo "   - Rimuovendo documentazione duplicata..."
    rm -f "bashscripts/docs/source/docs/install_from_zero.md"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 8. Risolvi duplicati file di configurazione
echo "🔴 8. Risolvendo duplicati configurazione..."

# Rimuovi file di configurazione duplicati
if [[ -f "bashscripts/organize_docs_structure.sh" && -f "bashscripts/scripts/docs/organize_docs_structure.sh" ]]; then
    echo "   - Rimuovendo script duplicati..."
    rm -f "bashscripts/scripts/docs/organize_docs_structure.sh"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 9. Risolvi duplicati file di documentazione
echo "🔴 9. Risolvendo duplicati documentazione..."

# Rimuovi documentazione duplicata
if [[ -f "laravel/Modules/Lang/docs/best-practices/documentation-link-conventions.md" && -f "laravel/Modules/Lang/docs/documentation-link-conventions.md" ]]; then
    echo "   - Rimuovendo documentazione duplicata..."
    rm -f "laravel/Modules/Lang/docs/best-practices/documentation-link-conventions.md"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# 10. Risolvi duplicati file di documentazione
echo "🔴 10. Risolvendo duplicati documentazione..."

# Rimuovi documentazione duplicata
if [[ -f "laravel/Modules/Media/docs/_integration/convert.md" && -f "laravel/Modules/Media/docs/convert.md" ]]; then
    echo "   - Rimuovendo documentazione duplicata..."
    rm -f "laravel/Modules/Media/docs/_integration/convert.md"
    resolved_count=$((resolved_count + 1))
fi

echo ""

# Mostra statistiche finali
echo "📈 STATISTICHE FINALI:"
echo "======================"
echo "Duplicati risolti: $resolved_count"
echo ""

if [ $resolved_count -eq 0 ]; then
    echo "✅ Nessun duplicato critico trovato!"
    echo "   Il progetto non ha duplicati critici da risolvere."
else
    echo "🎉 Risoluzione completata!"
    echo "   Risolti $resolved_count duplicati critici."
    echo ""
    echo "💡 RACCOMANDAZIONI:"
    echo "   1. Verificare che non ci siano riferimenti ai file eliminati"
    echo "   2. Eseguire i test per verificare che tutto funzioni"
    echo "   3. Committare le modifiche"
    echo ""
    echo "🔧 Per verificare i risultati:"
    echo "   ./bashscripts/find_case_duplicates.sh"
fi

echo ""
echo "🏁 Risoluzione completata!"
