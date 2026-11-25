---
title: "rating statics to ratingdata consolidation.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "rating statics to ratingdata consolidation.story"
issues: []
discussions: []
status: draft
---
# Story: consolidamento helper statici: trait → `RatingData`

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
**Modulo**: Rating (+ repoint in IR, tests)
**Epic**: rating-entity-helpers-home-in-ratingdata
**Related**: `0092-rating-xls-fields-move-to-ratingdata.story.md` · `5.229` · `5.230` · `../architecture/ratingdata-getxlsfields-caller-resolve.md` · `../architecture/form-field-label-and-xls-path-home.md` (**superato** da ordine utente diretto)

## Regola utente (nuovo vincolo canon)

> Chiamare metodi statici di un trait via `HasRatingsTrait::metodo()` = da evitare.
> Il trait è un mixin da `use`, non una classe statica: la chiamata come
> "namespace" maschera la sede reale, rompe tracciabilità IDE/PHPStan e il
> modello mentale di ownership. Sede: classe `Spatie\LaravelData\Data`
> (qui `RatingData`).

Nota: `architecture/form-field-label-and-xls-path-home.md` (accepted) argomentava
il contrario (helper nel trait, 15-22% per Data): **sovrascritto da ordine
utente diretto**; il doc va marcato superato.

## Fatto

- `ratingFieldName` mosso in `RatingData` (mancava ancora)
- Rimossi dal trait: `ratingValuePath`, `ratingXlsValuePath`, `formFieldLabel`,
  `ratingFieldName` (doppia SSoT chiusa)
- `self::` interni al trait → `RatingData::` (dipendenza trait→Data, un verso)
- `criteriaToXlsFields` vive solo in `RatingData` (copia trait già rimossa)
- `selectIsOther` resta private nel trait (interno, non API)
- Chiamanti ripuntati: `DecoratesRatingFormFields`, `CompilaIndennitaResponsabilita`,
  6 file di test (incluse chiamate via host class `IndennitaResponsabilita::` /
  `RatingsHostStub::`: stessa violazione, il metodo non è più nel trait)

## Bug trovato e risolto (ordine "trappole → BMAD")

`getRatingsByIdAttribute()` (trait): fallback per pivot orfana chiamava
`Rating::getClassName()` → `RuntimeException` quando il caller non è in
`Models\`/`Filament\Resources\` (fixture `RatingsHostStub` in `Tests\Fixtures`,
2 test `HasRatingsTraitRatingsByIdTest` fallivano). Fix fail-soft: `try/catch`
→ `Rating::class` piattaforma: è solo un carrier in-memory (`->id` + accessors
`BaseRating`), mai interrogato.

## Gate

- `php -l` OK su tutti i file toccati
- PHPStan sui 10 file toccati: `[OK] No errors` (post-Pint, `/tmp/phpstan` svuotato)
- Pest: **47 passed** (105 assertions): inclusi i 2 test precedentemente rotti
- `pint`: 8 issue stile sistemate (import, braces)
- Marker sweep `rg '^(<<<<<<<|>>>>>>> |=======)' Modules --glob '*.php'`: vuoto
- Test rinominati: `HasRatingsTraitFormFieldLabelTest` → `RatingDataFormFieldLabelTest`,
  `HasRatingsTraitCriteriaToXlsFieldsTest` → `RatingDataCriteriaToXlsFieldsTest`

## Esito

SSoT unica: helper statici rating SOLO in `RatingData`. Il trait conserva i
metodi di istanza host (relazioni, form schema, hydrate/sync) e delega ai
vocab `RatingData::`: dipendenza a senso unico trait→Data. `Rating::class`
esplicito resta canon al call-site Resource (story 5.232, subclass IR per
connection dedicata); `resolveRatingClassFromCaller()` resta fallback.

## Verifica swarm 2026-09-24 (cursor-swarm-rating)

- API su `RatingData` presente e allineata ai callers/test:
  `ratingFieldName`, `formFieldLabel`, `ratingValuePath`, `ratingXlsValuePath`,
  `criteriaToXlsFields`, `getXlsFields` (corpo reale, no facade).
- Trait: zero static API name-collision; chiama solo `RatingData::`.
- `RatingPhpstanTraitProbe` rimosso (regola no-phpstan-probe-models);
  `HasRating::getArrayRatingsWithImage` return = `list<array<string, mixed>>`.
- `RatingsHostStub` + `AbstractRatingsHost`: `@property-read ratings_by_id`.
- `tests/AuditCoverage/` assente; già in `.gitignore`.
- PHPStan `Modules/Rating`: **0 errori**.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- API su `RatingData` presente e allineata ai callers/test:
  `ratingFieldName`, `formFieldLabel`, `ratingValuePath`, `ratingXlsValuePath`,
  `criteriaToXlsFields`, `getXlsFields` (corpo reale, no facade).
- Trait: zero static API name-collision; chiama solo `RatingData::`.
- `RatingPhpstanTraitProbe` rimosso (regola no-phpstan-probe-models);
  `HasRating::getArrayRatingsWithImage` return = `list<array<string, mixed>>`.
- `RatingsHostStub` + `AbstractRatingsHost`: `@property-read ratings_by_id`.
- `tests/AuditCoverage/` assente; già in `.gitignore`.
- PHPStan `Modules/Rating`: **0 errori**.
