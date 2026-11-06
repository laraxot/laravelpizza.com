---
title: "AI — PHPStan wave2 constant type coverage"
type: story
module: AI
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, typeCoverage, constantTypeCoverage, php83, wave2]
qmd: "ai phpstan wave2 constant type coverage classify ticket suggest solutions"
related:
  - ./phpstan-wave-coord.story.md
  - ./phpstan-ai-swarm-wave.story.md
  - ../scopo.md
  - ../../../../../docs/stories/16-14-type-coverage-costanti-al-sei-percento.md
---

# AI — wave2: costanti tipizzate

## Scopo (prima dell'errore)

AI classifica ticket e suggerisce soluzioni via LLM con cache e default sicuri quando il
modello non risponde JSON valido. `CACHE_TTL` e `DEFAULTS` in
`ClassifyTicketAction` / `SuggestSolutionsAction` sono il contratto di fallback: tipizzarli
impedisce di confondere TTL (int) e shape default (array).

## Inventario wave2

`/tmp/phpstan_by_module_w2/AI.txt` — 4 × `constantTypeCoverage`.

## Fix

`private const int CACHE_TTL` e `private const array DEFAULTS` in entrambe le Actions.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/AI --memory-limit=2G
# [OK] No errors
```
