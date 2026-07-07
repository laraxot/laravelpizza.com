#!/bin/bash
# Load BMAD project configuration
# Usage: source load-config.sh or ./load-config.sh

CONFIG_FILE="bmad/config.yaml"

if [ ! -f "$CONFIG_FILE" ]; then
    echo "ERROR: BMAD not initialized. Run /workflow-init first."
    exit 1
fi

# Extract values using grep/sed (portable, no yq dependency)
extract_yaml_value() {
    local key=$1
    local file=$2
    grep "^[[:space:]]*${key}:" "$file" 2>/dev/null | head -1 | sed 's/.*:[[:space:]]*//' | tr -d '"'
}

# Extract nested values
extract_nested_value() {
    local parent=$1
    local key=$2
    local file=$3
    awk -v parent="$parent" -v key="$key" '
        $0 ~ parent":" { in_section=1 }
        in_section && $0 ~ "^[[:space:]]+"key":" {
            gsub(/.*:[[:space:]]*/, "")
            gsub(/"/, "")
            print
            exit
        }
        in_section && /^[a-z]/ && $0 !~ parent { exit }
    ' "$file"
}

# Load configuration
PROJECT_NAME=$(extract_nested_value "project" "name" "$CONFIG_FILE")
PROJECT_TYPE=$(extract_nested_value "project" "type" "$CONFIG_FILE")
PROJECT_LEVEL=$(extract_nested_value "project" "level" "$CONFIG_FILE")
OUTPUT_FOLDER=$(extract_nested_value "paths" "output_folder" "$CONFIG_FILE")
STATUS_FILE=$(extract_nested_value "paths" "status_file" "$CONFIG_FILE")

# Set defaults
OUTPUT_FOLDER=${OUTPUT_FOLDER:-docs}
STATUS_FILE=${STATUS_FILE:-docs/bmm-workflow-status.yaml}

# Output as environment variables or JSON
if [ "$1" = "--json" ]; then
    cat <<EOF
{
  "project_name": "$PROJECT_NAME",
  "project_type": "$PROJECT_TYPE",
  "project_level": $PROJECT_LEVEL,
  "output_folder": "$OUTPUT_FOLDER",
  "status_file": "$STATUS_FILE"
}
EOF
elif [ "$1" = "--export" ]; then
    echo "export BMAD_PROJECT_NAME=\"$PROJECT_NAME\""
    echo "export BMAD_PROJECT_TYPE=\"$PROJECT_TYPE\""
    echo "export BMAD_PROJECT_LEVEL=$PROJECT_LEVEL"
    echo "export BMAD_OUTPUT_FOLDER=\"$OUTPUT_FOLDER\""
    echo "export BMAD_STATUS_FILE=\"$STATUS_FILE\""
else
    echo "Project: $PROJECT_NAME"
    echo "Type: $PROJECT_TYPE"
    echo "Level: $PROJECT_LEVEL"
    echo "Output: $OUTPUT_FOLDER"
    echo "Status: $STATUS_FILE"
fi
