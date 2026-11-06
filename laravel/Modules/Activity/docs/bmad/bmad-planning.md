---
title: "BMAD Planning: Activity"
type: bmad-planning
status: active
module: Activity
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, activity]
qmd: "bmad planning activity scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/brainstorming.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Offrire storia operativa affidabile per ogni mutazione di dominio rilevante.

## Perché questo owner

- **Utenti:** operatore PA, auditor, supervisor
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- emissione eventi da Actions owner
- viewer Filament paginato
- visibility pubblica/interna

### Out
- diventare ledger Ticket (TicketActivity in Fixcity)
- esporre note interne al FO

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto evento immutabile | Activity |
| 2 | Viewer/export admin | Activity |
| 3 | Retention/archive evidence | Activity + Tenant |

## Filament blueprint

Resource/widget di competenza:

- ActivityResource
- SnapshotResource
- StoredEventResource

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
