---
title: "git conflict resolution 2026 07 31"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "git conflict resolution 2026 07 31"
issues: []
discussions: []
---

# Audit collisioni Git committate in bashscripts

Risoluzione deterministica per singolo blocco: lato non vuoto, superset, metadata `updated` più recente, quindi HEAD come spareggio conservativo.

| File | Blocchi | Decisioni | SHA-256 prima → dopo |
|---|---:|---|---|
| `laravel/Modules/Xot/docs/code-quality-report.md` | 1 | head_nonempty=1 | `666768de724c` → `3aeb89cb4b1d` |
| `laravel/Modules/Xot/docs/git-push-resolution-2026-07-28.md` | 1 | shorter_tiebreak=1 | `933dfd43c7b1` → `c6e1a2cfc2f8` |
| `laravel/Modules/Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md` | 1 | newer_metadata=1 | `63ddce6fcb95` → `e6e79518ed7e` |
