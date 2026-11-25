---
title: "Module BMAD audit — Rating"
status: review
updated: 2026-11-16
module: Rating
bmad: true
qmd: "story BMAD audit modulo Rating inventario gate finding P1 rating_morph PHPStan Pest skip"
---
# Story: audit BMAD del modulo Rating

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

**Scopo:** sapere se il dato valutativo condiviso dalle schede è protetto dal database, prima di toccare codice.

## Acceptance

- [x] Inventario source-first misurato (2026-11-16) in [audits/rating-audit.md](../audits/rating-audit.md).
- [x] Finding P0/P1/P2 con `path:line`: 0 / 2 / 7.
- [x] Pack docs allineato: [audit](../audit.md), [epics](../epics.md), [decision-log](../decision-log.md), [architecture](../architecture.md), [ECC](../../ecc/rating-ecc-audit.md).
- [x] PHPStan `Modules/Rating`: 0 errori (level max).
- [ ] Pest modulo eseguito: **bloccato** (run completo timeout 420 s; singolo test >150 s a 1% CPU; `10.100.200.53:3306` irraggiungibile).
- [ ] P1 chiusi con regressione (Epic A in [epics](../epics.md)): migration additiva con unique e morphMap.

## Esito

Audit chiuso come documentazione; nessun codice o DB modificato. Prossime story: `rating-morph-integrita` (con query di sola lettura su duplicati/orfani prima della migration) e `rating-pulizia-residui` (da aprire in `docs/sprint-status.yaml`).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
