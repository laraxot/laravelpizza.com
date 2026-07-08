#!/bin/bash

# PHPInsights Standalone Wrapper for PTVX Project
# Usage: ./phpinsights-standalone.sh [module_name] [options]

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHPINSIGHTS_BIN="$SCRIPT_DIR/phpinsights-standalone"

# Check if binary exists
if [ ! -f "$PHPINSIGHTS_BIN" ]; then
    echo "Error: PHPInsights standalone not found at $PHPINSIGHTS_BIN"
    echo "Please ensure phpinsights-standalone exists in laravel/ directory"
    exit 1
fi

# Function to analyze a specific module
analyze_module() {
    local module="$1"
    local options="$2"
    
    echo "🔍 Analyzing module: $module"
    echo "=================================="
    
    if [ ! -d "$SCRIPT_DIR/Modules/$module" ]; then
        echo "❌ Module '$module' not found"
        return 1
    fi
    
    cd "$SCRIPT_DIR"
    "$PHPINSIGHTS_BIN" analyse --no-interaction --disable-security-check --composer=./composer.lock $options "Modules/$module"
}

# Function to analyze all modules
analyze_all() {
    local options="$1"
    
    echo "🔍 Analyzing all modules"
    echo "======================="
    
    for dir in "$SCRIPT_DIR"/Modules/*/; do
        if [ -d "$dir" ]; then
            module=$(basename "$dir")
            analyze_module "$module" "$options --summary"
            echo ""
        fi
    done
}

# Parse command line arguments
if [ $# -eq 0 ]; then
    echo "Usage: $0 [module_name|all] [phpinsights_options]"
    echo ""
    echo "Examples:"
    echo "  $0 Xot                    # Analyze Xot module"
    echo "  $0 Xot --min-quality=80   # Analyze with minimum quality"
    echo "  $0 all --summary          # Analyze all modules with summary"
    echo ""
    echo "Available modules:"
    for dir in "$SCRIPT_DIR"/Modules/*/; do
        if [ -d "$dir" ]; then
            echo "  - $(basename "$dir")"
        fi
    done
    exit 0
fi

MODULE="$1"
shift
OPTIONS="$@"

if [ "$MODULE" = "all" ]; then
    analyze_all "$OPTIONS"
else
    analyze_module "$MODULE" "$OPTIONS"
fi