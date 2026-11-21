---
title: "[STORY] PHPStan Xot/tests: test senza asserzioni riscritti sul comportamento reale"
type: story
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
module: Xot
tags: [phpstan, xot, tests, pest, swarm, coverage-sweep, variable-unused]
related:
  - ./2026-10-06-phpstan-cleanup-xot-app.story.md
  - ./2026-10-08-phpstan-xot-app-regressions.story.md
---

# [STORY] PHPStan Xot/tests: test senza asserzioni

## User Request

Azzerare gli errori PHPStan, alzare la qualita' del codice, partendo dallo scopo e non dal messaggio. Perimetro: 5 file in `laravel/Modules/Xot/tests/Unit` (9 segnalazioni: `variable.unused`, `assign.redundant`, `method.nonObject`, `variable.undefined`).

## Analysis

"Variable $action is never read" in un test non e' codice morto: e' un test che costruisce l'Action e non verifica nulla. Lo scopo e' quello del nome del test.

### 1. Test scheletro mai scritti (3 file, 6 test)
Nel `HEAD` (commit `2dc9faf4 first`) i test `throws exception ...` erano `$action = app(X::class);` e basta: nessuna chiamata, nessuna asserzione (verdi per costruzione). Un passaggio meccanico precedente (non committato, concorrente) li aveva "sistemati" togliendo `$action =` o aggiungendo `@var`, quindi il test continuava a non provare niente. In `SaveArrayActionTest` la segnalazione `variable.undefined` apparteneva a uno stato intermedio di quel passaggio; il file finale non ha piu' l'errore.

Riscritti leggendo l'Action e i suoi chiamanti:
- `GetStrBetweenStartsWithAction` (usata da `GenerateTableColumnsByFileAction` per riscrivere `->columns(`, `->schema(`, `->filters(`): ritaglia dal body il blocco bilanciato che parte da `$start`. Test: caso base, `Exception "Cannot find {start} in {body}"`, uso reale (marker di apertura dentro lo start, il `->filters(` successivo non entra), testo multibyte (`mb_*`).
- `SaveArrayAction` (dispatcher php|json|errore): default php (il file inizia con `<?php` e si ricarica uguale), json (decode uguale), formato non supportato (`InvalidArgumentException "Formato non supportato: xml"` e nessun file scritto). I vecchi test usavano `Safe\tempnam` + estensione, lasciando in `/tmp` un file orfano per test: ora una cartella per test rimossa in `afterEach` (stessa scelta di `SavePhpArrayActionTest`).
- `CreateTableIndexByModelClassColumnsAction`: crea l'indice con nome `{tabella}_{colonne}_index` (verificato con `Schema::getIndexes`, non solo col `true` di ritorno) e la seconda richiesta e' un no-op `false`; classe non-Model -> `InvalidArgumentException`; tabella mancante -> `RuntimeException "Table 'missing_table' does not exist on connection 'xot'."`; colonna mancante (ramo prima non testato) -> `RuntimeException` e nessun indice creato. La tabella temporanea sta ora in `beforeEach`/`afterEach` sulla connessione `xot` (quella di `XotBaseModel`): prima un'asserzione fallita lasciava la tabella.

### 2. `XotFilamentSupportHundredCoverageTest`: sweep di coverage
Giudizio: il test iterava per reflection tutti i metodi di 4 classi, li invocava con argomenti inventati, **inghiottiva ogni `Throwable`** e incrementava `$n` sia nel successo sia nell'errore; `assertGreaterThan(0, $n)` era vuota. L'unica asserzione reale era `ColumnBuilder::id()->getName()`. E' l'anti-pattern che `ModuleExecuteCoverage::runFloor100` vieta (story 5.26). L'`assign.redundant` (`$inst = null` due volte) era solo il sintomo.
Sostituito con 12 test di comportamento senza DB (le query si ispezionano con `toSql()`/`getBindings()`): `Builders\ColumnBuilder` (flag sortable/searchable, `timestamps(hideUpdated)`, relazioni `*.name`, `updater` nascosto), `Support\ColumnBuilder` (tooltip da record e vuoto senza record, mappa stato -> colore, `publishedAt` verde solo per date passate, gruppi timestamps/audit/soft delete), `FilterBuilder` (merge dei valori personalizzati, `dateRange` solo sui limiti valorizzati, `trashedFilter` solo cestinati / senza / tutti, model senza SoftDeletes intatto), `RecordAnchor` (frammento dopo la query string).

