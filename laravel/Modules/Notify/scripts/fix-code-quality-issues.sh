#!/bin/bash

# Fix Code Quality Issues Script
# Automatically fixes issues where possible using code quality tools

set -e

echo "🔧 Fixing Code Quality Issues..."
echo "================================"

# PHP Tools
echo "🔧 Running PHP Fix Tools..."
echo "---------------------------"

echo "Running PHP-CS-Fixer to fix code style..."
cd laravel
./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php || echo "PHP-CS-Fixer encountered issues"
echo "✅ PHP-CS-Fixer completed"

echo "Running Laravel Pint to fix code style..."
./vendor/bin/pint --config=pint.json || echo "Laravel Pint encountered issues"
echo "✅ Laravel Pint completed"

cd ..

# JavaScript/TypeScript Tools
echo "🔧 Running JavaScript/TypeScript Fix Tools..."
echo "--------------------------------------------"

echo "Running Prettier to fix formatting..."
npx prettier --write "resources/**/*.{js,ts,jsx,tsx,css,scss,html,md}" || echo "Prettier encountered issues"
echo "✅ Prettier completed"

echo "Running ESLint to fix issues..."
npx eslint "resources/js/**/*.{js,ts,jsx,tsx}" --fix || echo "ESLint encountered issues"
echo "✅ ESLint completed"

# CSS Tools
echo "🔧 Running CSS Fix Tools..."
echo "---------------------------"

echo "Running Stylelint to fix CSS issues..."
npx stylelint "resources/**/*.{css,scss}" --fix || echo "Stylelint encountered issues"
echo "✅ Stylelint completed"

# Markdown Tools
echo "🔧 Running Markdown Fix Tools..."
echo "-------------------------------"

echo "Running Markdownlint to fix markdown issues..."
npx markdownlint "**/*.md" --config=.markdownlint.json --fix || echo "Markdownlint encountered issues"
echo "✅ Markdownlint completed"

echo ""
echo "🎉 Code Quality Fixes Complete!"
echo "=============================="
echo ""
echo "Next steps:"
echo "1. Review the changes made"
echo "2. Run tests to ensure nothing is broken"
echo "3. Run ./scripts/full-code-quality-check.sh to verify fixes"
echo "4. Address any remaining issues manually"
echo ""
echo "Note: Some issues may require manual intervention."
echo "Check the output above for any error messages."










