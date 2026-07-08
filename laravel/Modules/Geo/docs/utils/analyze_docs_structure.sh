#!/bin/bash

# Script to analyze docs structure and identify DRY/KISS improvements
# Respects DRY (Don't Repeat Yourself) and KISS (Keep It Simple, Stupid) principles

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>_fila5_mono"
ANALYSIS_OUTPUT="/tmp/docs_analysis.md"

echo "📚 Analyzing docs structure for DRY and KISS improvements..."
echo "# Documentation Analysis Report" > "$ANALYSIS_OUTPUT"
echo "Generated on: $(date)" >> "$ANALYSIS_OUTPUT"
echo "" >> "$ANALYSIS_OUTPUT"

# Function to analyze a docs directory
analyze_docs_dir() {
    local docs_dir="$1"
    local relative_path="${docs_dir#$PROJECT_ROOT/}"
    
    echo "## Analysis: $relative_path" >> "$ANALYSIS_OUTPUT"
    echo "" >> "$ANALYSIS_OUTPUT"
    
    if [[ ! -d "$docs_dir" ]]; then
        echo "   ⚠️  Directory does not exist: $docs_dir"
        return
    fi
    
    echo "📁 Analyzing: $relative_path"
    
    # Count files and get structure
    local file_count=$(find "$docs_dir" -type f -name "*.md" | wc -l)
    local dir_count=$(find "$docs_dir" -type d | wc -l)
    
    echo "- **Files**: $file_count markdown files" >> "$ANALYSIS_OUTPUT"
    echo "- **Directories**: $dir_count total directories" >> "$ANALYSIS_OUTPUT"
    echo "" >> "$ANALYSIS_OUTPUT"
    
    # List all markdown files with sizes
    echo "### Files Structure:" >> "$ANALYSIS_OUTPUT"
    echo "\`\`\`" >> "$ANALYSIS_OUTPUT"
    find "$docs_dir" -name "*.md" -type f -exec ls -lh {} \; | awk '{print $9 " (" $5 ")"}' | sort >> "$ANALYSIS_OUTPUT"
    echo "\`\`\`" >> "$ANALYSIS_OUTPUT"
    echo "" >> "$ANALYSIS_OUTPUT"
    
    # Identify potential duplicates by filename
    echo "### Potential Duplicates (by filename):" >> "$ANALYSIS_OUTPUT"
    find "$docs_dir" -name "*.md" -type f -printf "%f\n" | sort | uniq -d | while read -r duplicate; do
        echo "- **$duplicate**:" >> "$ANALYSIS_OUTPUT"
        find "$docs_dir" -name "$duplicate" -type f >> "$ANALYSIS_OUTPUT"
        echo "" >> "$ANALYSIS_OUTPUT"
    done
    
    # Check for common patterns that might indicate duplication
    echo "### Common Topics (potential for consolidation):" >> "$ANALYSIS_OUTPUT"
    find "$docs_dir" -name "*.md" -type f -printf "%f\n" | grep -i -E "(index|readme|migration|test|config|install|setup)" | sort >> "$ANALYSIS_OUTPUT"
    echo "" >> "$ANALYSIS_OUTPUT"
    
    echo "---" >> "$ANALYSIS_OUTPUT"
    echo "" >> "$ANALYSIS_OUTPUT"
}

# Find all docs directories and analyze them
echo "🔍 Finding all docs directories..."
find "$PROJECT_ROOT" -type d -name "docs" -not -path "*/vendor/*" -not -path "*/node_modules/*" | sort | while read -r docs_dir; do
    analyze_docs_dir "$docs_dir"
done

# Global analysis
echo "# Global Analysis" >> "$ANALYSIS_OUTPUT"
echo "" >> "$ANALYSIS_OUTPUT"

echo "## All Markdown Files by Name (for DRY analysis):" >> "$ANALYSIS_OUTPUT"
echo "\`\`\`" >> "$ANALYSIS_OUTPUT"
find "$PROJECT_ROOT" -path "*/docs/*" -name "*.md" -not -path "*/vendor/*" -not -path "*/node_modules/*" -printf "%f\n" | sort | uniq -c | sort -nr >> "$ANALYSIS_OUTPUT"
echo "\`\`\`" >> "$ANALYSIS_OUTPUT"
echo "" >> "$ANALYSIS_OUTPUT"

echo "## Files with Similar Names (potential consolidation candidates):" >> "$ANALYSIS_OUTPUT"
find "$PROJECT_ROOT" -path "*/docs/*" -name "*.md" -not -path "*/vendor/*" -not -path "*/node_modules/*" -printf "%f\n" | sort | uniq -d >> "$ANALYSIS_OUTPUT"
echo "" >> "$ANALYSIS_OUTPUT"

echo "## Large Files (>5KB - potential for splitting):" >> "$ANALYSIS_OUTPUT"
find "$PROJECT_ROOT" -path "*/docs/*" -name "*.md" -not -path "*/vendor/*" -not -path "*/node_modules/*" -size +5k -exec ls -lh {} \; | awk '{print $9 " (" $5 ")"}' | sort >> "$ANALYSIS_OUTPUT"
echo "" >> "$ANALYSIS_OUTPUT"

echo "📊 Analysis complete! Report saved to: $ANALYSIS_OUTPUT"
echo ""
echo "🔍 Displaying summary..."
cat "$ANALYSIS_OUTPUT" | head -50
echo ""
echo "📄 Full report available at: $ANALYSIS_OUTPUT"
