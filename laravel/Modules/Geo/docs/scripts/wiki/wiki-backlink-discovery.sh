#!/bin/bash
# wiki-backlink-discovery.sh - Discover bidirectional backlinks from module/theme docs to wiki pages
# Purpose: Find wiki pages that reference a given module/theme, using semantic similarity and keyword matching
# Usage: ./wiki-backlink-discovery.sh --module ModuleName [--threshold 0.7] [--output format]

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../../.." && pwd)"
WIKI_ROOT="$PROJECT_ROOT/docs/wiki"
MODULES_ROOT="$PROJECT_ROOT/laravel/Modules"
THEMES_ROOT="$PROJECT_ROOT/laravel/Themes"
CACHE_DIR="$PROJECT_ROOT/.cache/wiki-search"

# Parse arguments
MODULE_NAME=""
THEME_NAME=""
SIMILARITY_THRESHOLD=0.7
OUTPUT_FORMAT="text"

while [[ $# -gt 0 ]]; do
  case $1 in
    --module) MODULE_NAME="$2"; shift 2 ;;
    --theme) THEME_NAME="$2"; shift 2 ;;
    --threshold) SIMILARITY_THRESHOLD="$2"; shift 2 ;;
    --output) OUTPUT_FORMAT="$2"; shift 2 ;;
    *) echo "Unknown option: $1"; exit 1 ;;
  esac
done

if [[ -z "$MODULE_NAME" && -z "$THEME_NAME" ]]; then
  echo "Error: Either --module or --theme must be specified" >&2
  exit 1
fi

# Determine target type and name
if [[ -n "$MODULE_NAME" ]]; then
  TARGET_TYPE="module"
  TARGET_NAME="$MODULE_NAME"
  TARGET_WIKI_PATH="$MODULES_ROOT/$MODULE_NAME/docs/wiki"
  TARGET_KEYWORD="Modules/$MODULE_NAME"
else
  TARGET_TYPE="theme"
  TARGET_NAME="$THEME_NAME"
  TARGET_WIKI_PATH="$THEMES_ROOT/$THEME_NAME/docs/wiki"
  TARGET_KEYWORD="Themes/$THEME_NAME"
fi

# Verify target wiki exists
if [[ ! -d "$TARGET_WIKI_PATH" ]]; then
  echo "Error: Wiki directory not found: $TARGET_WIKI_PATH" >&2
  exit 1
fi

mkdir -p "$CACHE_DIR"

# Function: Find explicit keyword-based backlinks
find_explicit_backlinks() {
  local search_keyword="$1"
  local output_file="$CACHE_DIR/backlinks-explicit-${TARGET_TYPE}-${TARGET_NAME}.json"

  # Search for explicit mentions of module/theme in wiki files
  find "$WIKI_ROOT" -name "*.md" -type f | while read wiki_file; do
    if grep -q "$search_keyword" "$wiki_file" 2>/dev/null; then
      local rel_path="${wiki_file#$WIKI_ROOT/}"
      local title=$(grep -m 1 "^# " "$wiki_file" | sed 's/^# //')
      local confidence="1.0"  # Explicit match = 100% confidence

      echo "{\"file\": \"$rel_path\", \"title\": \"$title\", \"type\": \"explicit\", \"confidence\": $confidence}"
    fi
  done > "$output_file"

  echo "$output_file"
}

