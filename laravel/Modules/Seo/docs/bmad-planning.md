---
title: "BMAD Planning — Seo"
type: bmad-planning
status: active
module: Seo
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, seo]
qmd: "bmad planning seo scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Rendere scopribili i contenuti pubblici comunali senza esporre ticket privati.

## Perché questo owner

- **Utenti:** SEO editor, crawler, guest
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- metadata contract
- canonical/sitemap
- social preview
- esclusione privati

### Out
- indicizzare pending/ticket privati
- ownership copy editoriale Blog

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Canonical locale/tenant | Seo |
| 2 | Sitemap freshness Blog/Cms | Seo + Blog/Cms |
| 3 | Exclusion matrix privacy | Seo + Fixcity |

## Filament blueprint

Resource/widget di competenza:

- (nessuna Resource Filament in questo owner)

Dettaglio contratto: [filament-blueprint.md](./bmad/filament-blueprint.md).

## Second brain

- Costituzione sintetica: questo file + brainstorming gemello.
- Decisioni durature -> `docs/bmad/decision-log.md` (o dossier topic se gia esiste).
- QMD: indicizzare titoli/qmd; ownership resta nel modulo/tema.

## Definition of Done (planning)

- [ ] Scope in/out condiviso e non contraddetto dal codice owner
- [ ] Onde senza dipendenze circolari cross-owner
- [ ] Blueprint Filament aggiornato (o esplicitamente N/A)
- [ ] Link bidirezionali ai dossier/topic gia esistenti
- [ ] Nessun artefatto in `bmad-output/`
