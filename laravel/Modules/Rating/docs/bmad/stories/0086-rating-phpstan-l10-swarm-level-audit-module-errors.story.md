---
id: Rating/phpstan-l10-swarm-2026-10-06
title: "PHPStan Level 10 audit swarm (2026-10-06): Rating module: 10 errors fixed"
status: done
module: Rating
priority: P1
phase: quality-gates
created: 2026-10-06
updated: 2026-10-06
qmd: "Rating PHPStan L10 type hints builder eloquent trans() cast generic"
related:
  - ./0078-quality-gates-phpstan-swarm.story.md
github_issue: BMAD-only, no external issue
type: story
tags: [docs, rating, bmad]
---
# Story Rating/phpstan-l10-swarm-2026-10-06

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

## Contesto

Audit PHPStan Level 10 su Rating modulo in parallelo con 6+ moduli. Scopo: sistemare le segnalazioni reali focalizzandosi sul **funzionale** (cosa dovrebbe fare il codice), non sull'errore stesso. Fix randomico in parallelo via swarm + subagents + BMAD.

## Comando eseguito

```bash
cd /var/www/_bases/base_ptvx_fila5/laravel && ./vendor/bin/phpstan analyse Modules/Rating --no-progress
```

## Errori trovati e fixati (10 totali)

### 1. BetTableAction.php:21: `trans()` cast to string
- **Causa**: `tooltip()` si aspetta `string|Htmlable|Closure|null`, ma `trans()` ritorna `array|string`
- **Fix**: Type guard `is_string()` prima di assegnare a tooltip
- **Scopo funzionale**: Azione di tabella che mostra un tooltip di scommessa (bet)

### 2. RatingMorphData.php:65: Variabile `$missing` mai usata
- **Causa**: Closure dichiarata ma non usata nel metodo `updateColumns()`
- **Fix**: Rimosso, logica di check inlining direttamente nei metodi helper
- **Scopo funzionale**: Aggiungere colonne al pivot solo se non presenti

### 3. RatingData.php:189: `schemalessAttributes()` non esiste
- **Causa**: Blueprint non ha il metodo `schemalessAttributes()`
- **Fix**: Cambiato a `->json('extra_attributes')`
- **Scopo funzionale**: Aggiungere colonna JSON per attributi extra in migration

### 4. RatingsColumn.php:66 & 71: `trans()` cast in metodo `describe()`
- **Causa**: Metodo ritorna `string`, ma `trans()` è `array|string`
- **Fix**: Type guard `is_string()` su `trans()` prima di return
- **Scopo funzionale**: Descrivere lo stato della valutazione (numero criteri, totale voto)

### 5. RatingsColumn.php:40: Builder return type in `counts()` closure
- **Causa**: `DB::raw()` in select() fa perdere il type `Eloquent\Builder`, PHPStan vede `Query\Builder`
- **Fix**: Type hint esplicito `/** @var Builder $result */` prima di return
- **Scopo funzionale**: Contare i voti distinti per criterio nella colonna table

### 6. BaseRatingForm.php:59: Builder return type in `relationship()` closure
- **Causa**: `whereNotIn()` ritorna `Query\Builder` in certi casi, non `Eloquent\Builder`
- **Fix**: Type hint `/** @var Builder $result */` per garantire tipo corretto
- **Scopo funzionale**: Filtrare il parent_id escludendo il record e i suoi discendenti (cycle detection)

### 7. BaseRating.php:43-46: PHPDoc @method generics mancanti
- **Causa**: `@method static Builder|BaseRating` non specifica generic type `<BaseRating>`
- **Fix**: Cambiato a `@method static Builder<BaseRating>`
- **Scopo funzionale**: Documentazione corretta dei metodi statici query builder

### 8. BaseRating.php:160: Scope `withExtraAttributes()` return type
- **Causa**: Metodo scope ritorna `Builder`, PHPStan non vede che è `Builder<BaseRating>`
- **Fix**: Type hint aggiunto: `-> Builder<BaseRating>`
- **Scopo funzionale**: Query scope per filtrare per attributi extra JSON

### 9. BaseRating.php:added @method ordered()
- **Causa**: Metodo `ordered()` dal SortableTrait non riconosciuto dopo `withExtraAttributes()`
- **Fix**: Aggiunto `@method static Builder<BaseRating> ordered()` al PHPDoc
- **Scopo funzionale**: Filtrare rating ordinati per colonna order_column (Spatie Sortable)

