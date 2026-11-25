---
tags: [phpstan, rating, tests]
issues: []
discussions: []
title: "PHPStan Rating: test su classi HasRatingResource rimosse e firma RatingsHostStub"
type: story
module: Rating
status: review
qmd: "phpstan rating tests class.notFound HasRatingResource StatsOverview RatingsRelationManager RatingsHostStub morphToManyX childReturnType"
related:
  - ./0069-phpstan-fix-rating.story.md
  - ../../stories/audit-qualita.story.md
  - ../../redundancy-report.md
  - ../../../tests/Fixtures/RatingsHostStub.php
  - ../../../tests/Unit/StatsOverviewWidgetTest.php
  - ../../../tests/Unit/RatingFilamentRelationManagerTest.php
---
# PHPStan Rating: 16 errori in 3 file di test

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

## Scopo

Azzerare 16 errori PHPStan (level max, senza baseline) nei test del modulo Rating,
capendo cosa i test proteggono prima di toccarli.

## Causa radice

| File | Errori | Causa |
|---|---|---|
| `tests/Fixtures/RatingsHostStub.php` | 1 | PHPDoc di `morphToManyX()` con `@template TPivot` e ritorno condizionale: incompatibile con `RelationX::morphToManyX()` che ritorna `MorphToMany<TRelatedModel, $this>` e non ha mai avuto un `pivotClass` tipizzato (lo conferma `HasRatingPivotTest`). |
| `tests/Unit/RatingFilamentRelationManagerTest.php` | 7 | importa `Filament\Resources\HasRatingResource\RelationManagers\RatingsRelationManager`, cancellata. |
| `tests/Unit/StatsOverviewWidgetTest.php` | 8 | importa `Filament\Resources\HasRatingResource\Widgets\StatsOverview`, cancellata. |

## Caso scelto

- RatingsHostStub: fix applicato (allineamento al parent, nessun cast, nessun `mixed`).
- Classi `HasRatingResource/*`: **caso (c)**, rimosse di proposito, test obsoleti. Nessun file di test toccato.

Prove:

- `dc010170d4^:.../HasRatingResource/RelationManagers/RatingsRelationManager.php` e
  `.../Widgets/StatsOverview.php` erano copie identiche delle classi vive (cambia solo namespace e
  un docblock): `Filament/RelationManagers/RatingsRelationManager.php`, `Filament/Widgets/StatsOverview.php`.
- `docs/redundancy-report.md` righe 25 e 67-70 le segnalava come duplicati; `0056-audit-qualita.story.md`
  riga 40 le rimuove come "orfani, senza Resource e senza riferimenti" (il controllo non ha visto i test).
- Nessun altro riferimento a `HasRatingResource` in `*.php` oltre ai due test.
- Il comportamento resta coperto dai test delle classi vive nello stesso file: colonne
  `id,title,pivot.user.name,value,is_winner,reward,updated_at` e stat `Tot Volume`/`Tot Player`.

## Decisione (approvazione umana, non mia)

Togliere dai due file i soli test dei duplicati, gli alias `use` e l'unione di tipo in
`ratingRelationManagerColumnNames()`. Alternativa scartata: ricreare i duplicati (DRY gia' risolto dall'audit).

Stato osservato a fine lavoro: i due file risultano gia' modificati e lockati da un'altra sessione
(rimozione degli `use` HasRatingResource in corso). Non toccati da questa story.

## File toccati

- `laravel/Modules/Rating/tests/Fixtures/RatingsHostStub.php` (solo PHPDoc di `morphToManyX()`).

## Verifica

- `php -l` RatingsHostStub: `No syntax errors detected`.
- PHPStan mirato su `tests/Fixtures` + 4 test che usano lo stub: `[OK] No errors`.
- Pest `HasRatingsTraitAccessorsTest` + `HasRatingsTraitRatingsByIdTest`: non eseguibile, 23 failed (0 assertions)
  per `TestDatabaseGuard` ("connection mysql -> host 10.100.200.53 is not local"). Skip documentato, nessun forzo.
- I 15 errori dei due test file restano aperti fino alla decisione sopra.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- `php -l` RatingsHostStub: `No syntax errors detected`.
- PHPStan mirato su `tests/Fixtures` + 4 test che usano lo stub: `[OK] No errors`.
- Pest `HasRatingsTraitAccessorsTest` + `HasRatingsTraitRatingsByIdTest`: non eseguibile, 23 failed (0 assertions)
  per `TestDatabaseGuard` ("connection mysql -> host 10.100.200.53 is not local"). Skip documentato, nessun forzo.
- I 15 errori dei due test file restano aperti fino alla decisione sopra.
