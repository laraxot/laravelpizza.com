#!/usr/bin/env bash
# Guard: push sicuro monorepo PTVX — remote corretto, no Geo embedded, no rebase sporco.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$ROOT"

fail() { echo "❌ guard-monorepo-push: $*" >&2; exit 1; }

ORIGIN="$(git remote get-url origin 2>/dev/null || true)"
case "$ORIGIN" in
  *module_geo_fila5*)
    fail "origin punta a module_geo_fila5. Usa: git remote set-url origin git@github.com:provtv/base_ptv_fila5.git"
    ;;
  "")
    fail "remote origin assente"
    ;;
esac

if [[ -d .git/rebase-merge || -d .git/rebase-apply ]]; then
  fail "rebase in corso — completa o: git rebase --abort"
fi

if git ls-files --error-unmatch laravel/Modules/Geo >/dev/null 2>&1; then
  fail "laravel/Modules/Geo è tracciato — git rm --cached -r laravel/Modules/Geo && echo laravel/Modules/Geo/ >> .gitignore"
fi

if [[ -d laravel/Modules/Geo/.git ]]; then
  fail "repo Geo embedded in laravel/Modules/Geo — rm -rf laravel/Modules/Geo (Geo non serve in questo progetto)"
fi

if grep -q '"Geo"[[:space:]]*:[[:space:]]*true' laravel/modules_statuses.json 2>/dev/null; then
  fail 'Geo deve restare false in laravel/modules_statuses.json'
fi

echo "✅ guard-monorepo-push OK (origin=${ORIGIN})"
