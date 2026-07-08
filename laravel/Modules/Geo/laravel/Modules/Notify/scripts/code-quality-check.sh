#!/bin/bash

# Code Quality Check Script
# Esegue tutti gli strumenti di analisi del codice per verificare la qualità

set -e

echo "🔍 Starting Code Quality Analysis..."
echo "=================================="

# Verifica che siamo nella directory corretta
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found. Please run this script from the project root."
    exit 1
fi

# Crea directory per i report se non esiste
mkdir -p reports

# PHPStan Analysis
echo "📊 Running PHPStan..."
echo "-------------------"
if ./vendor/bin/phpstan analyse --memory-limit=-1 --no-progress > reports/phpstan-report.txt 2>&1; then
    echo "✅ PHPStan: No errors found"
else
    echo "❌ PHPStan: Errors found - check reports/phpstan-report.txt"
    PHPSTAN_ERRORS=true
fi

# PHPMD Analysis
echo ""
echo "🔧 Running PHPMD..."
echo "------------------"

# Analisi app directory
if ./vendor/bin/phpmd app/ text phpmd.xml > reports/phpmd-app-report.txt 2>&1; then
    echo "✅ PHPMD (app/): No violations found"
else
    echo "❌ PHPMD (app/): Violations found - check reports/phpmd-app-report.txt"
    PHPMD_ERRORS=true
fi

# Analisi Modules directory
if ./vendor/bin/phpmd Modules/ text phpmd.xml > reports/phpmd-modules-report.txt 2>&1; then
    echo "✅ PHPMD (Modules/): No violations found"
else
    echo "❌ PHPMD (Modules/): Violations found - check reports/phpmd-modules-report.txt"
    PHPMD_ERRORS=true
fi

# Analisi Themes directory
if ./vendor/bin/phpmd Themes/ text phpmd.xml > reports/phpmd-themes-report.txt 2>&1; then
    echo "✅ PHPMD (Themes/): No violations found"
else
    echo "❌ PHPMD (Themes/): Violations found - check reports/phpmd-themes-report.txt"
    PHPMD_ERRORS=true
fi

# Laravel Pint Check
echo ""
echo "🎨 Running Laravel Pint..."
echo "-------------------------"
if ./vendor/bin/pint --test > reports/pint-report.txt 2>&1; then
    echo "✅ Laravel Pint: Code is properly formatted"
else
    echo "❌ Laravel Pint: Code formatting issues found - check reports/pint-report.txt"
    PINT_ERRORS=true
fi

# PHP CS Fixer Check
echo ""
echo "🔧 Running PHP CS Fixer..."
echo "-------------------------"
if ./vendor/bin/php-cs-fixer fix --dry-run --diff > reports/php-cs-fixer-report.txt 2>&1; then
    echo "✅ PHP CS Fixer: Code style is correct"
else
    echo "❌ PHP CS Fixer: Code style issues found - check reports/php-cs-fixer-report.txt"
    CS_FIXER_ERRORS=true
fi

# Psalm Analysis
echo ""
echo "🔍 Running Psalm..."
echo "------------------"
if ./vendor/bin/psalm > reports/psalm-report.txt 2>&1; then
    echo "✅ Psalm: No issues found"
else
    echo "❌ Psalm: Issues found - check reports/psalm-report.txt"
    PSALM_ERRORS=true
fi

# Summary
echo ""
echo "📋 SUMMARY"
echo "=========="

if [ "$PHPSTAN_ERRORS" = true ] || [ "$PHPMD_ERRORS" = true ] || [ "$PINT_ERRORS" = true ] || [ "$CS_FIXER_ERRORS" = true ] || [ "$PSALM_ERRORS" = true ]; then
    echo "❌ Code Quality Check FAILED"
    echo ""
    echo "Issues found in:"
    [ "$PHPSTAN_ERRORS" = true ] && echo "  - PHPStan"
    [ "$PHPMD_ERRORS" = true ] && echo "  - PHPMD"
    [ "$PINT_ERRORS" = true ] && echo "  - Laravel Pint"
    [ "$CS_FIXER_ERRORS" = true ] && echo "  - PHP CS Fixer"
    [ "$PSALM_ERRORS" = true ] && echo "  - Psalm"
    echo ""
    echo "Check the reports in the reports/ directory for details."
    echo "Run ./scripts/code-quality-fix.sh to automatically fix some issues."
    exit 1
else
    echo "✅ Code Quality Check PASSED"
    echo ""
    echo "All tools passed successfully:"
    echo "  ✅ PHPStan: No errors"
    echo "  ✅ PHPMD: No violations"
    echo "  ✅ Laravel Pint: Properly formatted"
    echo "  ✅ PHP CS Fixer: Correct style"
    echo "  ✅ Psalm: No issues"
    echo ""
    echo "🎉 Your code is in excellent shape!"
fi