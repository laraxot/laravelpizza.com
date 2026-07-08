#!/bin/bash

# Activate virtual environment
source venv/bin/activate

# Install required Python packages
pip install -r requirements.txt

# Create a backup of the original file
cp test.md test_original_backup.md

# Run the fix script
python fix_markdown.py test.md test_fixed.md

# Replace the original with the fixed version
mv test_fixed.md test.md

echo "Markdown fix complete. Original file backed up as test_original_backup.md"

# Show the first 50 lines of the fixed file
echo -e "\n=== First 50 lines of fixed file ===\n"
head -n 50 test.md
