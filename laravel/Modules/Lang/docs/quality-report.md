---
issues: []
discussions: []
title: "Quality Report — Lang"
type: report
tags: [quality, phpstan, pest, coverage]
module: Lang
created: 2026-08-24
updated: 2026-08-24
qmd: "Lang quality report phpstan pest coverage test ratio"
---

# Quality Report — Lang

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Lang`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 62 |
| LOC app/ | 4552 |
| File test | 25 |
| LOC test | 4700 |
| Test/App LOC ratio | 103.3% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Lang/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
