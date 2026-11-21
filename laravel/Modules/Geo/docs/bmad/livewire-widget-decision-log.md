---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget decision log"
issues: []
discussions: []
title: "Decision log — Geo"
type: decision-log
module: Geo
related:
  - ./livewire-inventory.md
---

# Decision log

## [2026-09-21] Test out, FO search stays

Docs only.

## [2026-09-21, audit] Drift worktree

Verifica repo-wide nell'inventario: i file di `Test` risultano di nuovo su disco (identici a HEAD) pur con story 12.1 `done`; `_components.json` registra solo l'alias `test` (cache parziale: `form-search-address-categories` assente). Decisione confermata: ritiro `Test`, esclusione `FormSearchAddressCategories`. Dettagli: [livewire-inventory.md](./livewire-inventory.md).
