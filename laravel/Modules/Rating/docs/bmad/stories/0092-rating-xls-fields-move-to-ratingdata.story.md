---
title: "rating xls fields move to ratingdata.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "rating xls fields move to ratingdata.story"
issues: []
discussions: []
status: draft
---
# Story: `ratingXlsFields` → `RatingData::getXlsFields` (mossa reale, no facade)

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
**Modulo**: Rating (+ commento in IR Resource)
**Epic**: export-xls-ratings
**Related**: `18.60-rating-xls-fields-catalog.story.md` · `0093-rating-xls-fields-ratingclass-required.story.md` · `../../../../IndennitaResponsabilita/docs/bmad/stories/5.179-rating-xls-fields-reusable-component.story.md`

## Perché la facade era "merda" (ordine utente)

`RatingData::getXlsFields` era 3 righe: `Assert` + forward identico a
`HasRatingsTrait::ratingXlsFields`: **indirezione senza astrazione**:

- due firme identiche da tenere in sync (il null-trap era nato proprio lì);
- docblock duplicato che mentiva ("SSoT nel trait" + "API pubblica qui" insieme);
- zero adattamento: non aggiungeva tipizzazione, cache, naming: solo un hop.

Peggio di entrambe le alternative (tutto nel trait OPPURE tutto in RatingData).

## Decisione

`RatingData` = casa del **catalogo export rating** (query schemaless + filtro
criteri + eager children). Il trait tiene `criteriaToXlsFields` + i path helper
(`ratings_by_id` = layout host: SSoT corretto lì). Confine:

- **RatingData**: QUALI rating (query `withExtraAttributes`, `parent_id null`)
- **Trait**: COME si mappano a path/label dell'host

## Fatto (stato finale dopo race con agente parallelo)

- `RatingData::getXlsFields(array $where, string $ratingClass)` = **corpo reale**
  (query `withExtraAttributes` + reject `parent_id` + `loadMissing('children')`)
- `HasRatingsTrait::ratingXlsFields` rimosso: nessun altro caller
- `HasRatingsTrait::criteriaToXlsFields` **resta nel trait** (decisione canon
  dell'agente parallelo, `architecture/rating-xls-fields-home-in-ratingdata.md`):
  il mapper vive coi suoi vocab helper `formFieldLabel`/`ratingXlsValuePath`/
  `ratingValuePath`: delega *significativa*, non facade
- Confine finale: **RatingData** = QUALI rating (query+filtro);
  **trait** = COME si mappano a path/label host

### Race documentata

Edit concorrenti 14:04–14:08: l'altro agente ha copiato `criteriaToXlsFields`
in RatingData E lasciato l'originale nel trait (doppia SSoT), poi ha deciso
trait-side e fatto puntare `getXlsFields` a `HasRatingsTrait::`: mentre io
rimuovevo il blocco dal trait → call a metodo inesistente per ~1 min.
Risolto ripristinando la versione trait + test (`HasRatingsTrait::`), che è
anche il confine canon documentato.

## Gate

- `php -l` ×3 ✅ · `pint` 3 file (1 fix) ✅
- PHPStan RatingData + HasRatingsTrait + IR Resource → `[OK] No errors`
- Pest `HasRatingsTraitCriteriaToXlsFieldsTest` + IR `GetXlsFieldsTest` → **5 passed / 10 assertions**


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
