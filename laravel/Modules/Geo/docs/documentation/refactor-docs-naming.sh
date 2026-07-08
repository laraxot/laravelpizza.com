#!/bin/bash
#
# This script refactors file and directory names to enforce naming conventions:
# - All lowercase
# - Underscores replaced with hyphens
# - Ignores 'README.md'

set -e

TARGET_DIR=$1

if [ -z "$TARGET_DIR" ]; then
    echo "Usage: $0 <directory>"
    exit 1
fi

if [ ! -d "$TARGET_DIR" ]; then
    echo "Error: Directory '$TARGET_DIR' not found."
    exit 1
fi

echo "Refactoring names in: $TARGET_DIR"

# Find all directories and files, deepest first, and rename them
find "$TARGET_DIR" -depth | while read -r path; do
    # Get the base name (file or directory name)
    base_name=$(basename "$path")
    dir_name=$(dirname "$path")

    # Skip README.md
    if [ "$base_name" = "README.md" ]; then
        continue
    fi

    # Convert to lowercase and replace underscores with hyphens
    new_base_name=$(echo "$base_name" | tr '[:upper:]' '[:lower:]' | tr '_' '-')

    # If the name has changed, rename it
    if [ "$base_name" != "$new_base_name" ]; then
        new_path="$dir_name/$new_base_name"
        if [ -e "$new_path" ]; then
            echo "Warning: Target '$new_path' already exists. Skipping rename for '$path'."
        else
            echo "Renaming '$path' to '$new_path'"
            mv "$path" "$new_path"
        fi
    fi
done

echo "Refactoring complete for: $TARGET_DIR"
