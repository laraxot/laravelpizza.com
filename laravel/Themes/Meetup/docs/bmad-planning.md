---
title: "BMAD Planning — Meetup"
type: bmad-planning
status: active
theme: Meetup
track: quick-flow
created: 2026-10-16
updated: 2026-10-16
tags: [bmad, planning, second-brain, filament-blueprint, meetup]
qmd: "bmad planning meetup scopo onde filament"
related:
  - ./bmad/bmad-dossier.md
  - ./bmad/README.md
  - ./bmad-brainstorming.md
  - ./bmad/filament-blueprint.md
---

# Obiettivo

Superficie demo/meetup: Actions dei moduli restano unica fonte di comportamento.

## Perché questo owner

- **Utenti:** partecipante demo
- **Track BMAD:** `quick-flow`
- **Religione:** Actions + Folio/Volt/Filament `XotBase*`; mai Controllers; docs solo in questo `docs/` (mai `bmad-output/`).

## Scope

### In
- classificazione demo vs journey supportati
- guard dati privati

### Out
- candidate matrix FixCity primaria
- duplicare Ticket

## Onde di delivery

| Wave | Deliverable | Owner |
|---|---|---|
| 1 | Classificazione esplicita demo | Meetup |
| 2 | Smoke route approvate | Meetup |
| 3 | No private data rendering | Meetup |

## Filament blueprint

Resource/widget di competenza:

- nessuna Resource; solo eventuale mount widget owner

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
