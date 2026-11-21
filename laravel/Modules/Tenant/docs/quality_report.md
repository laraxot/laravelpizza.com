---
issues: []
discussions: []
title: "Quality Report — Tenant"
type: report
tags: [quality, phpstan, pest, coverage]
module: Tenant
created: 2026-08-24
updated: 2026-08-24
qmd: "Tenant quality report phpstan pest coverage test ratio"
---

# Quality Report — Tenant

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Tenant`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 52 |
| LOC app/ | 3684 |
| File test | 41 |
| LOC test | 5124 |
| Test/App LOC ratio | 139.1% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Tenant/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
