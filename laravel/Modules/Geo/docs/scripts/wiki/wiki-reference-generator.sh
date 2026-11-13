#!/bin/bash
# wiki-reference-generator.sh - Generate bidirectional cross-references between wiki and module documentation
# Purpose: Parse wiki pages, identify module references, generate clickable links, and maintain reference inventory
# Usage: ./wiki-reference-generator.sh [--update-wiki] [--target-page path/to/page.md] [--output format]

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../../.." && pwd)"
WIKI_ROOT="$PROJECT_ROOT/docs/wiki"
MODULES_ROOT="$PROJECT_ROOT/laravel/Modules"
THEMES_ROOT="$PROJECT_ROOT/laravel/Themes"
CACHE_DIR="$PROJECT_ROOT/.cache/wiki-cross-references"

# Parse arguments
UPDATE_WIKI=false
TARGET_PAGE=""
OUTPUT_FORMAT="json"

while [[ $# -gt 0 ]]; do
  case $1 in
    --update-wiki) UPDATE_WIKI=true; shift ;;
    --target-page) TARGET_PAGE="$2"; shift 2 ;;
    --output) OUTPUT_FORMAT="$2"; shift 2 ;;
    *) echo "Unknown option: $1"; exit 1 ;;
  esac
done

mkdir -p "$CACHE_DIR"

# Function: Extract all module/theme names mentioned in a wiki page
extract_referenced_modules() {
  local wiki_file="$1"

  if [[ ! -f "$wiki_file" ]]; then
    echo "" >&2
    return
  fi

  # Extract module/theme references from content (e.g., "Modules/User", "Modules/Gdpr", "Themes/Zero")
  grep -oP 'Modules/\K[A-Za-z0-9]+|Themes/\K[A-Za-z0-9]+' "$wiki_file" | sort -u
}

# Function: Find module wiki documentation paths
find_module_wiki_path() {
  local module_name="$1"
  local wiki_path="$MODULES_ROOT/$module_name/docs/wiki"

  if [[ -d "$wiki_path" ]]; then
    echo "$wiki_path"
  fi
}

# Function: Find theme wiki documentation paths
find_theme_wiki_path() {
  local theme_name="$1"
  local wiki_path="$THEMES_ROOT/$theme_name/docs/wiki"

  if [[ -d "$wiki_path" ]]; then
    echo "$wiki_path"
  fi
}

# Function: Generate reference entry for frontmatter
generate_reference_entry() {
  local target_type="$1"  # "module" or "theme"
  local target_name="$2"
  local relationship_type="$3"  # concept, implementation, example, architecture, tooling
  local relative_path="$4"

  cat <<EOF
  - type: $relationship_type
    ${target_type}: $target_name
    path: $relative_path
EOF
}

# Function: Generate bidirectional reference graph
generate_reference_graph() {
  local output_file="$CACHE_DIR/reference-graph.json"

  cat > "$output_file" <<'GRAPH_HEADER'
{
  "metadata": {
    "generated": "$(date -u +%Y-%m-%dT%H:%M:%SZ)",
    "project": "base_ptvx_fila5",
    "version": "1.0"
  },
  "wiki_to_modules": [
GRAPH_HEADER

  # Scan all wiki pages for module references
  find "$WIKI_ROOT" -name "*.md" -type f | while read wiki_file; do
    local rel_path="${wiki_file#$WIKI_ROOT/}"
    local modules=$(extract_referenced_modules "$wiki_file")

    while IFS= read -r module; do
      [[ -z "$module" ]] && continue
      local module_wiki=$(find_module_wiki_path "$module")
      [[ -z "$module_wiki" ]] && continue

      local target_rel="${module_wiki#$PROJECT_ROOT/}"
      echo "    {\"source\": \"$rel_path\", \"target\": \"$target_rel\", \"type\": \"wiki_to_module\"},"
    done <<< "$modules"
  done | head -n -1  # Remove trailing comma

  cat >> "$output_file" <<'GRAPH_FOOTER'
  ],
  "modules_to_wiki": [
GRAPH_FOOTER

  # For each module, find wiki pages that reference it (backlinks)
  find "$MODULES_ROOT" -maxdepth 2 -name 'docs/wiki' -type d | while read module_wiki; do
    local module_name=$(basename "$(dirname "$(dirname "$module_wiki")")")

    # Find wiki pages that mention this module
    find "$WIKI_ROOT" -name "*.md" -type f | while read wiki_file; do
      if grep -q "Modules/$module_name" "$wiki_file" 2>/dev/null; then
        local source_rel="${wiki_file#$PROJECT_ROOT/}"
        local target_rel="${module_wiki#$PROJECT_ROOT/}"
        echo "    {\"source\": \"$target_rel\", \"target\": \"$source_rel\", \"type\": \"module_to_wiki\"},"
      fi
    done
  done | head -n -1

  cat >> "$output_file" <<'GRAPH_FOOTER'
  ]
}
GRAPH_FOOTER

  echo "$output_file"
}

