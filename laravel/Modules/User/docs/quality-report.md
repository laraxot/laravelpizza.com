---
title: "Quality Report — User"
type: report
tags: [quality, phpstan, pest, coverage]
module: User
created: 2026-08-24
updated: 2026-08-24
qmd: "User quality report phpstan pest coverage test ratio"
---

# Quality Report — User

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh User`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 664 |
| LOC app/ | 38321 |
| File test | 164 |
| LOC test | 20860 |
| Test/App LOC ratio | 54.4% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/User/tests \
  --coverage-text --colors=never
```

## Note

- PHPStan gira a level max su tutto `Modules/`: il valore sopra è quello del singolo modulo.
- Il coverage completo per tutti i moduli è costoso (~2 min/modulo con Xdebug): da eseguire selettivamente o via CI.
