---
title: "BMAD Planning: Job"
type: bmad-planning
status: active
module: Job
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, job]
qmd: "bmad planning job scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Eseguire import/export, notifiche e lavori schedulati in modo affidabile senza perdere transazioni.

## Perché questo owner

- **Utenti:** operatore batch, developer, supervisor code
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- after-commit dispatch
- idempotency/replay
- Filament job managers

### Out
- significato di dominio Ticket/Blog
- business rules nei job

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto after-commit + idempotency | Job |
| 2 | Failed job observability | Job |
| 3 | Import/export evidence | Job |

## Filament blueprint

Resource/widget di competenza:

- JobResource
- FailedJobResource
- ImportResource
- ExportResource

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
