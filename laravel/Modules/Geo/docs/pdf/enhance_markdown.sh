#!/bin/bash

# Activate virtual environment
source venv/bin/activate

# Install required Python packages
pip install -r requirements.txt

# Create a backup of the original file
cp test.md test_original_backup.md

# Run the enhancement script
python enhance_markdown.py test.md test_enhanced.md

# Replace the original with the enhanced version
mv test_enhanced.md test.md

echo "Markdown enhancement complete. Original file backed up as test_original_backup.md"

# Show the first 50 lines of the enhanced file
echo -e "\n=== First 50 lines of enhanced file ===\n"
head -n 50 test.md
