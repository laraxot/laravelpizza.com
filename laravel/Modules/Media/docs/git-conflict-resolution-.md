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
| `laravel/Modules/Media/docs/code-quality-improvement-report.md` | 1 | shorter_tiebreak=1 | `dd69871c8241` → `1753fade1da4` |