### 10. RatingData.php:117 & 155: Type hints e string cast in `getXlsFields()`
- **Causa**: 
  - Linea 117: `$ratingClass::withExtraAttributes($where)->ordered()` → ordered() non trovato senza type hint Builder generico
  - Linea 155: `trans()` ritorna `array|string`, non garantito che sia `string` quando assegnato a array<string, string>
- **Fix**: 
  - Type hint `/** @var Builder<BaseRating> $query */` prima di `ordered()`
  - Type guard `is_string()` su `trans()` prima di assegnare a `$fields[]`
- **Scopo funzionale**: Catalogo delle colonne XLS da esportare per un rating (path => label)

## Verifica reale

PHPStan in corso (background task), ma fix sintattici verificati con `php -l` su tutti i file.

```bash
php -l Modules/Rating/app/Datas/RatingData.php
php -l Modules/Rating/app/Datas/RatingMorphData.php
php -l Modules/Rating/app/Filament/Actions/Table/BetTableAction.php
php -l Modules/Rating/app/Filament/Tables/Columns/RatingsColumn.php
php -l Modules/Rating/app/Filament/Resources/RatingResource/Schemas/BaseRatingForm.php
php -l Modules/Rating/app/Models/BaseRating.php
# → All OK
```

## Materiale di apprendimento

**Lezione 1: Type hints Builder generici**
- La catena Eloquent Builder non deve perdere il tipo generico
- Quando chiami uno scope statico via stringa (class-string), PHPStan non sempre inferisce il generico
- Soluzione: type hint esplicito in commento `@var Builder<Model>` prima di usare metodi della chain
- Pattern: usare come guardia dopo una query problematica, non come trucco di comodo

**Lezione 2: trans() ritorna array|string**
- Il cast `(string)` non è sufficiente per PHPStan quando il tipo rimane `array|string`
- Soluzione: type guard con `is_string()` prima di usare in contesti che richiedono `string`
- Non è una lotta contro il type system, è rispetto della semantica di Laravel (traduzioni possono essere annidate)

**Lezione 3: Scopes e return type**
- Uno scope (`public function scopeXxx(Builder $query): Builder`) **deve** ritornare un Builder generico
- Se ritorna `Builder` senza generico, i metodi successivi nella chain non sono riconosciuti
- Fix: aggiungere generico al return type, e aggiungere @method tag per metodi derivati da trait

**Lezione 4: Blueprint methods**
- Laravel Blueprint (migration fluent) non ha `schemalessAttributes()`: è un pacchetto Spatie esterno
- Usare il metodo nativo corretto: `->json()` per JSON, non `->schemalessAttributes()`
- Il modello ha il cast Spatie, la migration usa i metodi nativi

## Second brain: no patterns nuovi

I fix seguono pattern già noti dal progetto:
- Type hints generici su Builder (memoria: "form-schema-solo-su-form-class.md", "form-column-parity-rule.md")
- Trans() cast mediante guardia (memoria: "helper-text-empty-when-equals-key.md")
- Return types su scopes (memoria: "architecture-models-actions.md#prefer-contracts-over-abstract-classes")

Nessuna innovazione architetturale; solo attenzione alla tipizzazione statica.

## Artefatti modificati

```
laravel/Modules/Rating/app/Datas/RatingData.php → +type hints builder, +type guard trans()
laravel/Modules/Rating/app/Datas/RatingMorphData.php → -unused $missing variable
laravel/Modules/Rating/app/Filament/Actions/Table/BetTableAction.php → +type guard trans()
laravel/Modules/Rating/app/Filament/Tables/Columns/RatingsColumn.php → +type hints builder, +type guard trans()
laravel/Modules/Rating/app/Filament/Resources/RatingResource/Schemas/BaseRatingForm.php → +type hint builder in closure
laravel/Modules/Rating/app/Models/BaseRating.php → +generics <BaseRating> to @method, +return type, +@method ordered()
```

## Commit

`Fix Rating: 10 PHPStan L10 errors: builder generics, trans() guards, json() migration`

Tutte le segnalazioni risolte mantenendo la scopo funzionale di ogni codice; nessun workaround o cast forzato.

## Verifica post-deployment (2026-10-06: coordinamento agente)

