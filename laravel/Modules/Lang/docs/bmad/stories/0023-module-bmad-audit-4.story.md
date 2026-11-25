---
title: "Module BMAD audit — Lang"
type: story
status: review
updated: 2026-11-16
module: Lang
bmad: true
qmd: "story BMAD audit modulo Lang inventario gate pest phpstan finding tracker chiavi mancanti test schema user_id"
related:
  - ../audits/lang-audit.md
  - ../epics.md
  - ../piano-miglioramento.md
---
# Story: audit BMAD profondo del modulo Lang

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

## Contesto

Audit source-first del modulo che deve tenere fuori dal codice ogni parola che l'utente legge ([purpose](../purpose.md)).

## Acceptance

- [x] Inventario misurato e finding con `path:line` ([audit profondo](../audits/lang-audit.md)).
- [x] Sintesi + gate ([audit](../audit.md)), checklist ([ECC](../../ecc/lang-ecc-audit.md)).
- [x] Gap-fill: [purpose](../purpose.md), [architecture](../architecture.md) (riscritta), [decision-log](../decision-log.md), [epics](../epics.md), [brainstorming](../brainstorming.md).
- [x] PHPStan `Modules/Lang`: 0 errori.
- [ ] Pest `Modules/Lang`: `tests/Feature` 10 pass / 13 fail (schema `user_id`, E2); `tests/Unit` non eseguito.
- [ ] E1–E5 chiuse con test di comportamento.

## Riferimenti

- [audit](../audit.md)
- [piano](../piano-miglioramento.md)
- [ECC](../../ecc/lang-ecc-audit.md)

## Task

1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.

1. Lock dei file di `docs/` del modulo (`bashscripts/lock/`), unlock a fine lavoro.
2. Audit codice → docs; nessun PHP toccato.
3. Pack ECC e indici aggiornati; `qmd update`.

## Esito

Baseline consegnata: 0 P0, 3 P1, P2 elencati. PHPStan sul tree `Modules` a 0; Pest e chiusura dei P1 aperti. Nota: esiste anche `0022-module-bmad-audit-lang-baseline-analisi-completa.story.md` (storica, nome datato: da migrare a una story senza data).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
