---
title: "Quality Report — UI"
type: report
tags: [quality, phpstan, pest, coverage]
module: UI
created: 2026-08-24
updated: 2026-08-24
qmd: "UI quality report phpstan pest coverage test ratio"
---

# Quality Report — UI

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh UI`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 105 |
| LOC app/ | 6143 |
| File test | 65 |
| LOC test | 5746 |
| Test/App LOC ratio | 93.5% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/UI/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
