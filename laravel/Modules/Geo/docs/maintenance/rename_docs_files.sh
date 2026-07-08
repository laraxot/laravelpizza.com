#!/bin/bash

# This script renames all files in the docs directory to lowercase, except for README.md

find /var/www/html/YOUR_PROJECT/docs -type f -name "*[A-Z]*" | grep -v "README\.md" | while read file; do
  dir=$(dirname "$file")
  filename=$(basename "$file")
  lowercase_filename=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
  
  if [ "$filename" != "$lowercase_filename" ]; then
    echo "Renaming $file to $dir/$lowercase_filename"
    mv "$file" "$dir/$lowercase_filename"
  fi
done

echo "All files in docs have been renamed to lowercase (except README.md files)"
