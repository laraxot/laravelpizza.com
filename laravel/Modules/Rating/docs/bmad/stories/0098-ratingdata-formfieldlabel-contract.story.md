---
title: "ratingdata formfieldlabel contract.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ratingdata formfieldlabel contract.story"
issues: []
discussions: []
status: draft
---
# BMAD: ratingdata-formfieldlabel-contract

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

**Status**: done + review
**Modulo**: Rating
**Perché ho dimenticato BMAD**: focus su `getXlsFields` e `ratingClass`: non ho
esteso il ragionamento alle firme dei metodi helper (`formFieldLabel`,
`ratingXlsValuePath`, `ratingValuePath`). Corretto con questa story.

## Perché `RatingContract` invece di `BaseRating`
- `BaseRating` è il modello base; `RatingContract` (`interface`) è il contratto
  che tutte le concrete implementano (`Ptv\Models\Rating`, `Progressioni`...)
- `RatingData` è un DTO per dati, non per un host specifico: deve funzionare
  con qualsiasi `RatingContract`, non solo `BaseRating`.
- `formFieldLabel()` non usa niente di specifico a `BaseRating`: solo `txt` e
  `title`, che sono parte del contratto (`RatingContract`).

## AC
- [x] Firme `formFieldLabel()`, `ratingXlsValuePath()`, `ratingValuePath()`
      aggiornate da `BaseRating` a `RatingContract`
- [x] `RatingData` non dipende più dal concreto `BaseRating` per le firme
- [x] PHPStan passa con `RatingContract` come tipo parametro


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
