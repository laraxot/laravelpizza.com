#!/bin/bash

# Check if a file path was provided
if [ -z "$1" ]; then
    echo "Error: No file path provided."
    echo "Usage: ./fix_errors.sh <file_path>"
    exit 1
fi

FILE_PATH="$1"

# Check if the file exists
if [ ! -f "$FILE_PATH" ]; then
    echo "Error: File '$FILE_PATH' does not exist."
    exit 1
fi

# Get the file content
FILE_CONTENT=$(cat "$FILE_PATH")

# Create a temporary file for the prompt
TEMP_PROMPT=$(mktemp)

# Write the prompt to the temporary file
cat > "$TEMP_PROMPT" << EOL
Please analyze the following code and fix any errors or issues you find.
Return only the corrected code without explanations.

\`\`\`
$FILE_CONTENT
\`\`\`
EOL

# Call Ollama with the prompt
echo "Analyzing and fixing errors in '$FILE_PATH'..."
FIXED_CODE=$(ollama run codellama "$(<$TEMP_PROMPT)")

# Extract just the code part from the response (between triple backticks)
FIXED_CODE=$(echo "$FIXED_CODE" | sed -n '/```/,/```/p' | sed '1d;$d')

# Create a backup of the original file
cp "$FILE_PATH" "${FILE_PATH}.bak"

# Write the fixed code to the original file
echo "$FIXED_CODE" > "$FILE_PATH"

# Clean up
rm "$TEMP_PROMPT"

echo "Done! Original file backed up as '${FILE_PATH}.bak'"