---
title: "BMAD Planning: UI"
type: bmad-planning
status: active
module: UI
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, ui]
qmd: "bmad planning ui scopo onde filament"
related:
  - ./bmad/brainstorming.md
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Fornire un vocabolario UI accessibile condiviso invece di fork per-modulo.

## Perché questo owner

- **Utenti:** theme author, module developer
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- contratti presentazione/options
- enum/layout condivisi
- a11y primitives

### Out
- business validation
- Design Comuni page ownership

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Eliminare duplicazioni layout/trait | UI |
| 2 | Contratto componenti shared | UI + Sixteen |
| 3 | Gate a11y primitives | UI |

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
