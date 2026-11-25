---
title: "Rating 2.6: rimozione silenziatori PHPStan e ripristino fix static-call regredito"
type: story
status: in-progress
created: 2026-10-15
updated: 2026-10-15
module: Rating
epic: 2
story_id: "RATING-2.6"
slug: phpstan-silencer-removal-regression-fix
tags: [phpstan, silencer-removal, method-staticCall, return-type, forward-only]
related:
  - ./0039-ratingfilamentschematest-instance-call-fix.story.md
  - ./0042-phpstan-fix-morphto-genericity-and-parent-id-test.story.md
  - ./0049-rating-contract-al-posto-di-baserating.story.md
  - ./0038-dod-full-closure-typecoverage-phpmd.story.md
qmd: "2 6 phpstan silencer removal regression"
---
# Story RATING-2.6: rimozione silenziatori PHPStan e ripristino fix regredito

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

## Richiesta

Swarm PHPStan sul perimetro `laravel/Modules/Rating/`: zero errori con tipi veri,
**mai** `@phpstan-ignore`, baseline, probe `*PhpstanTraitProbe`, `@var` silenziatore;
forward-only; Action non Service; test solo in `Modules/Rating/tests/`;
type-hint su contratti (`RatingContract`, mai `BaseRating`).

## Scopo ricostruito (per famiglia)

Il modulo risultava "verde" solo grazie a silenziatori vietati dai vincoli, e due fix
precedenti erano stati silenziosamente regrediti da sessioni parallele (stesso pattern
della story `phpstan-rating-fix.md`, follow-up 2026-09-21: un merge aveva scartato il fix
`c0c8d84` su `HasRatingContract::ratings()`).

1. **`BaseRating::linkedTo()`: `@phpstan-ignore return.type` (regressione di 5.85).**
   La story 5.85 aveva fissato il docblock su `MorphTo<..., static>`; una sessione
   successiva lo ha riportato a `MorphTo<Model, BaseRating>` aggiungendo l'ignore.
   Causa radice: Larastan inferisce `morphTo()` come `MorphTo<Model, static>`
   (vedi stub `vendor/larastan/larastan/stubs/common/MorphTo.stub`:
   `@template TRelatedModel`, `@template TDeclaringModel`), quindi il dichiarante
   concreto `BaseRating` non coincide mai con `static` e l'errore `return.type` è reale.
2. **`HasRating` / `RatingTrait`: `@phpstan-ignore trait.unused` (cargo-cult).**
   Nessuna estensione installata emette `trait.unused` (in `vendor/phpstan` ci sono solo
   core + deprecation-rules; Larastan e pest-plugin-type-coverage non hanno tale regola):
   gli ignore non corrispondono ad alcun errore reale e violano i vincoli in ogni caso.
   `HasRating` ha comunque un consumer analizzato in `tests/Fixtures/HasRatingHostStub.php`
   (i test sono dentro il gate: `excludePaths` non esclude `tests/`).
3. **`RatingPhpstanTraitProbe`: probe vietato, ridondante.**
   Esiste già `tests/Fixtures/HasRatingHostStub.php` con lo stesso scopo dichiarato
   ("senza un consumer reale PHPStan non analizza il corpo del trait"). Il probe in
   `app/` è proibito dal prompt 11-phen (`probe *PhpstanTraitProbe`).
4. **`HasLikes::dislikedBy()`: `@var Like` bugiardo.**
   `first()` su `MorphMany<Like, ...>` restituisce `?Like`; il `@var Like` affermava il
   non-null su un valore che il codice stesso testa contro `null`. Narrowing reale con
   `instanceof`, comportamento identico.
5. **`RatingFilamentSchemaTest`: 3× `@phpstan-ignore-next-line` + static-call
   (regressione di 2.5).** La story 2.5 aveva già convertito le chiamate statiche a
   metodi d'istanza (`method.staticCall`); il file attuale le riporta statiche con ignore.
   Ripristinato il fix 2.5 verbatim ed esteso ai call site gemelli non coperti allora
   (`$classe::getInfolistSchema()`, `$classe::getFormColumns()`, `$classe::getSteps()`),
   che a runtime solleverebbero `Error: Non-static method cannot be called statically`.

## Modifiche (solo `laravel/Modules/Rating/`)

| file | prima | dopo |
|---|---|---|
| `app/Models/BaseRating.php` (`linkedTo()`) | `@return MorphTo<Model, BaseRating>` + `// @phpstan-ignore return.type` | `@return MorphTo<Model, $this>`, rimosso ignore, nota why di una riga (stessa forma delle gemelle verdi `BaseRatingMorph::model()` e `Like::likeable()`) |
| `app/Models/Traits/HasRating.php` | `/** @phpstan-ignore trait.unused (...) */` | rimosso (resta `@phpstan-require-extends Model`) |
| `app/Models/Traits/RatingTrait.php` | `/** @phpstan-ignore trait.unused (...) */` | rimosso |
| `app/Models/Traits/HasLikes.php` (`dislikedBy()`) | `/** @var Like */` + `null !== $where` | `instanceof Like`, nessun `@var` |
| `tests/Unit/RatingFilamentSchemaTest.php` | 3× `@phpstan-ignore-next-line` + `Classe::metodo()` statico su metodi d'istanza | `(new RatingForm())->getFormSchema()`, `(new RatingMorphForm())->getFormSchema()`, `(new $classe())->getInfolistSchema()` / `->getFormColumns()` / `->getSteps()`; `@var list<class-string<XotBaseResourceForm>>` e `<XotBaseResourceInfolist>`; +2 import Xot |

