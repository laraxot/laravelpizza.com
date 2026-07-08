#!/bin/bash

# Script to update minimum-stability to "dev" in all composer.json files
# Excludes vendor directories

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
UPDATED_COUNT=0
ALREADY_SET_COUNT=0
ADDED_COUNT=0

echo "🔍 Searching for composer.json files (excluding vendor directories)..."

# Find all composer.json files excluding vendor directories
find "$PROJECT_ROOT" -name "composer.json" -not -path "*/vendor/*" | while read -r composer_file; do
    echo "📁 Processing: $composer_file"
    
    # Check if file exists and is readable
    if [[ ! -f "$composer_file" || ! -r "$composer_file" ]]; then
        echo "   ⚠️  File not readable, skipping..."
        continue
    fi
    
    # Create backup
    cp "$composer_file" "$composer_file.backup"
    
    # Check if minimum-stability exists
    if grep -q '"minimum-stability"' "$composer_file"; then
        # Check current value
        current_value=$(grep '"minimum-stability"' "$composer_file" | sed 's/.*"minimum-stability"[[:space:]]*:[[:space:]]*"\([^"]*\)".*/\1/')
        
        if [[ "$current_value" == "dev" ]]; then
            echo "   ✅ Already set to 'dev'"
            ((ALREADY_SET_COUNT++))
        else
            echo "   🔄 Updating from '$current_value' to 'dev'"
            # Update the value
            sed -i 's/"minimum-stability"[[:space:]]*:[[:space:]]*"[^"]*"/"minimum-stability": "dev"/g' "$composer_file"
            ((UPDATED_COUNT++))
        fi
    else
        echo "   ➕ Adding minimum-stability: dev"
        # Add minimum-stability after the opening brace
        sed -i '/{/a\    "minimum-stability": "dev",' "$composer_file"
        ((ADDED_COUNT++))
    fi
    
    # Remove backup if successful
    rm "$composer_file.backup"
done

echo ""
echo "📊 Summary:"
echo "   ✅ Already set to 'dev': $ALREADY_SET_COUNT files"
echo "   🔄 Updated to 'dev': $UPDATED_COUNT files" 
echo "   ➕ Added 'dev' setting: $ADDED_COUNT files"
echo ""
echo "✨ Done!"
