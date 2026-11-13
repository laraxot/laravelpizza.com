---
title: "Quality Report — Activity"
type: report
tags: [quality, phpstan, pest, coverage]
module: Activity
created: 2026-08-24
updated: 2026-08-24
qmd: "Activity quality report phpstan pest coverage test ratio"
---

# Quality Report — Activity

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Activity`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 67 |
| LOC app/ | 3449 |
| File test | 132 |
| LOC test | 10296 |
| Test/App LOC ratio | 298.5% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Activity/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
