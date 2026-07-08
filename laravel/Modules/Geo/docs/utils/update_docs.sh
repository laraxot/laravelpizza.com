#!/bin/bash

# Documentation Update Script
# Helps maintain documentation consistency and track changes

# Configuration
DOCS_DIR="/var/www/html/base_<nome progetto>_fila5/docs"
LOG_FILE="$DOCS_DIR/documentation_update.log"

# Function to log documentation updates
log_update() {
    local file="$1"
    local action="$2"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $action: $file" >> "$LOG_FILE"
}

# Function to check documentation before changes
check_docs_before_change() {
    local topic="$1"
    local files=$(find "$DOCS_DIR" -type f -exec grep -l "$topic" {} \;)
    
    if [ -n "$files" ]; then
        echo "Existing documentation found for '$topic':"
        for file in $files; do
            echo "- $file"
            cat "$file"
            echo "---"
        done
    else
        echo "No existing documentation found for '$topic'. Consider creating a new document."
    fi
}

# Function to update documentation
update_documentation() {
    local file="$1"
    local content="$2"
    
    echo "$content" > "$file"
    log_update "$file" "Updated"
}

# Main script
case "$1" in
    "check")
        check_docs_before_change "$2"
        ;;
    "update")
        update_documentation "$2" "$3"
        ;;
    *)
        echo "Usage: $0 {check <topic>|update <file> <content>}"
        exit 1
        ;;
esac
