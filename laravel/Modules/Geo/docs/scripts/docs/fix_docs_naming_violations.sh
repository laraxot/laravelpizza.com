#!/bin/bash

# Script to fix all docs naming convention violations
# All files and folders in docs/ must be lowercase except README.md

set -e

echo "🔍 Fixing docs naming convention violations..."

# Navigate to the base directory
cd /var/www/html/_bases/base_ptvx

# Function to rename files with uppercase letters to lowercase
fix_docs_naming() {
    local docs_dir="$1"
    
    if [ ! -d "$docs_dir" ]; then
        echo "⚠️  Directory $docs_dir does not exist, skipping..."
        return
    fi
    
    echo "📁 Processing: $docs_dir"
    
    # Find all files and directories with uppercase letters (except README.md)
    find "$docs_dir" -depth -name "*[A-Z]*" ! -name "README.md" | while read -r item; do
        if [ -e "$item" ]; then
            # Get the directory and filename
            dir=$(dirname "$item")
            filename=$(basename "$item")
            
            # Convert to lowercase with hyphens instead of underscores for better readability
            new_filename=$(echo "$filename" | tr '[:upper:]' '[:lower:]' | sed 's/_/-/g')
            new_path="$dir/$new_filename"
            
            if [ "$item" != "$new_path" ]; then
                echo "  📝 Renaming: $item -> $new_path"
                mv "$item" "$new_path"
            fi
        fi
    done
}

# Fix all docs directories
echo "🎯 Fixing main docs directory..."
fix_docs_naming "docs"

echo "🎯 Fixing laravel docs directory..."
fix_docs_naming "laravel/docs"

echo "🎯 Fixing module docs directories..."
for module_dir in laravel/Modules/*/docs; do
    if [ -d "$module_dir" ]; then
        fix_docs_naming "$module_dir"
    fi
done

echo "🎯 Fixing theme docs directories..."
for theme_dir in laravel/Themes/*/docs; do
    if [ -d "$theme_dir" ]; then
        fix_docs_naming "$theme_dir"
    fi
done

echo "✅ All docs naming convention violations have been fixed!"
echo "📋 Summary: All files and folders in docs/ are now lowercase (except README.md)"
