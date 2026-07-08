#!/bin/bash

# Script to properly set minimum-stability to "dev" in all composer.json files
# Uses jq for proper JSON manipulation

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
UPDATED_COUNT=0
ALREADY_SET_COUNT=0
ADDED_COUNT=0
FIXED_COUNT=0

echo "🔍 Searching for composer.json files (excluding vendor directories)..."

# Check if jq is available
if ! command -v jq >/dev/null 2>&1; then
    echo "❌ jq is required but not installed. Installing..."
    apt-get update && apt-get install -y jq
fi

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
    
    # Check if the file is valid JSON
    if ! jq empty "$composer_file" 2>/dev/null; then
        echo "   🔧 Invalid JSON detected, attempting to fix..."
        
        # Try to fix common JSON issues
        # Remove duplicate minimum-stability lines
        grep -v '"minimum-stability"' "$composer_file" > "$composer_file.tmp"
        mv "$composer_file.tmp" "$composer_file"
        
        # Add proper minimum-stability
        jq '. + {"minimum-stability": "dev"}' "$composer_file.backup" > "$composer_file" 2>/dev/null || {
            echo "   ❌ Could not fix JSON, restoring backup"
            mv "$composer_file.backup" "$composer_file"
            continue
        }
        ((FIXED_COUNT++))
    else
        # File is valid JSON, check minimum-stability
        current_stability=$(jq -r '.["minimum-stability"] // empty' "$composer_file")
        
        if [[ -z "$current_stability" ]]; then
            echo "   ➕ Adding minimum-stability: dev"
            jq '. + {"minimum-stability": "dev"}' "$composer_file" > "$composer_file.tmp"
            mv "$composer_file.tmp" "$composer_file"
            ((ADDED_COUNT++))
        elif [[ "$current_stability" == "dev" ]]; then
            echo "   ✅ Already set to 'dev'"
            ((ALREADY_SET_COUNT++))
        else
            echo "   🔄 Updating from '$current_stability' to 'dev'"
            jq '.["minimum-stability"] = "dev"' "$composer_file" > "$composer_file.tmp"
            mv "$composer_file.tmp" "$composer_file"
            ((UPDATED_COUNT++))
        fi
    fi
    
    # Verify the result is valid JSON
    if jq empty "$composer_file" 2>/dev/null; then
        rm "$composer_file.backup"
        echo "   ✅ File processed successfully"
    else
        echo "   ❌ Result is invalid JSON, restoring backup"
        mv "$composer_file.backup" "$composer_file"
    fi
done

echo ""
echo "📊 Summary:"
echo "   ✅ Already set to 'dev': $ALREADY_SET_COUNT files"
echo "   🔄 Updated to 'dev': $UPDATED_COUNT files" 
echo "   ➕ Added 'dev' setting: $ADDED_COUNT files"
echo "   🔧 Fixed malformed JSON: $FIXED_COUNT files"
echo ""
echo "✨ Done!"
