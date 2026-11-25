---
title: "ratingdata ratingcontract typing.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ratingdata ratingcontract typing.story"
issues: []
discussions: []
status: draft
---
# BMAD: ratingdata-ratingcontract-typing

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
**Topic**: `RatingData` firme con `RatingContract`, `$ratingClass` obbligatorio

## Perché ho dimenticato BMAD
- Focus su `edit` (firme, import, assertion): dimenticato lo step BMAD prima della modifica.
- Standing order (`agent-standing-order.md`) richiede BMAD **prima** di ogni edit: ho saltato.
- Correzione: questa story documenta la scelta architetturale e il fix.

## Cosa è stato corretto
- `RatingData::getXlsFields(array $where, string $ratingClass)`: `$ratingClass` **non è più nullable**
- `Assert::implementsInterface($ratingClass, RatingContract::class)`: controllo sull'interfaccia,
  non su `BaseRating::class`
- `formFieldLabel()`, `ratingXlsValuePath()`, `ratingValuePath()`: parametri `RatingContract`
- `criteriaToXlsFields()`: `iterable` di `RatingContract`

## Perché RatingContract e non BaseRating
- `RatingContract` è l'interfaccia dichiarata da tutte le concrete
- `BaseRating` è il modello base; alcune concrete potrebbero non estenderlo direttamente
- `RatingData` è un DTO per dati, non per un host specifico: deve funzionare con qualsiasi `RatingContract`
- `Assert::implementsInterface` è il controllo corretto per un'interfaccia

## getClassName() limitation (2026-09-23)
- `Rating::getClassName()` usa `debug_backtrace()` → richiede un `object`
- Da `RatingData` (statico, senza istanza) fallirebbe
- Soluzione: `$ratingClass` obbligatorio, passato dal chiamante

## AC
- [x] Firme `RatingContract` in `RatingData`
- [x] `$ratingClass` obbligatorio in `getXlsFields`
- [x] `Assert::implementsInterface` con `RatingContract`
- [x] PHPStan `Modules/Rating` [OK]
- [x] Second brain aggiornato


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
