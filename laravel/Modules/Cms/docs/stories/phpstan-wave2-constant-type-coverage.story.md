---
title: "Cms — PHPStan wave2 constant type coverage"
type: story
module: Cms
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, typeCoverage, constantTypeCoverage, php83, wave2]
qmd: "cms phpstan wave2 constant type coverage resolvepage hasblocks"
related:
  - ./7.1.phpstan-paramtype-coverage.story.md
  - ./phpstan-cms-zero.story.md
  - ../../../../../docs/stories/16-14-type-coverage-costanti-al-sei-percento.md
---

# Cms — wave2: costanti tipizzate

## Scopo (prima dell'errore)

Cms risolve pagine JSON/Folio e renderizza blocchi tipizzati. `ResolvePageAction` collega
slug → modello Blog pubblicato; `HasBlocks` ammette solo espressioni link sicure nei
contenuti. Quelle costanti sono policy di routing/sicurezza contenuto, non decorazione.

## Inventario wave2

`/tmp/phpstan_by_module_w2/Cms.txt` — 5 × `constantTypeCoverage`
(`ResolvePageAction` ×3; `HasBlocks::SAFE_EXPRESSION` riportata anche via Page/Section).

## Fix

`const string` / `const array` su `BLOG_*` e `SAFE_EXPRESSION`. Nessun ignore/neon.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Cms --memory-limit=2G
# [OK] No errors
```
