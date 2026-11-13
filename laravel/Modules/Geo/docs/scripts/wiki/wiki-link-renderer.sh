#!/bin/bash
# wiki-link-renderer.sh - Render bidirectional wiki and code documentation links
# Purpose: Generate clickable links from wiki references field and display related pages sections
# Usage: ./wiki-link-renderer.sh --page-path docs/wiki/concepts/module-structure.md [--format markdown|html]

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../.." && pwd)"

# Parse arguments
PAGE_PATH=""
OUTPUT_FORMAT="markdown"
INCLUDE_SECTION_MARKER=true

while [[ $# -gt 0 ]]; do
  case $1 in
    --page-path) PAGE_PATH="$2"; shift 2 ;;
    --format) OUTPUT_FORMAT="$2"; shift 2 ;;
    --no-section-marker) INCLUDE_SECTION_MARKER=false; shift ;;
    *) echo "Unknown option: $1"; exit 1 ;;
  esac
done

if [[ -z "$PAGE_PATH" ]]; then
  echo "Error: --page-path is required" >&2
  exit 1
fi

FULL_PATH="$PROJECT_ROOT/$PAGE_PATH"

if [[ ! -f "$FULL_PATH" ]]; then
  echo "Error: File not found: $FULL_PATH" >&2
  exit 1
fi

# Function: Extract and parse references from YAML frontmatter using awk
extract_references() {
  local file="$1"

  # Extract everything from "references:" to before "---"
  awk '/^references:/{flag=1; next} /^---$/{if(flag) exit} flag' "$file" | \
    # Parse each reference block (lines starting with "- type:" or indented fields)
    awk '
      BEGIN { print "[[REF_START]]" }
      /^[[:space:]]*- type:/ {
        if (has_ref) print "[[REF_END]]"
        has_ref=1
        gsub(/.*type:[[:space:]]*/, "")
        type=$0
        print "TYPE=" type
      }
      /^[[:space:]]*module:/ && has_ref {
        gsub(/.*module:[[:space:]]*/, "")
        print "MODULE=" $0
      }
      /^[[:space:]]*theme:/ && has_ref {
        gsub(/.*theme:[[:space:]]*/, "")
        print "THEME=" $0
      }
      /^[[:space:]]*path:/ && has_ref {
        gsub(/.*path:[[:space:]]*/, "")
        print "PATH=" $0
      }
      END { if (has_ref) print "[[REF_END]]" }
    '
}

# Function: Render markdown links from references
render_markdown_links() {
  local references="$1"
  local format="${2:-links}"  # links or section

  if [[ -z "$references" ]]; then
    return
  fi

  if [[ "$format" == "section" ]]; then
    echo "## Referenced Module and Theme Documentation"
    echo ""
    echo "This page references the following modules and themes. Follow the links to explore their implementation details."
    echo ""
  fi

  local type=""
  local module=""
  local theme=""
  local path=""

  echo "$references" | while IFS='=' read -r key value; do
    [[ -z "$key" ]] && continue

    case "$key" in
      "TYPE") type="$value" ;;
      "MODULE") module="$value" ;;
      "THEME") theme="$value" ;;
      "PATH") path="$value" ;;
      "[[REF_END]]")
        if [[ -n "$module" && -n "$path" ]]; then
          echo "- [\`$type\`] [$module — $type]($path)"
        elif [[ -n "$theme" && -n "$path" ]]; then
          echo "- [\`$type\`] [Theme: $theme — $type]($path)"
        fi
        type=""
        module=""
        theme=""
        path=""
        ;;
    esac
  done
}

# Function: Render HTML links from references
render_html_links() {
  local references="$1"

  cat <<'HTML_HEADER'
<section class="wiki-references">
  <h2>Referenced Module and Theme Documentation</h2>
  <p>This page references the following modules and themes. Follow the links to explore their implementation details.</p>
  <ul class="wiki-reference-list">
HTML_HEADER

  echo "$references" | while IFS= read -r line; do
    [[ -z "$line" ]] && continue
    [[ "$line" =~ ^[[:space:]]*- ]] || continue

    local type=""
    local module=""
    local theme=""
    local path=""

    while IFS= read -r ref_line; do
      [[ -z "$ref_line" ]] && continue
      if [[ "$ref_line" =~ type:\ (.+) ]]; then
        type="${BASH_REMATCH[1]}"
      elif [[ "$ref_line" =~ module:\ (.+) ]]; then
        module="${BASH_REMATCH[1]}"
      elif [[ "$ref_line" =~ theme:\ (.+) ]]; then
        theme="${BASH_REMATCH[1]}"
      elif [[ "$ref_line" =~ path:\ (.+) ]]; then
        path="${BASH_REMATCH[1]}"
      fi
    done

    if [[ -n "$module" && -n "$path" ]]; then
      local link_title="$module"
      echo "    <li><span class=\"badge badge-${type}\">${type}</span> <a href=\"${path}\">${link_title} Documentation</a></li>"
    elif [[ -n "$theme" && -n "$path" ]]; then
      local link_title="Theme: $theme"
      echo "    <li><span class=\"badge badge-${type}\">${type}</span> <a href=\"${path}\">${link_title} Documentation</a></li>"
    fi
  done

  cat <<'HTML_FOOTER'
  </ul>
</section>

<style>
.wiki-references {
  margin: 2rem 0;
  padding: 1.5rem;
  border: 1px solid #e0e0e0;
  border-left: 4px solid #0066cc;
  background-color: #f9f9f9;
  border-radius: 4px;
}

.wiki-references h2 {
  margin-top: 0;
  color: #0066cc;
  font-size: 1.25rem;
}

.wiki-reference-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.wiki-reference-list li {
  margin: 0.5rem 0;
  padding: 0.5rem;
  display: flex;
  gap: 0.75rem;
  align-items: center;
}

.badge {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  border-radius: 3px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  color: white;
}

.badge-concept {
  background-color: #4CAF50;
}

.badge-implementation {
  background-color: #2196F3;
}

.badge-example {
  background-color: #FF9800;
}

.badge-architecture {
  background-color: #9C27B0;
}

.badge-tooling {
  background-color: #F44336;
}

.wiki-references a {
  color: #0066cc;
  text-decoration: none;
  font-weight: 500;
}

.wiki-references a:hover {
  text-decoration: underline;
}
</style>
HTML_FOOTER
}

# Main execution
references=$(extract_references "$FULL_PATH")

if [[ -z "$references" ]]; then
  echo "No references found in: $PAGE_PATH" >&2
  exit 1
fi

case "$OUTPUT_FORMAT" in
  markdown)
    if [[ "$INCLUDE_SECTION_MARKER" == true ]]; then
      render_markdown_links "$references" "section"
    else
      render_markdown_links "$references" "links"
    fi
    ;;
  html)
    render_html_links "$references"
    ;;
  *)
    echo "Error: Unknown format: $OUTPUT_FORMAT" >&2
    exit 1
    ;;
esac
