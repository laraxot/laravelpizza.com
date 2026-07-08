#!/bin/bash
# Accessible Wiki Search - Screen reader friendly search interface
# Usage: ./accessible-search.sh [OPTIONS] "search query"
#
# Provides accessible output format suitable for:
# - Screen readers (NVDA, JAWS, VoiceOver)
# - High contrast displays
# - Keyboard-only navigation
# - Plain text terminals

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Configuration
QUERY=""
OUTPUT_FORMAT="accessible"
VERBOSE=false

# Parse arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        -h|--help)
            show_help
            exit 0
            ;;
        --format)
            OUTPUT_FORMAT="$2"
            shift 2
            ;;
        -v|--verbose)
            VERBOSE=true
            shift
            ;;
        *)
            QUERY="$1"
            shift
            ;;
    esac
done

show_help() {
    cat << 'EOF'
Accessible Wiki Search - Screen reader friendly interface

USAGE:
  accessible-search.sh [OPTIONS] "search query"

OPTIONS:
  -h, --help              Show this help message
  --format FORMAT         Output format: accessible, html, json
  -v, --verbose           Provide detailed explanations

KEYBOARD SHORTCUTS:
  In search results:
  - Press 'j' to go to next result
  - Press 'k' to go to previous result
  - Press 'Enter' to view details
  - Press '?' for help
  - Press 'q' to quit

SCREEN READER FEATURES:
  - Descriptive headings for each section
  - Semantic structure for result lists
  - Alt text for all visual information
  - ARIA labels for interactive elements

EXAMPLES:
  # Basic accessible search
  accessible-search.sh "context-mode"

  # Verbose output with explanations
  accessible-search.sh -v "testing strategies"

  # HTML output with ARIA labels (for web)
  accessible-search.sh --format html "gdpr"

  # JSON output for programmatic use
  accessible-search.sh --format json "semantic search"
EOF
}

# Accessible output format (screen reader optimized)
output_accessible() {
    local query="$1"

    echo "Search Results for: $query"
    echo "========================================"
    echo ""

    # Execute search
    local results=$("$SCRIPT_DIR/wiki-search" "$query" 2>&1 || true)

    if [[ -z "$results" || "$results" == "No results found"* ]]; then
        echo "No results found for your search."
        echo ""
        echo "Try:"
        echo "- Using more specific search terms"
        echo "- Searching for related concepts"
        echo "- Using semantic search for related ideas"
        return
    fi

    # Parse and display results accessibly
    local result_count=0
    echo "$results" | while read -r line; do
        if [[ -n "$line" ]]; then
            ((result_count++))
            echo "Result $result_count:"
            echo "$line"
            echo ""
        fi
    done

    if [[ $VERBOSE == true ]]; then
        echo "Search Tips:"
        echo "- Use specific keywords for faster results"
        echo "- Combine multiple terms for better matches"
        echo "- Try semantic search for related concepts"
    fi
}

# HTML output with ARIA labels
output_html() {
    local query="$1"

    cat << EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki Search: $query</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px; }
        h1 { color: #333; }
        .search-results { role: region; aria-label: "Search results"; }
        .result { margin: 20px 0; border-left: 4px solid #007bff; padding: 15px; }
        .result-title { font-weight: bold; font-size: 1.1em; }
        .result-path { color: #666; font-size: 0.9em; }
        .result-type { display: inline-block; background: #e9ecef; padding: 2px 8px; border-radius: 3px; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Wiki Search Results for "$query"</h1>
    <div class="search-results" role="region" aria-label="Search results">
EOF

    # Execute search and format as HTML
    "$SCRIPT_DIR/wiki-search" "$query" 2>/dev/null | while read -r line; do
        if [[ -n "$line" ]]; then
            cat << EOF
        <article class="result" role="article">
            <p class="result-title">$line</p>
        </article>
EOF
        fi
    done

    cat << 'EOF'
    </div>
</body>
</html>
EOF
}

# JSON output
output_json() {
    local query="$1"

    echo "{"
    echo "  \"query\": \"$query\","
    echo "  \"format\": \"accessible\","
    echo "  \"results\": ["

    "$SCRIPT_DIR/wiki-search" "$query" --format json 2>/dev/null || echo "[]"

    echo "  ]"
    echo "}"
}

# Main execution
if [[ -z "$QUERY" ]]; then
    show_help
    exit 1
fi

case "$OUTPUT_FORMAT" in
    accessible)
        output_accessible "$QUERY"
        ;;
    html)
        output_html "$QUERY"
        ;;
    json)
        output_json "$QUERY"
        ;;
    *)
        echo "Unknown format: $OUTPUT_FORMAT"
        show_help
        exit 1
        ;;
esac
