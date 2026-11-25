---
title: "rating xls fields ratingclass required.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "rating xls fields ratingclass required.story"
issues: []
discussions: []
status: draft
---
# Story: `ratingXlsFields`/`RatingData::getXlsFields`: `$ratingClass` required

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

**Status**: done
**Modulo**: Rating (+ call site IR)
**Epic**: export-xls-ratings
**Related**: `../architecture/rating-xls-fields-reusable.md` · `18.60-rating-xls-fields-catalog.story.md` · `../../../../IndennitaResponsabilita/docs/bmad/stories/5.179-rating-xls-fields-reusable-component.story.md` (§11: trappola segnalata da Devin)

## Bug/trappola (found by Devin, fix mandatorio per standing order)

Firma `?string $ratingClass = null` con `??= Rating::getClassName()`:

- `getClassName()` richiede `['object']` nel backtrace → da contesto **statico**
  (l'unico call site reale, Resource Filament) lancia `RuntimeException`.
- Il parametro **sembrava** opzionale ma era di fatto obbligatorio → firma mente:
  `RatingData::getXlsFields($where)` compila e **esplode a runtime**.

## Fix

`class-string<BaseRating> $ratingClass` **required** in entrambe le firme;
rimosso il fallback `??= Rating::getClassName()`. Chi chiama da contesto istanza
può passare `Rating::getClassName()` esplicito (lì funziona).

Callers verificati pre-fix: solo `RatingData` (pass-through) e
`IndennitaResponsabilitaResource` (passa `Rating::class`). Nessun test sul
default nullable → cambio sicuro.

## Futuro (fuori scope)

Abilitare davvero la firma a 1 argomento = estendere
`XotBaseModel::getClassName()` ai frame statici (`['class','type'=>'::']` in
`Models\`/`Filament\Resources\`): story dedicata, regression fleet.

## Gate

- `php -l` entrambi i file
- PHPStan `Modules/Rating` + `Modules/IndennitaResponsabilita` → 0 errori
- Pest `HasRatingsTraitCriteriaToXlsFieldsTest` +
  `IndennitaResponsabilitaResourceGetXlsFieldsTest` / `ResourceLegacySchemaTest`


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