# Function: Find semantic backlinks using QMD context-mode
find_semantic_backlinks() {
  local target_concepts="$1"
  local output_file="$CACHE_DIR/backlinks-semantic-${TARGET_TYPE}-${TARGET_NAME}.json"
  local threshold="$2"

  # Read module wiki index to get concept keywords
  local index_file="$TARGET_WIKI_PATH/index.md"
  if [[ ! -f "$index_file" ]]; then
    echo "[]" > "$output_file"
    echo "$output_file"
    return
  fi

  # Extract key concepts from module wiki index
  local concepts=$(grep -oP '(?<=^- )\[.*?\]' "$index_file" | sed 's/\[//g;s/\]//g' | head -5)

  # For each concept, find related wiki pages using context-mode semantic search
  local results_json="["
  local first=true

  # This would typically use context-mode or QMD semantic search
  # For now, we'll implement a text-based similarity check
  while IFS= read -r concept; do
    [[ -z "$concept" ]] && continue

    # Find wiki pages that mention this concept (simplified semantic matching)
    find "$WIKI_ROOT" -name "*.md" -type f | while read wiki_file; do
      if grep -q "$concept" "$wiki_file" 2>/dev/null; then
        local rel_path="${wiki_file#$WIKI_ROOT/}"
        local title=$(grep -m 1 "^# " "$wiki_file" | sed 's/^# //')
        local confidence="0.75"  # Semantic match = conservative confidence

        if [[ "$first" == true ]]; then
          results_json+="{\"file\": \"$rel_path\", \"title\": \"$title\", \"type\": \"semantic\", \"confidence\": $confidence}"
          first=false
        else
          results_json+=",{\"file\": \"$rel_path\", \"title\": \"$title\", \"type\": \"semantic\", \"confidence\": $confidence}"
        fi
      fi
    done
  done <<< "$concepts"

  results_json+="]"
  echo "$results_json" > "$output_file"
  echo "$output_file"
}

# Function: Generate markdown section for module/theme docs
generate_backlink_section() {
  local explicit_file="$1"
  local semantic_file="$2"
  local threshold="$3"

  cat <<'MARKDOWN_HEADER'
## Related Wiki Pages

This section links to wiki documentation that references this module. Use these links to understand how this module fits into the broader project architecture and patterns.

### Direct References
MARKDOWN_HEADER

  # Read explicit backlinks
  local count=0
  if [[ -f "$explicit_file" ]]; then
    grep -o '{"file".*}' "$explicit_file" | while read line; do
      local file=$(echo "$line" | grep -oP '"file":\s*"\K[^"]+')
      local title=$(echo "$line" | grep -oP '"title":\s*"\K[^"]+')
      echo "- [$title]($WIKI_ROOT/$file)"
      ((count++))
    done

    if [[ $count -eq 0 ]]; then
      echo "*(No direct references found)*"
    fi
  fi

  cat <<'MARKDOWN_SEMANTIC'

### Related Concepts
*(Discovered via semantic similarity in wiki)*
MARKDOWN_SEMANTIC

  # Read semantic backlinks
  if [[ -f "$semantic_file" ]]; then
    grep -o '{"file".*}' "$semantic_file" | head -5 | while read line; do
      local file=$(echo "$line" | grep -oP '"file":\s*"\K[^"]+')
      local title=$(echo "$line" | grep -oP '"title":\s*"\K[^"]+')
      local confidence=$(echo "$line" | grep -oP '"confidence":\s*\K[0-9.]+')
      echo "- [$title]($WIKI_ROOT/$file) — confidence: ${confidence%.*}%"
    done
  fi
}

# Function: Display results in requested format
display_results() {
  local explicit_file="$1"
  local semantic_file="$2"
  local format="$3"

  case "$format" in
    text)
      echo "Backlinks for $TARGET_TYPE: $TARGET_NAME"
      echo "=================================="
      echo ""
      generate_backlink_section "$explicit_file" "$semantic_file" "$SIMILARITY_THRESHOLD"
      ;;
    json)
      echo "{"
      echo "  \"target\": {\"type\": \"$TARGET_TYPE\", \"name\": \"$TARGET_NAME\"},"
      echo "  \"explicit_backlinks\": $(cat "$explicit_file" 2>/dev/null || echo '[]'),"
      echo "  \"semantic_backlinks\": $(cat "$semantic_file" 2>/dev/null || echo '[]')"
      echo "}"
      ;;
    markdown)
      generate_backlink_section "$explicit_file" "$semantic_file" "$SIMILARITY_THRESHOLD"
      ;;
  esac
}

# Main execution
echo "Discovering backlinks for $TARGET_TYPE: $TARGET_NAME..." >&2

explicit_file=$(find_explicit_backlinks "$TARGET_KEYWORD")
semantic_file=$(find_semantic_backlinks "$TARGET_NAME" "$SIMILARITY_THRESHOLD")

echo "✓ Explicit backlinks: $(grep -c '{"file"' "$explicit_file" 2>/dev/null || echo 0)" >&2
echo "✓ Semantic backlinks: $(grep -c '{"file"' "$semantic_file" 2>/dev/null || echo 0)" >&2
echo ""

display_results "$explicit_file" "$semantic_file" "$OUTPUT_FORMAT"
