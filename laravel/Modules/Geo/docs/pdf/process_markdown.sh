#!/bin/bash

# Activate virtual environment
source venv/bin/activate

# Install required Python packages
pip install -r requirements.txt

# Install Mermaid CLI for SVG generation
if ! command -v mmdc &> /dev/null; then
    echo "Installazione di Mermaid CLI..."
    npm install -g @mermaid-js/mermaid-cli
fi

# Create a backup of the original file
cp test.md test_original_backup.md

# Run the processing script
python process_markdown.py test.md test_processed.md

# Replace the original with the processed version
mv test_processed.md test.md

echo "Elaborazione completata. File originale salvato come test_original_backup.md"

# Show the first 50 lines of the processed file
echo -e "\n=== Prime 50 righe del file elaborato ===\n"
head -n 50 test.md
