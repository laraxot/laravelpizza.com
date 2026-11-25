---
type: note
tags: [documentation]
issues: []
discussions: []
id: "rating-readme-conflict-markers"
title: "Rating: marker nidificati in README"
status: review
scope: module:Rating
created: 2026-09-22
updated: 2026-09-22
qmd: "rating readme nested conflict markers laravel 13 not 12"
related:
  - ../../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---
# Rating: README con marker nidificati

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

**Perché.** HEAD README aveva hunk vuoti su HEAD e `<<<<<<<` dentro theirs (badge Laravel 12 vs 13).

## Scelta

Strip marker; togliere badge Laravel 12 (stack = Laravel 13).

**Non toccato:** `tests/Unit/HasRatingsTraitRatingsByIdTest.php` e `.gitattributes` (staged, altra sessione: PHPStan 9 errori lì).

## Gate

README senza `<<<<<<<`. PHPStan modulo intero rosso solo sul test WIP altrui. Commit deferred.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