### 3. `XotExecuteCoverage50Test`, test "FileAction static helpers e XotData factory"
Il nome prometteva FileAction ma il corpo non la toccava; `MetatagData::make()` veniva chiamata e ignorata. Ora il test (rinominato) verifica che `XotData::make()` e `MetatagData::make()` siano singleton e che `getBrandName()` coincida con `title`.
Giudizio sul resto del file (1130 righe, 23 test, ~150 asserzioni): misto. Il primo test (`ModuleExecuteCoverage::runFloor50`), `Filament schema sweep` e il ciclo reflection dentro `Support ColumnBuilder BaseQueryBuilder ...` non asseriscono nulla e inghiottono eccezioni. Non toccati: fuori dalla segnalazione e la sostituzione richiede una scelta di prodotto (vedi Aperto).

## Verification

- `php -l` sui 5 file: nessun errore di sintassi.
- PHPStan (`phpstan analyse` sui 5 file, config `laravel/phpstan.neon`): `[OK] No errors`.
- Pest, singolo file (con `DB_DATABASE_USER=fixcity_data_test`, vedi decisioni): `GetStrBetweenStartsWithActionTest` 4 passed (5 asserzioni); `SaveArrayActionTest` 3 passed (8); `CreateTableIndexByModelClassColumnsActionTest` 4 passed (10, DB reale `xot`); `XotFilamentSupportHundredCoverageTest` 12 passed (52); `XotExecuteCoverage50Test --filter="singleton configurato"` 1 passed (4).
- Dopo il test DB: `test_index_table` non esiste piu' su `fixcity_data_test`.

## Decisions

- Nessun `@phpstan-ignore`, `@var` o `assert()` per il tipo. Il guard "non e' un Model" di `CreateTableIndexByModelClassColumnsAction` si prova via `ReflectionMethod::invoke`, perche' `class-string<Model>` vieta la chiamata diretta: e' l'unico punto in cui il test aggira il tipo statico, ed e' commentato.
- Ambiente: `TestCase` apre una transazione sulla connessione `user`, ma sul MariaDB locale (127.0.0.1) esiste solo `fixcity_data_test` (1 tabella); `fixcity_user_test` no. Senza override ogni test `TestCase` cade in `setUp` con `Unknown database 'fixcity_user_test'` (non e' il timeout del MySQL remoto). Ho eseguito con `DB_DATABASE_USER=fixcity_data_test`, che sposta solo quella connessione su un DB di test esistente: nessun database creato, nessuna migrazione lanciata.
- Un altro processo ha riscritto gli stessi file tra le 07:19 e le 07:21 (dopo il mio lock), con modifiche che zittivano PHPStan senza asserire; il contenuto finale e' quello descritto qui.

## Open

- `GetStrBetweenStartsWithAction` (in `Xot/app`, non toccata): con parentesi sbilanciate il `do/while` non termina mai (verificato: `execute('x a(b(c) d', 'a(', '(', ')')` resta appeso); con `$close` assente restituisce `''` in silenzio (`mb_strpos` -> `false`). Va aggiunto un guard con eccezione.
- `Support\ColumnBuilder` usa etichette `xot::fields.*.label`, ma in `Xot/lang/*` non esiste `fields.php`: l'UI mostrerebbe la chiave grezza. Nessuno dei builder ha chiamanti fuori dai test.
- `FilterBuilder::dateRange`: l'`indicateUsing` (formato `d/m/Y`) non e' testato, richiede lo stato filtri di una tabella Livewire.
- Decidere se tenere o sostituire i test sweep rimasti in `XotExecuteCoverage50Test` (primo test, `Filament schema sweep`, ciclo reflection del test Support ColumnBuilder).
- `CreateTableIndexByModelClassColumnsAction::indexExists` interroga `information_schema.statistics`: solo MySQL/MariaDB. L'Action non ha chiamanti fuori dal test.

## GitHub

Issue: TODO (gh non installato su questa macchina)
Discussion: TODO
