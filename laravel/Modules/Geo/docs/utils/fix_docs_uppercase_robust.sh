#!/bin/bash

# Robust script to fix docs naming convention
# CRITICAL RULE: In docs directories, only README.md can have uppercase letters
# All other files and folders must be lowercase

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
RENAMED_COUNT=0
SKIPPED_COUNT=0
ERROR_COUNT=0

echo "🔍 CRITICAL RULE: Robustly fixing docs naming convention..."
echo "   - Only README.md can have uppercase letters"
echo "   - All other files and folders must be lowercase"
echo ""

# Function to safely rename a file/directory
safe_rename() {
    local source="$1"
    local target="$2"
    
    # Skip if source doesn't exist
    if [[ ! -e "$source" ]]; then
        return 1
    fi
    
    # Skip if target is the same as source
    if [[ "$source" == "$target" ]]; then
        return 0
    fi
    
    # If target exists and is different from source, handle conflict
    if [[ -e "$target" ]]; then
        echo "   ⚠️  Conflict: $target already exists"
        # Try with a temporary suffix
        local temp_target="${target}.tmp_rename"
        if mv "$source" "$temp_target" 2>/dev/null; then
            if mv "$temp_target" "$target" 2>/dev/null; then
                echo "   ✅ Resolved conflict and renamed: $(basename "$source") → $(basename "$target")"
                return 0
            else
                # Restore original if second move failed
                mv "$temp_target" "$source" 2>/dev/null
                return 1
            fi
        else
            return 1
        fi
    else
        # Direct rename
        if mv "$source" "$target" 2>/dev/null; then
            return 0
        else
            return 1
        fi
    fi
}

# Get all files and directories in docs that have uppercase letters (except README.md)
echo "🔍 Finding all uppercase items in docs directories..."

find "$PROJECT_ROOT" -path "*/docs/*" -not -path "*/vendor/*" -not -path "*/node_modules/*" \
    \( -type f -o -type d \) -name "*[A-Z]*" ! -name "README.md" | sort -r | while read -r item; do
    
    # Get the directory and basename
    dirname_item=$(dirname "$item")
    basename_item=$(basename "$item")
    
    # Convert to lowercase
    lowercase_name=$(echo "$basename_item" | tr '[:upper:]' '[:lower:]')
    new_path="$dirname_item/$lowercase_name"
    
    echo "📁 Processing: $item"
    echo "   → Target: $new_path"
    
    if safe_rename "$item" "$new_path"; then
        echo "   ✅ Successfully renamed: $basename_item → $lowercase_name"
        ((RENAMED_COUNT++))
    else
        echo "   ❌ Failed to rename: $item"
        ((ERROR_COUNT++))
    fi
    echo ""
done

echo "📊 Summary:"
echo "   🔄 Renamed items: $RENAMED_COUNT"
echo "   ❌ Errors: $ERROR_COUNT"
echo ""

# Final verification
echo "🔍 Final verification: Checking for any remaining uppercase names..."
remaining_count=0
find "$PROJECT_ROOT" -path "*/docs/*" -not -path "*/vendor/*" -not -path "*/node_modules/*" \
    \( -type f -o -type d \) -name "*[A-Z]*" ! -name "README.md" | while read -r item; do
    echo "   ⚠️  Still has uppercase: $item"
    ((remaining_count++))
done

if [[ $remaining_count -eq 0 ]]; then
    echo "✅ SUCCESS: All docs files and folders now follow the naming convention!"
else
    echo "⚠️  WARNING: $remaining_count items still need manual attention"
fi

echo ""
echo "✨ Docs naming convention fix completed!"
