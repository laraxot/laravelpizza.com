#!/usr/bin/env bash
# WSL/Laragon: PHP-FPM (www-data) deve poter scrivere/touchare le view compilate.
# Errore tipico: touch(): Utime failed: Operation not permitted (BladeCompiler)
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

DIRS=(
  storage
  bootstrap/cache
)

for d in "${DIRS[@]}"; do
  [[ -d "$d" ]] || continue
  chmod -R a+rwX "$d"
done

echo "✅ storage/bootstrap/cache — permessi aggiornati (a+rwX)"
