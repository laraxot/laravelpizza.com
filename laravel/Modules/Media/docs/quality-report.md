---
issues: []
discussions: []
title: "Quality Report — Media"
type: report
tags: [quality, phpstan, pest, coverage]
module: Media
created: 2026-08-24
updated: 2026-08-24
qmd: "Media quality report phpstan pest coverage test ratio"
---

# Quality Report — Media

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Media`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 126 |
| LOC app/ | 8946 |
| File test | 41 |
| LOC test | 5445 |
| Test/App LOC ratio | 60.9% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Media/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
