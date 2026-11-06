---
title: "BMAD Planning — Cms"
type: bmad-planning
status: active
module: Cms
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, cms]
qmd: "bmad planning cms scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Far gestire a ogni comune pagine, menu, blocchi e contenuti di servizio localizzati.

## Perché questo owner

- **Utenti:** editor CMS, guest, tenant admin
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- authoring Page/Section/Menu
- preview/publish
- locale fallback
- cache invalidation

### Out
- logica Ticket
- theme ownership delle view Folio

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto blocchi header/footer/home | Cms + Sixteen |
| 2 | Preview/publish + cache | Cms |
| 3 | Isolamento tenant evidence | Cms + Tenant |

## Filament blueprint

Resource/widget di competenza:

- PageResource
- SectionResource
- MenuResource

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
