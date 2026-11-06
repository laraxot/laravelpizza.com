---
title: "Geo — PHPStan wave2 rector e costanti"
type: story
module: Geo
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, typeCoverage, constantTypeCoverage, rector, wave2]
qmd: "geo phpstan wave2 rector early return constant type coverage"
related:
  - ./phpstan-wave-coord.story.md
  - ../scopo.md
  - ../../../../../docs/stories/16-14-type-coverage-costanti-al-sei-percento.md
---

# Geo — wave2: costanti tipizzate + rector

## Scopo (prima dell'errore)

Geo e' l'unico dominio geocoding/mappe riusabile. Le URL dei provider e la config Rector
del modulo devono restare analizzabili da PHPStan senza set deprecati: altrimenti il gate
del modulo e' rosso mentre il dominio "dove" resta corretto a runtime.

## Inventario wave2

`/tmp/phpstan_by_module_w2/Geo.txt` — 4 errori:

| Famiglia | Dove | Fix |
|---|---|---|
| `constantTypeCoverage` ×3 | URL Google Maps (poi tipizzate / servizi zombie rimossi in wave3) | `const string` |
| `classConstant.deprecated` ×1 | `SetList::EARLY_RETURN` in `rector.php` | rimosso: le regole early-return sono in `SetList::CODE_QUALITY` |

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Geo --memory-limit=2G
# [OK] No errors
```
