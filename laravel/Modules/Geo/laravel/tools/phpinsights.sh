#!/bin/bash
# PHPInsights standalone wrapper script
# Installed in isolated directory to avoid dependency conflicts with main project
# @see Modules/Xot/docs/phpinsights-standalone.md
set -euo pipefail

TOOLS_DIR="$(cd "$(dirname "$0")" && pwd)"
LARAVEL_DIR="$(cd "${TOOLS_DIR}/.." && pwd)"
CONFIG_PATH="${LARAVEL_DIR}/phpinsights.php"
INSIGHTS_BIN="${TOOLS_DIR}/phpinsights/vendor/bin/phpinsights"

if [[ $# -eq 0 ]]; then
  set -- analyse Modules --no-interaction --config-path="${CONFIG_PATH}"
elif [[ "${1:-}" == "analyse" ]] && ! printf '%s\n' "$@" | grep -q -- '--config-path'; then
  set -- "$@" --config-path="${CONFIG_PATH}"
fi

php "${INSIGHTS_BIN}" "$@"