Non toccati di proposito (coerenti con i vincoli, nessun errore noto):

- `@var` di narrowing su Mockery (`Mockery\MockInterface&...`) nei test: tipizzazione reale
  dei mock, non silenziatori: rimuoverli introdurrebbe errori.
- `@var` con generics in `HasRatingsTrait` (`MorphToMany<BaseRating, TModel, ...>` dopo
  `Assert::implementsInterface`): portano informazione generica non altrimenti deducibile;
  la conversione a `RatingContract` nei generics resta aperta dalla story 5.93 (bloccata da
  decisione, non da dimenticanza).
- `StatsOverview` (entrambi): DNF `(Model&HasRatingContract)|null` + `Assert` narrowing —
  pattern documentato in 2.4 come vincolo di framework, non degradare il tipo.
- `use Eloquent;` / `@mixin Eloquent` nei model: risolvono via ide-helper del repo, nessun
  `class.notFound` noto.
- Assertion di contenuto driftata (`il form del rating dichiara i campi attesi` si aspetta
  5 chiavi, il form ne dichiara 6 con `parent_id`): failure Pest pre-esistente già
  segnalata in 2.5 come fuori scope PHPStan: non toccata (precedente 2.5: non fissare il
  contenuto fuori `owned_scope`).

## Verifica

- `php -l`, `phpstan analyse Modules/Rating`, Pest mirato: **non eseguibili in questa
  sessione** (nessun tool di shell disponibile nell'ambiente: `bash` integrato risponde
  `DAYTONA_API_KEY is not set`). Ogni edit è stato ricontrollato rileggendo il file
  modificato (diff + lettura integrale del test).
- Verifiche richieste al coordinatore / sessione con shell (handoff):
  `cd laravel && php -l Modules/Rating/app/Models/BaseRating.php` (× ogni file toccato),
  `./vendor/bin/phpstan analyse Modules/Rating --no-progress --memory-limit=-1`,
  `./vendor/bin/pest Modules/Rating/tests/Unit/RatingFilamentSchemaTest.php --no-coverage`,
  e gate canonico `analyse Modules` intero (le soglie `typeCoverage.*` valgono solo lì).
- Atteso: 0 errori; in particolare nessun `method.staticCall`, nessun `return.type` su
  `linkedTo()`, nessun `reportUnmatchedIgnoredErrors` sui `trait.unused` rimossi.

## Decisioni

- D1: gli ignore si rimuovono sempre, anche quando "funzionano": il vincolo utente
  (`MAI @phpstan-ignore`) non ammette eccezioni e due di essi coprivano regressioni reali.
- D2: per `linkedTo()` si allinea alla gemella verde (`MorphTo<Model, $this>`), non si
  inventa un terzo docblock: una famiglia, una radice, un fix.
- D3: il probe `RatingPhpstanTraitProbe.php` **non è stato cancellato qui**: nessuno
  strumento di questa sessione può eliminare file (no shell, no delete tool). Handoff
  esplicito: un `rm laravel/Modules/Rating/app/Models/RatingPhpstanTraitProbe.php`
  da sessione con shell; il trait resta analizzato via `tests/Fixtures/HasRatingHostStub.php`.

## Aperto

- [ ] H1 (bloccante gate): cancellare `app/Models/RatingPhpstanTraitProbe.php` (probe vietato).
- [ ] H2: eseguire gate ufficiale + Pest mirato (comandi sopra) e allegare output qui.
- [ ] H3: verificare `RatingTrait` (legacy, zero consumer dichiarati, referenzia
      `morphRelated()` inesistente): candidata alla cancellazione forward in story a sé,
      previa census `rg` repo-wide che qui non era eseguibile.
- [ ] H4: drift assertion `['title','color','rule','flags','txt']` vs form con `parent_id`
      (failure Pest pre-esistente, fuori scope PHPStan).
- [ ] Nome story non validato con `md-filenames.py` (no shell in sessione); formato
      conforme a policy (kebab, no date, `2.6` libero in epic 2).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- `php -l`, `phpstan analyse Modules/Rating`, Pest mirato: **non eseguibili in questa
  sessione** (nessun tool di shell disponibile nell'ambiente: `bash` integrato risponde
  `DAYTONA_API_KEY is not set`). Ogni edit è stato ricontrollato rileggendo il file
  modificato (diff + lettura integrale del test).
- Verifiche richieste al coordinatore / sessione con shell (handoff):
  `cd laravel && php -l Modules/Rating/app/Models/BaseRating.php` (× ogni file toccato),
  `./vendor/bin/phpstan analyse Modules/Rating --no-progress --memory-limit=-1`,
  `./vendor/bin/pest Modules/Rating/tests/Unit/RatingFilamentSchemaTest.php --no-coverage`,
  e gate canonico `analyse Modules` intero (le soglie `typeCoverage.*` valgono solo lì).
- Atteso: 0 errori; in particolare nessun `method.staticCall`, nessun `return.type` su
  `linkedTo()`, nessun `reportUnmatchedIgnoredErrors` sui `trait.unused` rimossi.
