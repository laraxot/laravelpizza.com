---
title: "BMAD Planning — Geo"
type: bmad-planning
status: active
module: Geo
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, geo]
qmd: "bmad planning geo scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Catturare posizione affidabile anche quando il cittadino nega il GPS o serve inserimento manuale.

## Perché questo owner

- **Utenti:** cittadino, operatore mappa, Mobile host
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- normalizzazione coordinate/indirizzi
- fallback provider
- precision policy pubblica

### Out
- ownership Ticket
- map UI Design Comuni nel modulo

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Capture + fallback timeout | Geo |
| 2 | Privacy precision pubblica | Geo + Fixcity |
| 3 | Attribution provider evidence | Geo |

## Filament blueprint

Resource/widget di competenza:

- AddressResource
- LocationResource

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
