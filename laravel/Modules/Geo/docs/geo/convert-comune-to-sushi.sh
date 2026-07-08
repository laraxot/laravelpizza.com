#!/bin/bash

# Script to convert Comune data to individual JSON files for Sushi
# Usage: ./convert-comune-to-sushi.sh

set -e

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$SCRIPT_DIR/../.."
MODULE_DIR="$ROOT_DIR/laravel/Modules/Geo"
DATA_DIR="$MODULE_DIR/database/content"
OUTPUT_DIR="$DATA_DIR/comuni"
INPUT_FILE="$DATA_DIR/comuni.json"

# Create output directory if it doesn't exist
mkdir -p "$OUTPUT_DIR"

echo "Converting Comune data to Sushi format..."

# Check if input file exists
if [ ! -f "$INPUT_FILE" ]; then
    echo "Error: Input file $INPUT_FILE not found!"
    exit 1
fi

# Process the JSON file
jq -c '.[]' "$INPUT_FILE" | while read -r comune; do
    # Extract the ID from the comune data
    id=$(echo "$comune" | jq -r '.id // .codice // .codice_istat // .istat_code // empty')
    
    # Skip if no valid ID found
    if [ -z "$id" ]; then
        echo "Warning: Skipping entry with no valid ID: $comune"
        continue
    fi
    
    # Save as individual JSON file
    output_file="${OUTPUT_DIR}/${id}.json"
    echo "$comune" > "$output_file"
    
    # Make sure the file was created
    if [ ! -f "$output_file" ]; then
        echo "Error: Failed to create $output_file"
        exit 1
    fi
    
    echo "Created: $output_file"
done

echo "Conversion completed successfully!"
echo "Output directory: $OUTPUT_DIR"
echo "Total files created: $(ls -1 "$OUTPUT_DIR" | wc -l)"
