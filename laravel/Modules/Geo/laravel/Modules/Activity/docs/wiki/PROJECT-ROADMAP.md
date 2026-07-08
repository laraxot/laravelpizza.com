---
title: "Activity — roadmap modulo"
type: overview
tags: [activity, roadmap, audit-log, phpstan, pest]
created: 2026-06-13
updated: 2026-06-13
qmd: "Activity roadmap audit log completamento modulo"
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/18"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/16"
related:
  - overviews/completion-status.md
  - concepts/phpstan-pest-discipline.md
  - ../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md
---

# Activity — roadmap modulo

> Roadmap **solo Activity**. Per la piattaforma intera: [platform-completion-roadmap](../../../Xot/docs/wiki/overviews/platform-completion-roadmap.md).

## Stato attuale

| Area | Stato |
|------|-------|
| PHPStan L10 | ✅ |
| TestCase → XotBaseTestCase | ✅ |
| Migrazione singola `activity_log` | ✅ |
| Test Actions con Assert | ✅ (2026-06-13) |

## Milestone modulo

1. **Pest green** — suite `tests/Unit/Actions` + feature con DB test
2. **Coverage Actions** — `ActivityLogger`, `Log*Action` ≥80% linee critiche
3. **Hook dominio Fixcity** — log automatico su ticket workflow
4. **Filament** — resource Activity read-only per admin

## Regole

- Actions + `QueueableAction`, no Services
- Test: Pest + `Assert::assert*()` per PHPStan
- [completion-status](overviews/completion-status.md) aggiornato a ogni sprint
