---
title: "rating query with extra attributes scope.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "rating query with extra attributes scope.story"
issues: []
discussions: []
status: draft
---
# Story: rating-query-with-extra-attributes-scope

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
**Modulo**: Rating / IndennitaResponsabilita
**Epic**: usare `spatie/laravel-schemaless-attributes` tramite `scopeWithExtraAttributes`

## AC
- [x] Sostituire `Rating::where('extra_attributes->anno', $anno)->where('extra_attributes->type', $type)` con `Rating::withExtraAttributes(['anno' => $anno, 'type' => $type])`
- [x] Verificare che `BaseRating::scopeWithExtraAttributes()` usa il filtro schemaless
- [x] Aggiornare `IndennitaResponsabilitaResource.php` con la nuova sintassi
- [x] PHPStan (gate 5.181 / scope IR)

## Note
- `spatie/laravel-schemaless-attributes` già in `composer.lock` (^2.5.1)
- Chiusa 2026-09-23: codice IR già su `withExtraAttributes`; story era stale `ready-for-dev`
- Follow-up catalogo riusabile: [18.60](0004-rating-xls-fields-catalog.story.md) + arch [rating-xls-fields-reusable](../architecture/rating-xls-fields-reusable.md)
- Second brain: `bashscripts/ai/wiki/memories/architecture-models-actions.md#schemaless-attributes-query`


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
