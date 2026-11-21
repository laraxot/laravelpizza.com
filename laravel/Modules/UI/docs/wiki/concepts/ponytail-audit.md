---
title: "Ponytail audit — modulo UI"
type: concept
tags: [ponytail, over-engineering, ui, cleanup]
created: 2026-07-01
updated: 2026-07-01
qmd: "ponytail audit UI modulo stub config archive root md"
issues:
  - "https://github.com/laraxot/base_predict_fila5/issues/221"
discussions:
  - "https://github.com/laraxot/base_predict_fila5/discussions/222"
related:
  - ../../ponytail-audit-over-engineering.md
  - module-root-uppercase-folders-archive.md
---

# Ponytail audit — UI

**Run:** 2026-07-01 · **Scope:** over-engineering (non bug/sicurezza).

Documento canonico: [ponytail-audit-over-engineering.md](../../ponytail-audit-over-engineering.md)

## Chiuso (run #3 — 2026-07-01)

- `MapServiceContract`, `GeocodingServiceContract`, `NullMapService`, `NullGeocodingService` — layer senza consumer
- `Config/` maiuscolo + `Config.bak/` — duplicato di `config/`; rimosso, resta solo `config/`
- `docs/archive/` — ~144 file duplicati sessione; bonificati verso `docs/wiki/`
- stub root modulo — `*.md` / `*.txt`, `_docs/`, `docs/root-md-files/`, `docs/root-txt-files/` rimossi; link `widgets.md` → `widget-optimization.md`

## Hub

- [docs/audit/ponytail-audit.md](../../../../../../docs/audit/ponytail-audit.md)
- [ponytail-audit-remediation.md](../../../../../../docs/project/ponytail-audit-remediation.md)
