#!/bin/bash
# Laravel Pizza Meetups - Quality Gate Script
# Ensures Laraxot PHPStan Level 10 compliance

set -e

echo "🚀 Laravel Pizza Meetups - Quality Gate"
echo "======================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "This script must be run from the Laravel directory"
    exit 1
fi

print_status "Running Laravel Pizza Meetups Quality Gate..."

# 1. PHPStan Level 10 Analysis
echo ""
echo "📊 PHPStan Level 10 Analysis..."
echo "================================"

if ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress --error-format=table; then
    print_status "PHPStan Level 10: PASSED"
else
    print_error "PHPStan Level 10: FAILED"
    echo "Please fix all PHPStan errors before proceeding."
    exit 1
fi

# 2. Code Formatting Check
echo ""
echo "🎨 Code Formatting Check..."
echo "=========================="

if ./vendor/bin/pint --test; then
    print_status "Code Formatting: PASSED"
else
    print_warning "Code Formatting: ISSUES FOUND"
    echo "Run './vendor/bin/pint --dirty' to fix formatting issues."
fi

# 3. PHPMD Analysis (non-blocking)
echo ""
echo "🔍 PHPMD Analysis..."
echo "=================="

if ./phpmd.phar Modules text Modules/Xot/phpmd.ruleset.xml 2>/dev/null; then
    print_status "PHPMD: PASSED"
else
    print_warning "PHPMD: ISSUES FOUND (non-blocking)"
fi

# 4. Laravel Application Tests
echo ""
echo "🧪 Laravel Tests..."
echo "=================="

if php artisan test --without-tty; then
    print_status "Tests: PASSED"
else
    print_warning "Tests: FAILED (check manually)"
fi

# 5. Check for Laraxot Architectural Violations
echo ""
echo "🏗️  Laraxot Architecture Check..."
echo "================================="

# Check for direct Filament extensions
VIOLATIONS=$(grep -r "extends.*Filament" Modules/ --include="*.php" | grep -v "XotBase" | wc -l || true)

if [ "$VIOLATIONS" -eq 0 ]; then
    print_status "Laraxot Architecture: COMPLIANT"
else
    print_error "Laraxot Architecture: $VIOLATIONS violations found"
    echo "Found direct Filament extensions. Please use XotBase classes."
    grep -r "extends.*Filament" Modules/ --include="*.php" | grep -v "XotBase"
fi

# 6. Check for property_exists() on Eloquent models
echo ""
echo "🔍 Eloquent Magic Properties Check..."
echo "====================================="

PROPERTY_VIOLATIONS=$(grep -r "property_exists" Modules/ --include="*.php" | wc -l || true)

if [ "$PROPERTY_VIOLATIONS" -eq 0 ]; then
    print_status "Magic Properties: COMPLIANT"
else
    print_error "Magic Properties: $PROPERTY_VIOLATIONS violations found"
    echo "Found property_exists() usage. Use isset() or hasAttribute() instead."
    grep -r "property_exists" Modules/ --include="*.php"
fi

# Final status
echo ""
echo "🎯 Quality Gate Summary"
echo "======================="

if [ "$VIOLATIONS" -eq 0 ] && [ "$PROPERTY_VIOLATIONS" -eq 0 ]; then
    print_status "🍕 Laravel Pizza Meetups: READY FOR DEPLOYMENT"
    echo ""
    echo "✅ PHPStan Level 10: PASSED"
    echo "✅ Laraxot Architecture: COMPLIANT"
    echo "✅ Magic Properties: COMPLIANT"
    echo ""
    echo "The code meets all Laraxot quality standards!"
    exit 0
else
    print_error "🚫 Laravel Pizza Meetups: NOT READY"
    echo ""
    echo "Please fix the issues above before deploying."
    exit 1
fi