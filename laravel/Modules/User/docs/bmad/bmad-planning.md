---
title: "BMAD Planning: User"
type: bmad-planning
status: active
module: User
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, user]
qmd: "bmad planning user scopo onde filament"
related:
  - ./project-context.md
  - ./brainstorming.md
  - ./filament-ux-brainstorming.md
  - ../bmad-brainstorming.md
  - ./filament-blueprint.md
---

# Obiettivo

Identita e autorizzazione permettono a cittadini e PA di agire in sicurezza nel proprio tenant.

## Perché questo owner

- **Utenti:** cittadino, operatore PA, super-admin
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- UserContract/policies
- auth Folio/Volt/Filament widgets
- ruoli Spatie

### Out
- nuovi Controllers
- ownership Ticket
- label() hardcoded

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Auth surfaces XotBaseWidget | User |
| 2 | Ruoli/policy consumer Fixcity | User + Fixcity |
| 3 | Socialite/device boundaries | User |

## Filament blueprint

Resource/widget di competenza:

- BaseUserResource
- BaseProfileResource
- AuthenticationLogResource

Dettaglio contratto: [filament-blueprint.md](./filament-blueprint.md).

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