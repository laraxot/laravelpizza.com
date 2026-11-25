---
title: "Quality Report — Job"
type: report
tags: [quality, phpstan, pest, coverage]
module: Job
created: 2026-08-24
updated: 2026-08-24
qmd: "Job quality report phpstan pest coverage test ratio"
---

# Quality Report — Job

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Job`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 160 |
| LOC app/ | 8518 |
| File test | 45 |
| LOC test | 5023 |
| Test/App LOC ratio | 59.0% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Job/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
