#!/bin/bash

# Full Code Quality Check Script
# Runs all code quality tools and generates comprehensive reports

set -e

echo "🔍 Starting Full Code Quality Analysis..."
echo "========================================"

# Create reports directory
mkdir -p reports

# PHP Tools
echo "📊 Running PHP Analysis Tools..."
echo "--------------------------------"

echo "Running PHPStan..."
cd laravel
./vendor/bin/phpstan analyse Modules --memory-limit=-1 --error-format=json > ../reports/phpstan-report.json 2>&1 || echo "PHPStan found issues - check report"
echo "✅ PHPStan completed"

echo "Running PHPMD..."
./vendor/bin/phpmd Modules,../Themes xml ../phpmd.xml --report-file=../reports/phpmd-report.xml || echo "PHPMD found issues - check report"
echo "✅ PHPMD completed"

echo "Running PHP-CS-Fixer (dry-run)..."
./vendor/bin/php-cs-fixer fix --dry-run --diff --config=../.php-cs-fixer.php --format=json > ../reports/php-cs-fixer-report.json 2>&1 || echo "PHP-CS-Fixer found issues - check report"
echo "✅ PHP-CS-Fixer completed"

echo "Running Laravel Pint (dry-run)..."
./vendor/bin/pint --test --config=../pint.json --format=json > ../reports/laravel-pint-report.json 2>&1 || echo "Laravel Pint found issues - check report"
echo "✅ Laravel Pint completed"

echo "Running Psalm..."
./vendor/bin/psalm --config=../psalm.xml --output-format=json > ../reports/psalm-report.json 2>&1 || echo "Psalm found issues - check report"
echo "✅ Psalm completed"

cd ..

# JavaScript/TypeScript Tools
echo "📊 Running JavaScript/TypeScript Analysis Tools..."
echo "------------------------------------------------"

echo "Running ESLint..."
npx eslint "resources/js/**/*.{js,ts,jsx,tsx}" --format=json > reports/eslint-report.json 2>&1 || echo "ESLint found issues - check report"
echo "✅ ESLint completed"

echo "Running Prettier (check)..."
npx prettier --check "resources/**/*.{js,ts,jsx,tsx,css,scss,html,md}" --list-different > reports/prettier-report.txt 2>&1 || echo "Prettier found issues - check report"
echo "✅ Prettier completed"

# CSS Tools
echo "📊 Running CSS Analysis Tools..."
echo "--------------------------------"

echo "Running Stylelint..."
npx stylelint "resources/**/*.{css,scss}" --formatter=json > reports/stylelint-report.json 2>&1 || echo "Stylelint found issues - check report"
echo "✅ Stylelint completed"

# Markdown Tools
echo "📊 Running Markdown Analysis Tools..."
echo "------------------------------------"

echo "Running Markdownlint..."
npx markdownlint "**/*.md" --config=.markdownlint.json --format=json > reports/markdownlint-report.json 2>&1 || echo "Markdownlint found issues - check report"
echo "✅ Markdownlint completed"

# HTML Tools
echo "📊 Running HTML Analysis Tools..."
echo "--------------------------------"

echo "Running HTMLHint..."
npx htmlhint "resources/views/**/*.blade.php" --config=.htmlhintrc --format=json > reports/htmlhint-report.json 2>&1 || echo "HTMLHint found issues - check report"
echo "✅ HTMLHint completed"

# Generate Summary Report
echo "📋 Generating Summary Report..."
echo "=============================="

cat > reports/summary-report.md << EOF
# Code Quality Analysis Summary

**Generated:** $(date)
**Project:** FixCity Platform

## PHP Analysis
- **PHPStan:** $(if [ -f reports/phpstan-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)
- **PHPMD:** $(if [ -f reports/phpmd-report.xml ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)
- **PHP-CS-Fixer:** $(if [ -f reports/php-cs-fixer-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)
- **Laravel Pint:** $(if [ -f reports/laravel-pint-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)
- **Psalm:** $(if [ -f reports/psalm-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)

## JavaScript/TypeScript Analysis
- **ESLint:** $(if [ -f reports/eslint-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)
- **Prettier:** $(if [ -f reports/prettier-report.txt ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)

## CSS Analysis
- **Stylelint:** $(if [ -f reports/stylelint-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)

## Markdown Analysis
- **Markdownlint:** $(if [ -f reports/markdownlint-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)

## HTML Analysis
- **HTMLHint:** $(if [ -f reports/htmlhint-report.json ]; then echo "✅ Completed"; else echo "❌ Failed"; fi)

## Reports Location
All detailed reports are available in the \`reports/\` directory.

## Next Steps
1. Review individual reports for specific issues
2. Run \`scripts/fix-code-quality-issues.sh\` to auto-fix issues where possible
3. Address remaining issues manually
4. Re-run this script to verify fixes

EOF

echo "✅ Summary report generated: reports/summary-report.md"

echo ""
echo "🎉 Full Code Quality Analysis Complete!"
echo "======================================"
echo "📁 Reports saved in: reports/"
echo "📋 Summary: reports/summary-report.md"
echo ""
echo "Next steps:"
echo "1. Review reports for issues"
echo "2. Run fix script: ./scripts/fix-code-quality-issues.sh"
echo "3. Address remaining issues manually"
echo "4. Re-run this script to verify fixes"