# Function: Update wiki page with references field
update_wiki_page_with_references() {
  local wiki_file="$1"
  local modules=$(extract_referenced_modules "$wiki_file")

  [[ -z "$modules" ]] && return 1

  # Extract existing frontmatter
  local frontmatter_end=$(grep -n '^---$' "$wiki_file" | head -2 | tail -1 | cut -d: -f1)
  [[ -z "$frontmatter_end" ]] && return 1

  # Prepare new references section
  local refs_yaml=""
  while IFS= read -r module; do
    [[ -z "$module" ]] && continue
    local module_wiki=$(find_module_wiki_path "$module")
    [[ -z "$module_wiki" ]] && continue

    local target_rel="${module_wiki#$PROJECT_ROOT/}"
    refs_yaml+="$(generate_reference_entry "module" "$module" "concept" "$target_rel")\n"
  done <<< "$modules"

  if [[ -z "$refs_yaml" ]]; then
    return 1
  fi

  # Read current file
  local tmp_file="${wiki_file}.tmp"
  head -n "$((frontmatter_end - 1))" "$wiki_file" > "$tmp_file"

  # Add references field if not already present
  if ! grep -q "^references:" "$wiki_file"; then
    echo "references:" >> "$tmp_file"
    echo -e "$refs_yaml" >> "$tmp_file"
  fi

  # Add closing delimiter and rest of file
  echo "---" >> "$tmp_file"
  tail -n "+$((frontmatter_end + 1))" "$wiki_file" >> "$tmp_file"

  mv "$tmp_file" "$wiki_file"
  return 0
}

# Function: Display reference statistics
show_statistics() {
  local wiki_count=$(find "$WIKI_ROOT" -name "*.md" -type f | wc -l)
  local module_count=$(find "$MODULES_ROOT" -maxdepth 2 -name 'docs/wiki' -type d | wc -l)
  local theme_count=$(find "$THEMES_ROOT" -maxdepth 2 -name 'docs/wiki' -type d | wc -l)

  cat <<STATS
Wiki Cross-Reference Statistics
================================
Wiki Pages: $wiki_count
Modules with Wiki: $module_count
Themes with Wiki: $theme_count

Reference Graph Generated: $CACHE_DIR/reference-graph.json
STATS
}

# Main execution
if [[ -n "$TARGET_PAGE" ]]; then
  # Update specific page
  if update_wiki_page_with_references "$WIKI_ROOT/$TARGET_PAGE"; then
    echo "✓ Updated: $TARGET_PAGE"
  else
    echo "⚠ No references found in: $TARGET_PAGE"
  fi
elif [[ "$UPDATE_WIKI" == true ]]; then
  # Update all priority 1 pages
  echo "Updating priority wiki pages with bidirectional references..."

  priority_pages=(
    "concepts/module-structure.md"
    "concepts/architecture-guardrails.md"
    "how-to/module-wiki-documentation.md"
    "how-to/theme-wiki-documentation.md"
  )

  for page in "${priority_pages[@]}"; do
    if update_wiki_page_with_references "$WIKI_ROOT/$page"; then
      echo "✓ Updated: $page"
    else
      echo "⚠ No references in: $page"
    fi
  done
else
  # Generate and display reference graph
  generate_reference_graph
  show_statistics
  echo "✓ Reference graph generated successfully"
fi
