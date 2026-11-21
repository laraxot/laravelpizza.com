---
tags: [documentation]
qmd: "git conflict resolution"
issues: []
discussions: []
title: "Audit collisioni Git committate in bashscripts"
type: concept
module: "Lang"
created: 2026-07-31
updated: 2026-07-31
---

# Audit collisioni Git committate in bashscripts

Risoluzione deterministica per singolo blocco: lato non vuoto, superset, metadata `updated` più recente, quindi HEAD come spareggio conservativo.

| File | Blocchi | Decisioni | SHA-256 prima → dopo |
|---|---:|---|---|
| `laravel/Modules/Lang/docs/code-quality-improvement-report.md` | 1 | shorter_tiebreak=1 | `5baf0963b27d` → `b23a2ea4e1cc` |
