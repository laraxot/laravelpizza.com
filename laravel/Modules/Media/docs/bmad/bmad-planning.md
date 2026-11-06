---
title: "BMAD Planning: Media"
type: bmad-planning
status: active
module: Media
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, media]
qmd: "bmad planning media scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ../../../Fixcity/docs/bmad/ticket-lifecycle-blueprint.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Conservare evidenze e conversioni validate senza trasformare i media personali in dati incontrollati.

## Perché questo owner

- **Utenti:** cittadino upload, operatore, moderatore
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- lifecycle file/storage
- conversioni
- allowlist serializer pubblici

### Out
- significato allegato Ticket (owner Fixcity)
- seconda store timeline_attachments

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Contratto collection Spatie per Ticket/Blog | Media + Fixcity/Blog |
| 2 | Nome sicuro + size policy | Media |
| 3 | Evento media_added nel ledger owner | Media + Fixcity |

## Filament blueprint

Resource/widget di competenza:

- MediaResource
- TemporaryUploadResource

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
