#!/usr/bin/env bash
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")"/.. && pwd)"
TARGET_DIR="$REPO_ROOT/bashscripts"

# Forbidden identifiers (project-specific)
FORBIDDEN_PATTERNS=(
  '<nome progetto>'
  '<nome progetto>'
  'Modules/<nome progetto>'
  'Modules/<nome progetto>'
)

violations=()

# 1) Filenames containing forbidden terms
while IFS= read -r -d '' f; do
  fname_lower=$(basename "$f" | tr '[:upper:]' '[:lower:]')
  for p in "${FORBIDDEN_PATTERNS[@]}"; do
    if [[ "$fname_lower" == *"$(echo "$p" | tr '[:upper:]' '[:lower:]')"* ]]; then
      violations+=("filename: ${f}")
      break
    fi
  done
done < <(find "$TARGET_DIR" -type f -print0)

# 2) File contents containing forbidden terms
while IFS= read -r -d '' f; do
  content_lower=$(tr '[:upper:]' '[:lower:]' < "$f")
  for p in "${FORBIDDEN_PATTERNS[@]}"; do
    if grep -qiE "$(printf '%s' "$p" | sed 's/[\/#.^$*+?()|[\]{}]/\\&/g')" <<< "$content_lower"; then
      violations+=("content: ${f}")
      break
    fi
  done
done < <(find "$TARGET_DIR" -type f -name "*.sh" -o -name "*.php" -o -name "*.md" -print0)

if (( ${#violations[@]} > 0 )); then
  echo "ERROR: Project-specific references found in shared bashscripts/" >&2
  printf '%s
' "${violations[@]}" >&2
  echo "\nMove project-specific scripts to module paths, e.g.:" >&2
  echo "  laravel/Modules/<nome progetto>/database/seeders/scripts/" >&2
  echo "  laravel/Modules/<nome progetto>/database/seeders/scripts/" >&2
  exit 1
fi

echo "OK: bashscripts/ is project-agnostic."