---
title: "No shared Xot empty.php route require"
status: done
updated: 2026-11-24
qmd: "empty.php routes require ADR UI Lang Cms"
---

# Story — no shared empty route file

## Why

`require base_path('Modules/Xot/routes/empty.php')` is cargo-cult: the file does not exist, adds cross-module coupling for zero routes, and arrived via unresolved merge markers.

## Done when

- [x] Conflict markers gone from UI/Lang/Cms route stubs
- [x] No `Xot/routes/empty` references under `Modules/`
- [x] ADR accepted: `docs/adr/no-shared-empty-route-file.md`
- [x] ADR index updated
