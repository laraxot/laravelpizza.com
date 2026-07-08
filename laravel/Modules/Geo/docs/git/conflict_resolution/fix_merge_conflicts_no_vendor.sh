#!/bin/bash

# Script to automatically resolve git merge conflicts by keeping the current version (HEAD)
# This version excludes vendor directories
# Author: Cascade
# Date: 2025-09-22
# Version: 1.0.0

set -euo pipefail

# Colors for better output
readonly RED='\033[0;31m'
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly BLUE='\033[0;34m'
readonly PURPLE='\033[0;35m'
readonly CYAN='\033[0;36m'
readonly NC='\033[0m' # No Color

# Script configuration
readonly SCRIPT_NAME="Git Conflict Auto-Resolver (No Vendor)"
readonly SCRIPT_VERSION="1.0.0"
readonly BACKUP_PREFIX="conflict_backup"

# Supported file extensions
readonly SUPPORTED_EXTENSIONS=(
    "*.php"
    "*.md" 
    "*.txt"
    "*.json"
    "*.blade.php"
    "*.js"
    "*.ts"
    "*.vue"
    "*.css"
    "*.scss"
    "*.yaml"
    "*.yml"
    "*.xml"
    "*.html"
    "*.sql"
    "*.sh"
)

# Excluded directories
readonly EXCLUDED_DIRS=(
    "vendor"
    "node_modules"
    ".git"
    "storage/logs"
    "storage/framework"
    "public/storage"
    ".tmp"
    "tmp"
)

# Function to display script header
show_header() {
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║          ${SCRIPT_NAME}          ║${NC}"
    echo -e "${CYAN}║                    Version ${SCRIPT_VERSION}                     ║${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    echo ""
}

# Function to log messages with timestamp
log_message() {
    local level="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    
    case "$level" in
        "INFO")
            echo -e "${BLUE}[${timestamp}] INFO: ${message}${NC}"
            ;;
        "SUCCESS")
            echo -e "${GREEN}[${timestamp}] SUCCESS: ${message}${NC}"
            ;;
        "WARNING")
            echo -e "${YELLOW}[${timestamp}] WARNING: ${message}${NC}"
            ;;
        "ERROR")
            echo -e "${RED}[${timestamp}] ERROR: ${message}${NC}"
            ;;
        "PROCESSING")
            echo -e "${PURPLE}[${timestamp}] PROCESSING: ${message}${NC}"
            ;;
    esac
}

