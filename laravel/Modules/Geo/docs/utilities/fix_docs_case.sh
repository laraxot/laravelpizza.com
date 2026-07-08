#!/bin/bash

# Script to enforce lowercase naming convention in docs folders
# Excludes README.md files

find . -type d -name "docs" -print0 | while IFS= read -r -d '' docs_dir; do
    # Process files
    find "$docs_dir" -type f ! -name "README.md" -print0 | while IFS= read -r -d '' file; do
        filename=$(basename "$file")
        dirname=$(dirname "$file")
        lowercase_name=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
        
        if [ "$filename" != "$lowercase_name" ]; then
            echo "Converting file: $file to lowercase"
            mv "$file" "$dirname/$lowercase_name"
        fi
    done

    # Process directories (excluding the docs directory itself)
    find "$docs_dir" -type d ! -name "docs" -print0 | while IFS= read -r -d '' dir; do
        dirname=$(basename "$dir")
        parentdir=$(dirname "$dir")
        lowercase_name=$(echo "$dirname" | tr '[:upper:]' '[:lower:]')
        
        if [ "$dirname" != "$lowercase_name" ]; then
            echo "Converting directory: $dir to lowercase"
            mv "$dir" "$parentdir/$lowercase_name"
        fi
    done
done
