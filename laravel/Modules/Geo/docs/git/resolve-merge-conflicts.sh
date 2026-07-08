#!/usr/bin/env bash
set -euo pipefail

# resolve-merge-conflicts.sh
# Wrapper to resolve merge conflicts by keeping the "incoming change".
# This wrapper lives under bashscripts/git/ as required.
# It delegates to resolve-conflicts-keep-incoming.sh.
#
# Usage:
#   bash bashscripts/git/resolve-merge-conflicts.sh [--apply] [--root <path>] [--ext "*.php,*.md,*.ini"]
#
# Default: dry-run (no file changes). Pass --apply to modify files.

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
RESOLVER="$SCRIPT_DIR/resolve-conflicts-keep-incoming.sh"

if [[ ! -x "$RESOLVER" ]]; then
  echo "Resolver script not found or not executable: $RESOLVER" >&2
  exit 1
fi

exec "$RESOLVER" "$@"
