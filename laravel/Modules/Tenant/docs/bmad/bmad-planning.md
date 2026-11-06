---
title: "BMAD Planning: Tenant"
type: bmad-planning
status: active
module: Tenant
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, tenant]
qmd: "bmad planning tenant scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/brainstorming.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Isolare identita, contenuti, policy e configurazione provider per ogni comune.

## Perché questo owner

- **Utenti:** platform admin, comune tenant
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- risoluzione tenant context
- DomainResource
- confini config/provider

### Out
- inferire tenant da input user-controlled
- logica Ticket

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Resolution order immutabile | Tenant |
| 2 | Isolation evidence cross-module | Tenant |
| 3 | Provider config per comune | Tenant |

## Filament blueprint

Resource/widget di competenza:

- DomainResource

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
