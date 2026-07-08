#!/usr/bin/env bash
set -euo pipefail

# resolve-conflicts-keep-incoming.sh
# Automatically resolves Git conflict markers by keeping the incoming change
# (the part between '=======' and '>>>>>>>' markers) and discarding the local/HEAD part.
#
# Usage:
#   bash resolve-conflicts-keep-incoming.sh [--apply] [--root <path>] [--ext "*.php,*.md,*.ini"]
#
# Notes:
# - By default runs in dry-run mode (shows files to be changed).
# - Use --apply to modify files in place. A .bak backup is created per file.
# - --ext allows filtering by glob(s), comma-separated. Default scans all text files with markers.
# - This script is idempotent; files without conflict markers are skipped.
#
# Conflict marker structure handled:
#   (local changes)
#
# The script will keep only the incoming changes block and remove markers.

APPLY=0
ROOT_DIR="$(git rev-parse --show-toplevel 2>/dev/null || pwd)"
EXT_FILTER=""

while [[ $# -gt 0 ]]; do
  case "$1" in
    --apply)
      APPLY=1
      shift
      ;;
    --root)
      ROOT_DIR="$2"; shift 2 ;;
    --ext)
      EXT_FILTER="$2"; shift 2 ;;
    -h|--help)
      grep '^#' "$0" | sed 's/^# \{0,1\}//'
      exit 0
      ;;
    *)
      echo "Unknown arg: $1" >&2; exit 1 ;;
  esac
done

cd "$ROOT_DIR"

# Build find command
mapfile -t CANDIDATES < <(
  if [[ -n "$EXT_FILTER" ]]; then
    IFS=',' read -r -a exts <<< "$EXT_FILTER"
    # Build combined -name globs
    name_args=()
    for g in "${exts[@]}"; do
      name_args+=( -name "$g" -o )
    done
    # drop trailing -o
    unset 'name_args[${#name_args[@]}-1]'
    eval find . -type f \( "${name_args[@]}" \) -print0 |
      xargs -0 grep -l "^<<<<<<< " 2>/dev/null
  else
    grep -rl "^<<<<<<< " -- . 2>/dev/null || true
  fi
)

if [[ ${#CANDIDATES[@]} -eq 0 ]]; then
  echo "No files with conflict markers found under: $ROOT_DIR"
  exit 0
fi

echo "Found ${#CANDIDATES[@]} file(s) with conflict markers"

# AWK resolver: state machine that keeps only the incoming block
awk_resolver='BEGIN{inconf=0;keep=0}
/^<<<<<<< /{inconf=1;keep=0;next}
/^=======$/{if(inconf){keep=1;next}}
/^>>>>>>> /{inconf=0;keep=0;next}
{ if(inconf){ if(keep){ print $0 } } else { print $0 } }'

changed=0
for f in "${CANDIDATES[@]}"; do
  # Skip binary files defensively
  if file -b "$f" | grep -qi "binary"; then
    continue
  fi

  if [[ $APPLY -eq 1 ]]; then
    tmp="${f}.tmp.$$"
    if awk "$awk_resolver" "$f" > "$tmp"; then
      if ! cmp -s "$f" "$tmp"; then
        cp "$f" "${f}.bak"
        mv "$tmp" "$f"
        echo "Resolved (kept incoming): $f"
        changed=$((changed+1))
      else
        rm -f "$tmp"
      fi
    else
      echo "AWK failed for $f" >&2
      rm -f "$tmp"
      exit 1
    fi
  else
    echo "Would resolve: $f"
  fi

done

if [[ $APPLY -eq 1 ]]; then
  echo "Done. Changed $changed file(s). Backups saved with .bak extension."
  echo "Tip: review changes with 'git diff' then remove backups or keep as needed."
else
  echo "Dry-run complete. Re-run with --apply to modify files."
fi
