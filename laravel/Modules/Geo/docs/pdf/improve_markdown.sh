#!/bin/bash

# Activate virtual environment
source venv/bin/activate

# Install required Python packages
pip install -r requirements.txt

# Run the improvement script
python improve_markdown.py test.md improved_test.md

# Create a backup of the original file
cp test.md test_original_backup.md

# Replace the original with the improved version
mv improved_test.md test.md

echo "Markdown improvement complete. Original file backed up as test_original_backup.md"

# Show the first 50 lines of the improved file
echo -e "\n=== First 50 lines of improved file ===\n"
head -n 50 test.md
