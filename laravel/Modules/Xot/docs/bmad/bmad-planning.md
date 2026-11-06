---
title: "BMAD Planning: Xot"
type: bmad-planning
status: active
module: Xot
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, xot]
qmd: "bmad planning xot scopo onde filament"
related:
  - ./bmad/brainstorming.md
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Infrastruttura Laraxot stabile (XotBase*, contratti, tenancy) senza diventare discarica di dominio.

## Perché questo owner

- **Utenti:** tutti i moduli/temi
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- XotBase Resource/Widget/Action/Model
- convenzioni migration/tenancy
- shared only se riuso provato

### Out
- regole Ticket/Blog/Gdpr
- god-object utilities

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Gate estensioni XotBase only | Xot |
| 2 | Docs convenzioni Filament | Xot |
| 3 | Audit shared vs domain dump | Xot |

## Filament blueprint

Resource/widget di competenza:

- XotBaseResource
- ModuleResource
- LogResource

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
