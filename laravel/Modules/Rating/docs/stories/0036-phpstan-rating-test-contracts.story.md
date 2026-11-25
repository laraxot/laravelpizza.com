---
tags: [documentation]
qmd: "2.2.phpstan rating test contracts.story"
issues: []
discussions: []
title: "Rating: contratti statici di HasRatingsTrait nei test"
type: story
module: Rating
epic: 2
story_id: "2.2"
slug: phpstan-rating-test-contracts
status: review
created: 2026-08-24
updated: 2026-08-24
repository: "https://github.com/laraxot/module_rating_fila5"
github_issue: ""
github_discussion: ""
estimated_effort: "3-5h"
blocked_by: ["Xot-5.28"]
blocks: ["Ptv-7.4"]
supersedes:
  - ./0035-pest-contract-xotbasepest.story.md
owned_scope:
  - laravel/Modules/Rating/tests/Unit/HasRatingsTraitAccessorsTest.php
  - laravel/Modules/Rating/tests/Unit/Fixtures/RatingsHostStub.php
  - laravel/Modules/Rating/tests/Unit/HasLikesTraitTest.php
  - laravel/Modules/Rating/tests/Unit/Fixtures/Like.php
  - laravel/Modules/Rating/tests/Unit/HasRatingActionsTest.php
  - laravel/Modules/Rating/app/Models/Traits/HasLikes.php
---
# Story 2.2: Rating: contratti statici di HasRatingsTrait nei test

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

## Story

Come owner di Rating, voglio che stub e test descrivano i contratti Eloquent reali dei
trait di rating, così che i consumer Ptv ereditino una API affidabile e PHPStan non venga
placato con mock incompleti.

## Baseline e riconciliazione

La baseline corrente conta **78 findings Rating**: 49 in
`HasRatingsTraitAccessorsTest`, 23 `missingType.generics` e 40 `method.nonObject`. La story
2.1 prescrive `require_once` e helper globali, in conflitto con ADR-002/003 aggiornati:
questa story la supersede per la remediation corrente, preservandola come audit storico.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. `RatingsHostStub` e gli eventuali probe implementano il contratto Eloquent minimo con
   tipi/generics espliciti; nessun metodo di trait è invocato su `mixed` o `object` generico.
2. `HasRatingsTraitAccessorsTest` verifica relazioni, accessor e aggregati osservabili senza
   duplicare l'implementazione del trait né usare assert staticamente tautologiche.
3. I cinque file in scope risultano senza findings PHPStan; nessun `@phpstan-ignore`, cast
   di comodo, baseline, nuovo `.neon`, Service o Action proxy.
4. Il contratto Rating consumato da `Ptv\Models\BaseScheda` resta compatibile e viene
   documentato nel Dev Agent Record con il test che lo prova.
5. Gli eventuali findings Rating residui sono shardati per causa radice e owned scope.

## Tasks / Subtasks

- [ ] Tipizzare lo stub host e le relazioni generiche del trait. (AC: #1)
- [ ] Riscrivere le verifiche accessor/aggregate in termini comportamentali. (AC: #2)
- [ ] Correggere i test HasLikes/HasRatingActions nello scope. (AC: #3)
- [ ] Verificare la compatibilità con BaseScheda senza modificare Ptv. (AC: #4)
- [ ] Inventariare e shardare gli errori fuori scope. (AC: #5)

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- [Source: bmad-output/architecture.md#ADR-002] Bootstrap condiviso PSR-4; non ricreare
  `tests/Support` né helper globali locali.
- [Source: bmad-output/architecture.md#ADR-003] Usare `XotBasePest`/`XotBaseTestCase`, non
  il vecchio `require_once` descritto nella 2.1.
- [Source: AGENTS.md#Best-Practices---Spatie-Queueable-Actions-vs-Services] Le relazioni
  restano nel trait: non creare un'Action se il trait gestisce già la capability.

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- PHPStan sul modulo Rating e successivamente su `Modules`.
- Pest sui quattro test indicati; relazione verificata senza DB quando basta la metadata
  Eloquent, altrimenti MySQL test con transazione e nessuna migrazione distruttiva.
- Review dei generics `MorphMany`, `BelongsTo` e Collection contro i modelli reali.

## Dependencies

- Blocked by `Xot-5.28`; blocks `Ptv-7.4` per il contratto Rating consumato da BaseScheda.

## Learnings from Previous Stories

- La 2.1 contiene una strategia bootstrap superata dalle ADR successive: non va eseguita
  letteralmente.
- Trait e relazione sono la SSoT; stub e test devono conformarsi, non generare API proxy.

## Dev Agent Record

### Amendment di scope autorizzato

- La baseline cold ha dimostrato che `HasLikes` richiede `Modules\Rating\Models\Like`,
  mentre la fixture dichiarava `Modules\Rating\Tests\Unit\Fixtures\Like`: il contratto
  descritto dalla documentazione e il test della relazione nativa erano quindi
  irrealizzabili. L'orchestratore ha autorizzato l'aggiunta della sola fixture allo scope.
- Mappatura: correzione del namespace della fixture → Task "Correggere i test HasLikes"
  → AC #3. Non introduce API production né migrazioni cross-module.

### Implementazione

- Corrette le identità PSR-4 degli stub `RatingsHostStub` e `Like`; il primo deve essere
  visibile nello stack come `Modules\Rating\Models\*` per il resolver Xot.
- Esplicitati i generics di `MorphToMany`, `MorphMany`, `HasMany` e `Builder`; rimossa la
  soppressione `trait.unused` da `HasLikes` e tipizzato il contratto della collection.
- I test restano comportamentali: verificano filtri pivot, join, sync, invalidazione delle
  relazioni, accessor e aggregati osservabili.

### Compatibilità consumer

- `Ptv\Models\BaseScheda` non usa attualmente `HasRatingsTrait`; non è stata effettuata
  alcuna migrazione cross-module. I consumer reali trovati in
  `IndennitaResponsabilita` adottano il contratto `@use HasRatingsTrait<static>`.
- La compatibilità futura di BaseScheda è provata dal medesimo host Eloquent nel namespace
  `Models`: `HasRatingsTraitAccessorsTest` esercita i metodi pubblici senza proxy di API.

### Verifiche e residui

- PHPStan sui sei file dello scope emendato: **0 findings**.
- Pest mirato: **29 passed, 59 assertions**.
- `php -l`: **6/6** file validi.
- PHPMD: bloccato dalla incompatibilità vendor `PdependExtension::load()` con il tipo
  `void` di Symfony; PHP Insights non è installato.
- `graphify update .` non eseguito: `graphify-out/.rebuild.lock` è detenuto da una sessione
  concorrente; il grafo non è stato forzato né il lock altrui rimosso.
- Cold Rating residuo: **11 findings fuori scope**, shardati in
  `BaseRatingModelTest` (3), `RatingFilamentExtendedTest` (3),
  `RatingPolicyRolesTest` (1), `RatingPolicyTest` (2),
  `StatsOverviewWidgetTest` (2). Nessuno appartiene ai contratti corretti dalla story.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
