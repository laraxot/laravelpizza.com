---
title: "BMAD Planning: Notify"
type: bmad-planning
status: active
module: Notify
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, notify]
qmd: "bmad planning notify scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/brainstorming.md
  - ../../../Fixcity/docs/bmad/ticket-lifecycle-planning.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Consegnare messaggi multi-canale preference-aware con esiti osservabili.

## Perché questo owner

- **Utenti:** cittadino destinatario, operatore mittente, supervisor delivery
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- channel adapters
- template
- log esiti
- dispatch after-commit via Job

### Out
- decidere quando chiudere un Ticket
- mostrare header email grezzi in FO

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto intent + log esito | Notify |
| 2 | Integrazione comunicazioni Ticket | Notify + Fixcity |
| 3 | Preferenze cittadino + retry evidence | Notify + Fixcity |

## Filament blueprint

Resource/widget di competenza:

- NotificationResource
- MailTemplateResource
- NotificationLogResource

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
