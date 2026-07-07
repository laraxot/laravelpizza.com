#!/bin/bash

# Code Quality Fix Script
# Applica automaticamente le correzioni possibili per migliorare la qualità del codice

set -e

echo "🔧 Starting Code Quality Fixes..."
echo "================================="

# Verifica che siamo nella directory corretta
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found. Please run this script from the project root."
    exit 1
fi

# Crea directory per i report se non esiste
mkdir -p reports

# Laravel Pint Fix
echo "🎨 Running Laravel Pint Fix..."
echo "-----------------------------"
if ./vendor/bin/pint > reports/pint-fix-report.txt 2>&1; then
    echo "✅ Laravel Pint: Code formatting applied successfully"
else
    echo "❌ Laravel Pint: Some issues could not be fixed automatically"
    echo "Check reports/pint-fix-report.txt for details"
fi

# PHP CS Fixer Fix
echo ""
echo "🔧 Running PHP CS Fixer Fix..."
echo "-----------------------------"
if ./vendor/bin/php-cs-fixer fix > reports/php-cs-fixer-fix-report.txt 2>&1; then
    echo "✅ PHP CS Fixer: Code style fixes applied successfully"
else
    echo "❌ PHP CS Fixer: Some issues could not be fixed automatically"
    echo "Check reports/php-cs-fixer-fix-report.txt for details"
fi

# Verifica se ci sono stati cambiamenti
echo ""
echo "📊 Checking for changes..."
echo "-------------------------"

# Controlla se ci sono file modificati
if git diff --quiet; then
    echo "ℹ️  No changes were made to the codebase"
else
    echo "📝 Changes were made to the following files:"
    git diff --name-only
    echo ""
    echo "💡 You may want to review these changes before committing"
fi

# Riavvio dell'analisi per verificare i miglioramenti
echo ""
echo "🔄 Re-running analysis to verify improvements..."
echo "----------------------------------------------"

# PHPStan Analysis
echo "📊 Running PHPStan..."
if ./vendor/bin/phpstan analyse --memory-limit=-1 --no-progress > reports/phpstan-after-fix-report.txt 2>&1; then
    echo "✅ PHPStan: No errors found"
else
    echo "❌ PHPStan: Still has errors - manual intervention required"
fi

# PHPMD Analysis
echo "🔧 Running PHPMD..."
if ./vendor/bin/phpmd app/ text phpmd.xml > reports/phpmd-after-fix-report.txt 2>&1; then
    echo "✅ PHPMD (app/): No violations found"
else
    echo "❌ PHPMD (app/): Still has violations - manual intervention required"
fi

if ./vendor/bin/phpmd Modules/ text phpmd.xml > reports/phpmd-modules-after-fix-report.txt 2>&1; then
    echo "✅ PHPMD (Modules/): No violations found"
else
    echo "❌ PHPMD (Modules/): Still has violations - manual intervention required"
fi

if ./vendor/bin/phpmd Themes/ text phpmd.xml > reports/phpmd-themes-after-fix-report.txt 2>&1; then
    echo "✅ PHPMD (Themes/): No violations found"
else
    echo "❌ PHPMD (Themes/): Still has violations - manual intervention required"
fi

# Summary
echo ""
echo "📋 FIX SUMMARY"
echo "=============="
echo "✅ Automatic fixes applied:"
echo "  - Laravel Pint: Code formatting"
echo "  - PHP CS Fixer: Code style"
echo ""
echo "📁 Reports saved in reports/ directory:"
echo "  - pint-fix-report.txt"
echo "  - php-cs-fixer-fix-report.txt"
echo "  - phpstan-after-fix-report.txt"
echo "  - phpmd-*-after-fix-report.txt"
echo ""
echo "💡 Next steps:"
echo "  1. Review the changes made"
echo "  2. Run ./scripts/code-quality-check.sh to verify all issues are resolved"
echo "  3. Commit the changes if everything looks good"
echo ""
echo "🎉 Code quality fixes completed!"