# Function to check if a file should be processed
should_process_file() {
    local file="$1"
    
    # Check if file matches any supported extension
    local is_supported=0
    for ext in "${SUPPORTED_EXTENSIONS[@]}"; do
        # Remove the * from the extension pattern
        local pattern=${ext#\*}
        if [[ "$file" == *"$pattern" ]]; then
            is_supported=1
            break
        fi
    done
    
    if [ $is_supported -eq 0 ]; then
        return 1
    fi
    
    # Check if file is in excluded directory
    for dir in "${EXCLUDED_DIRS[@]}"; do
        if [[ "$file" == *"/$dir/"* ]]; then
            return 1
        fi
    done
    
    return 0
}

# Function to find conflicted files
find_conflicted_files() {
    # Use find and grep to locate files with conflict markers
    # Explicitly exclude vendor directories
    find . -type f \( -name "*.php" -o -name "*.md" -o -name "*.json" -o -name "*.blade.php" \
        -o -name "*.js" -o -name "*.ts" -o -name "*.vue" -o -name "*.css" -o -name "*.scss" \
        -o -name "*.yaml" -o -name "*.yml" -o -name "*.xml" -o -name "*.html" -o -name "*.sql" \
        -o -name "*.sh" -o -name "*.txt" \) \
        -not -path "*/vendor/*" \
        -not -path "*/node_modules/*" \
        -not -path "*/.git/*" \
        -not -path "*/storage/logs/*" \
        -not -path "*/storage/framework/*" \
        -not -path "*/public/storage/*" \
        -not -path "*/.tmp/*" \
        -not -path "*/tmp/*" \
        -exec grep -l -E "(<<git marker>|=======|>>>>>>> )" {} \; 2>/dev/null || true
}

# Function to validate a file after resolution
validate_file() {
    local file="$1"
    
    # For PHP files, check syntax
    if [[ "$file" == *.php ]]; then
        if ! php -l "$file" > /dev/null 2>&1; then
            return 1
        fi
    fi
    
    # For JSON files, check if valid JSON
    if [[ "$file" == *.json ]]; then
        if command -v jq &> /dev/null; then
            if ! jq empty "$file" > /dev/null 2>&1; then
                return 1
            fi
        fi
    fi
    
    return 0
}

# Function to resolve conflicts in a single file
resolve_file_conflicts() {
    local file="$1"
    local backup_dir="$2"
    
    log_message "PROCESSING" "Resolving conflicts in: $file"
    
    # Create backup
    local backup_file="${backup_dir}/$(echo "$file" | sed 's/^\.\///' | tr '/' '_')"
    cp "$file" "$backup_file"
    
    # Create temp file
    local temp_file="${file}.resolving"
    
    # Process the file to keep the current version (HEAD)
    awk '
    BEGIN { in_conflict = 0 }
    /^<<<<<git marker>/ { 
        in_conflict = 1
        next 
    }
    /^=======/ { 
        if (in_conflict == 1) {
            in_conflict = 2
        }
        next 
    }
    /^>>>>>>> / { 
        in_conflict = 0
        next 
    }
    {
        if (in_conflict == 1 || in_conflict == 0) {
            print
        }
    }
    ' "$file" > "$temp_file"
    
    # Clean up excessive blank lines (more than 2 consecutive)
    sed -i '/^$/N;/^\n$/d' "$temp_file" 2>/dev/null || true
    
    # Validate the resolved file
    if validate_file "$temp_file"; then
        mv "$temp_file" "$file"
        log_message "SUCCESS" "Conflicts resolved successfully in: $file"
        return 0
    else
        log_message "ERROR" "File validation failed after resolution: $file"
        log_message "WARNING" "Restoring from backup: $backup_file"
        cp "$backup_file" "$file"
        rm -f "$temp_file"
        return 1
    fi
}

# Function to verify no conflicts remain
verify_no_conflicts() {
    log_message "INFO" "Performing final verification..."
    
    local remaining_conflicts=$(find_conflicted_files)
    
    if [ -z "$remaining_conflicts" ]; then
        log_message "SUCCESS" "All conflict markers successfully removed!"
        return 0
    else
        log_message "WARNING" "Some conflict markers might still exist in:"
        echo "$remaining_conflicts" | while read -r file; do
            echo -e "  ${YELLOW}• $file${NC}"
        done
        return 1
    fi
}

# Function to generate summary report
generate_summary() {
    local total_files="$1"
    local resolved_files="$2"
    local failed_files="$3"
    local backup_dir="$4"
    
    echo ""
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                    RESOLUTION SUMMARY                    ║${NC}"
    echo -e "${CYAN}╠══════════════════════════════════════════════════════════╣${NC}"
    echo -e "${CYAN}║${NC} Total files found: ${YELLOW}$total_files${NC}"
    echo -e "${CYAN}║${NC} Successfully resolved: ${GREEN}$resolved_files${NC}"
    echo -e "${CYAN}║${NC} Failed to resolve: ${RED}$failed_files${NC}"
    echo -e "${CYAN}║${NC} Backup directory: ${BLUE}$backup_dir${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
}

# Main function
main() {
    show_header
    
    # Determine working directory
    local script_dir="$(dirname "$(readlink -f "$0")")"
    local laravel_dir="$script_dir/laravel"
    
    if [ ! -d "$laravel_dir" ]; then
        laravel_dir="$script_dir/../laravel"
        if [ ! -d "$laravel_dir" ]; then
            log_message "ERROR" "Laravel directory not found"
            log_message "INFO" "Using current directory as working directory"
            laravel_dir="."
        fi
    fi
    
    cd "$laravel_dir" || exit 1
    log_message "INFO" "Working directory: $(pwd)"
    
    # Find conflicted files
    log_message "INFO" "Searching for files with git conflict markers..."
    local conflicted_files
    conflicted_files=$(find_conflicted_files)
    
    if [ -z "$conflicted_files" ]; then
        log_message "SUCCESS" "No conflict markers found!"
        exit 0
    fi
    
    # Count files
    local total_files
    total_files=$(echo "$conflicted_files" | wc -l)
    log_message "INFO" "Found $total_files files with conflict markers"
    
    # Create backup directory
    local backup_dir="${BACKUP_PREFIX}_$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$backup_dir"
    log_message "INFO" "Created backup directory: $backup_dir"
    
    # Process each file
    local resolved_files=0
    local failed_files=0
    
    echo "$conflicted_files" | while IFS= read -r file; do
        if [ -n "$file" ]; then
            if resolve_file_conflicts "$file" "$backup_dir"; then
                ((resolved_files++))
            else
                ((failed_files++))
            fi
        fi
    done
    
    # Final verification
    verify_no_conflicts
    
    # Generate summary
    generate_summary "$total_files" "$resolved_files" "$failed_files" "$backup_dir"
    
    if [ "$failed_files" -gt 0 ]; then
        log_message "WARNING" "Some files could not be automatically resolved. Manual intervention may be required."
        exit 1
    else
        log_message "SUCCESS" "All conflicts resolved successfully!"
        exit 0
    fi
}

# Check if script is being sourced or executed
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
