---
issues: []
discussions: []
title: "Quality Report — Notify"
type: report
tags: [quality, phpstan, pest, coverage]
module: Notify
created: 2026-08-24
updated: 2026-08-24
qmd: "Notify quality report phpstan pest coverage test ratio"
---

# Quality Report — Notify

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Notify`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 233 |
| LOC app/ | 17392 |
| File test | 151 |
| LOC test | 16532 |
| Test/App LOC ratio | 95.1% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Notify/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
