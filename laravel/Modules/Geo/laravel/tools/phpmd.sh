#!/usr/bin/env bash
set -euo pipefail

# PHPMD standalone wrapper script
# @see Modules/Xot/docs/phpmd-standalone.md
TOOLS_DIR="$(cd "$(dirname "$0")" && pwd)"
export PDEPEND_HOME="${PDEPEND_HOME:-/tmp/pdepend-cache}"
mkdir -p "$PDEPEND_HOME"

php "$TOOLS_DIR/phpmd.phar" "$@"
