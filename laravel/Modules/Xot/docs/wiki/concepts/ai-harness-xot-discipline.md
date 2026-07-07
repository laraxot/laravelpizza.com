---
title: "AI harness — disciplina agenti modulo Xot (canon)"
type: concept
module: Xot
tags: [xot, ai, harness, xotbase, phpstan, second-brain]
created: 2026-06-05
updated: 2026-06-05
qmd: "xot ai harness xotbase phpstan quality gate second brain canonical module"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - ./second-brain-local-discipline.md
  - ./xot-architecture-guardrails.md
  - ../../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../../../docs/wiki/bmad/architecture.md
---

# AI harness — Xot (canon moduli)

Xot è **owner** del contratto second-brain locale per tutti i moduli Laraxot.

## Canon

- [second-brain-local-discipline.md](./second-brain-local-discipline.md) — stub negli altri moduli puntano qui
- [mappa HackerNoon root](../../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)

## Tip + XotBase

| Tip | Xot |
|-----|-----|
| 012 | Capire XotBase inheritance prima di estendere Filament/Laravel diretto |
| 015 | Mai `Resource`/`Widget` Filament naked — `XotBaseResource`, `XotBaseSchemaWidget` |
| 022 | PHPStan L10 da `laravel/`; `XotBaseMigration` per migrate |

## Quality gate post-edit PHP

```bash
cd laravel && ./vendor/bin/phpstan analyse --level=10 path/to/file.php
```

## Checklist agente (canon)

| Tip | Xot |
|-----|-----|
| 004/014 | Stub bootstrap ≤50 righe; regole in wiki |
| 012/015 | XotBase only — no Filament/Laravel naked |
| 020 | Canon `second-brain-local-discipline.md` — stub negli altri moduli |
| 022 | PHPStan L10, quality-gates, `XotBaseMigration` |

Prompt: [llm-wiki.txt](../../../../../../bashscripts/tools/prompts/llm-wiki.txt)

## Collegamenti

- [xot-architecture-guardrails.md](./xot-architecture-guardrails.md)
- [migration-update-timestamps-only.md](./migration-update-timestamps-only.md)
- [second-brain-local-discipline.md](./second-brain-local-discipline.md)