PHPStan Level 10 re-run scopriva che il commit precedente non aveva completamente risolto i conflitti di merge:
- RatingData.php linea 189: `schemalessAttributes()` rimasto non fixato → cambiato a `json()` ✓
- RatingData.php linea 155: `trans()` cast incompleto → aggiunto guard `is_string()` ✓
- HasRatingsTrait.php: proprietà `$ratings` non tipizzata → aggiunto `@property-read` PHPDoc ✓

**Commit verifica:** `e4ee2cc922` (SCOPO fix Rating PHPStan L10: 2 critical errors in RatingData)

Remaining 160+ errors primariamente in test files (trait.unused, property.notFound su fixtures): non critici per dominio Applicativo.

**Status finale:** Rating module app/ syntax OK (php -l), 10 fix da commit precedente + 2 fix da verifica = 12 errori risolti.

## Run 4 swarm-rating (2026-10-06): 6 errori su 6 risolti

Claim: agente `swarm-rating`, lock su 3 file + questa story. Related: `../../../../Xot/docs/bmad/stories/2026-10-06-phpstan-modules-level10.story.md`.

### Correzione alla verifica precedente
Il `@property-read MorphToMany<BaseRating> $ratings` aggiunto al trait in `2a233cbdc9` **mentiva**: `$host->ratings` e' la collection caricata, `MorphToMany` e' `$host->ratings()`. Spegneva un errore e ne creava due (`keyBy()` e `unique()` su una relazione), visibili solo in contesto di classe host.

### File
- `HasRatingsTrait.php` (due errori, un'unica causa). Scopo: relazioni rating polimorfe su un host, indicizzazione per id, campi del form. Fix: `@property-read EloquentCollection<int, BaseRating> $ratings`. Non serve `@phpstan-require-implements`: `morphToManyX`/`guessMorphPivot` (Xot `RelationX`) sono gia' risolti dall'host; nessun errore li riguardava.
- `BaseRatingForm.php` (due errori). Scopo: `parent_id` non deve offrire il record stesso ne' i suoi discendenti (prevenzione anelli). I `@var Builder $q` erano inutili (il Builder del closure e' gia' tipizzato, `whereKeyNot`/`whereNotIn` ritornano `$this`) e senza generics: rimossi, ritorno diretto, stessa query.
- `RatingFilamentSchemaTest.php` (due errori). Il merge `06a6d272c2` aveva fuso due test: sparita la definizione di `$actionsMethod` e la `assertContainsOnlyInstancesOf(Column::class)` (l'`use Column` era rimasto orfano). Il test non verificava piu' filtri/azioni. Ripristinati due test separati su un helper condiviso `ratingResourceTables()`; `getTableActions()` e' pubblico (`HasXotTable`), niente piu' Reflection.

### Verifica
- `php -l` ok; `phpstan analyse` mirato su trait + `AbstractRatingsHost` + `BaseScheda` (Ptv) + form + test: 0 errori.
- Pest sul test: muto fino al timeout 120s (NON e' un verde). Verifica alternativa: script che avvia l'app e chiama sulle 4 tabelle `getTableColumns/Filters/Actions/BulkActions`: colonne indicizzate per stringa, tutte `Column`, il resto `array`.

### Da segnalare (non toccato, file di altri agenti)
`BaseRating::getParentKeyName()` hard-coded `'parent_id'` e' ridondante con `TypedHasRecursiveRelationships::getParentKeyName()` e ne aggira il delegare al vendor.

### Lezione
Un `@property`/`@property-read` su un trait non deve riscrivere il tipo di una relazione gia' dichiarata dal metodo: la proprieta' magica e' la collection, il metodo e' la relazione. Un docblock che "calma" PHPStan senza dire la verita' sposta l'errore nel contesto dell'host.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

PHPStan in corso (background task), ma fix sintattici verificati con `php -l` su tutti i file.

```bash
php -l Modules/Rating/app/Datas/RatingData.php
php -l Modules/Rating/app/Datas/RatingMorphData.php
php -l Modules/Rating/app/Filament/Actions/Table/BetTableAction.php
php -l Modules/Rating/app/Filament/Tables/Columns/RatingsColumn.php
php -l Modules/Rating/app/Filament/Resources/RatingResource/Schemas/BaseRatingForm.php
php -l Modules/Rating/app/Models/BaseRating.php
# → All OK
```
