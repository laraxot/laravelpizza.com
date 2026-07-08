#!/usr/bin/env bash
# Esegui PHPStan su tutti i moduli (esclusi Incentivi e Pdnd), uno alla volta.
# Uso:
#   ./run_phpstan_parallel.sh               # tutti i moduli
#   ./run_phpstan_parallel.sh Modules/Job   # singolo modulo
set -euo pipefail

cd /var/www/_bases/base_ptvx_fila5/laravel

PHPSTAN="php -d memory_limit=2048M ./vendor/bin/phpstan analyse --memory-limit=2048M --no-progress"

if [ -n "${1:-}" ]; then
    echo "=== PHPStan: $1 ==="
    $PHPSTAN "$1"
    exit $?
fi

ERRORS=()
for dir in Modules/*/; do
    module=$(basename "$dir")
    [[ "$module" == "Incentivi" || "$module" == "Pdnd" ]] && continue
    echo ""
    echo "=== PHPStan: $module ==="
    if ! $PHPSTAN "$dir"; then
        ERRORS+=("$module")
    fi
done

echo ""
if [ ${#ERRORS[@]} -eq 0 ]; then
    echo "✅ Tutti i moduli: nessun errore"
else
    echo "❌ Moduli con errori: ${ERRORS[*]}"
    exit 1
fi
