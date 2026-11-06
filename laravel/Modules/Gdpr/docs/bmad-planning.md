---
title: "BMAD Planning — Gdpr"
type: bmad-planning
status: active
module: Gdpr
track: bmad-method
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, gdpr]
qmd: "bmad planning gdpr scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Rendere consenso, trattamenti, revoca, export e cancellazione evidenze comprensibili e tenant-owned.

## Perché questo owner

- **Utenti:** cittadino interessato, DPO/tenant admin, operatore
- **Track BMAD:** `bmad-method`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- Consent/Treatment resources
- evidence Actions
- subject rights flows

### Out
- interpretazione legale inventata dall'agente
- mix con policy Ticket

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Semantica acknowledgement tenant | Gdpr |
| 2 | Diritti interessato export/delete | Gdpr + User |
| 3 | Retention evidence | Gdpr |

## Filament blueprint

Resource/widget di competenza:

- ConsentResource
- TreatmentResource

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
