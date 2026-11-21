---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "git conflict resolution"
issues: []
discussions: []
title: "Audit collisioni Git committate in bashscripts"
type: report
module: Notify
created_at: '2026-07-31'
updated_at: '2026-07-31'
---

# Audit collisioni Git committate in bashscripts

Risoluzione deterministica per singolo blocco: lato non vuoto, superset, metadata `updated` più recente, quindi HEAD come spareggio conservativo.

| File | Blocchi | Decisioni | SHA-256 prima → dopo |
|---|---:|---|---|
| `laravel/Modules/Notify/docs/index.md` | 2 | newer_metadata=1, shorter_tiebreak=1 | `b6ff7585314d` → `b8a49d9ca9f6` |
