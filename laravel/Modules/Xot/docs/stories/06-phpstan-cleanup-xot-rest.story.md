---
title: "[STORY] PHPStan cleanup Xot (tests, helpers, stub) - gruppo Xot_rest"
type: story
status: done
priority: high
created: 2026-10-06
updated: 2026-10-06
module: Xot
tags: [phpstan, cleanup, xot, swarm, tests, pest, stubs]
---

# [STORY] PHPStan cleanup Xot (tests, helpers, stub) - gruppo Xot_rest

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Scope di questo gruppo: tutto `laravel/Modules/Xot/**` tranne `Xot/app/**` (gestito da `Xot_app`): `tests/`, `helpers/`. 87 segnalazioni in 16 file.

## Analysis

Le 87 segnalazioni erano 4 famiglie (20 test segnaposto, 53 stub Pest, 2 voci di fixture, 12 stale). Per ognuna si e' guardato cosa il codice deve fare.

### 1. Test segnaposto: "variabile mai letta" = asserzione mancante (20 voci, 6 file)
Test con titolo che dichiara un comportamento ("it supports observers", "throws exception for missing table", "throws exception for unsupported format") ma corpo che crea la variabile e non asserisce nulla: sono test che passano sempre (risky). In `CreateTableIndexByModelClassColumnsActionTest` la versione `HEAD` precedente al merge aveva ancora `expect(...)->toThrow(\Throwable::class)`: l'asserzione e' andata persa nel merge del 2026-09-24.
Aggiunte le asserzioni previste dal titolo, **ognuna verificata contro il codice** (e, per i modelli Eloquent, con uno script PHP senza DB):
- `SaveArrayAction` -> `InvalidArgumentException` "Formato non supportato: xml".
- `GetStrBetweenStartsWithAction` -> `Exception` "Cannot find missing".
- `CreateTableIndexByModelClassColumnsAction` -> `InvalidArgumentException` (classe non-Model, invocata via `ReflectionMethod` perche' `execute()` e' `class-string<Model>`) e `RuntimeException` "Table 'missing_table' does not exist".
- `XotBaseModelBusinessLogicTest` (10 test): trait richiesti (`HasXotFactory`, `RelationX`, `Updater`), soft deletes coerente con `trashed()`, nessuno scope globale implicito (isolamento tenant opt-in), audit trail (`Updater` aggancia `creating/updating/deleting`), `relationLoaded/setRelation`, accesso attributi, eventi osservabili, `Model::observe()` con osservatore nominato, `addGlobalScope`, accessor/mutator `Attribute`.
- `ModuleServiceTest` (4 test): `getModels()` di un modulo non registrato torna `[]`; ogni voce restituita e' `Modules\...` con chiave snake_case del basename.
- `XotExecuteCoverage50Test`: `MetatagData::make()` e' un singleton (`assertSame`).

### 2. Stub Pest con parametri inutilizzati (53 voci: `helpers/Helper.php` 15, `tests/PestStubs.php` 38)
Gli stub (`actingAs`, `get`, `post`, ..., `uses`) esistono solo per l'analisi statica e lanciavano una `RuntimeException` generica ignorando gli argomenti. Non si possono rimuovere i parametri: PHPStan risolve `Pest\Laravel\*` contro `PestStubs.php` *prima* del vendor, quindi cambiare le firme cambierebbe l'analisi di ogni test che fa `use function Pest\Laravel\get`.
Soluzione: un'unica funzione `xotPestStubFailure(string $function, mixed ...$arguments): never` in `Helper.php`; ogni stub la chiama passandole nome e argomenti. Gli argomenti ora servono davvero: il messaggio riporta la chiamata tentata (`Stub get(string, array): ...`). Firme e docblock degli stub invariati; ~29 `throw` duplicati diventano una riga.

### 3. Fixture (2 voci)
- `SendMailByRecordActionTest` (`missingType.iterableValue`): la classe anonima *dentro* una classe anonima non risolve il PHPDoc di `create(array $data)` (riproducibile anche con `analyse Modules`). La relazione `myLogs()` e' ora una classe nominata `SendMailRecordLogsFixture` con il suo `@param`. Nel `catch` l'asserzione tautologica `assertInstanceOf` e' diventata un controllo del messaggio reale.
- `XotFilamentSupportHundredCoverageTest` (`assign.redundant`): `$inst = null` nel `catch` era ridondante (l'istanza resta null se `newInstanceWithoutConstructor()` lancia); il `catch` ora dice perche' e' vuoto.

### 4. Voci stale (12 voci in 6 file)
`missingType.iterableValue` su classi anonime con PHPDoc gia' presente (`XotBaseResourceCoverageTest`, `SafeObjectEloquentCastActionsTest`, `SafeCastActionsTest`, `SafeArrayCastActionTest`, `XotTableLegacyNameResolutionTest`, `HasXotTableLayoutHooksTest`) non si riproducono ne' con file singolo ne' con `analyse Modules`: erano risultati stale della result-cache condivisa `/tmp/phpstan` (nome della classe anonima con radice relativa diversa tra run paralleli). Nessuna modifica necessaria, salvo in `HasXotTableLayoutHooksTest` dove il docblock `@return array<string, Column>` era comunque duplicato 4 volte (due doc-comment consecutivi): ne resta uno.

### Extra (segnalato da Xot_app)
`XotHundredPercentCoverageTest`: `isSuspiciousRequest` via reflection era invocato con 2 argomenti dopo che `SecurityMiddleware` ne ha 1; ora ne passa 1.

### Enum
Nessuna costante di insieme di valori nel perimetro (solo file di test/helper): nessun enum creato ne' riusato.

## Acceptance Criteria

- [x] `phpstan analyse Modules` senza errori in `Modules/Xot/{tests,helpers}` (87 -> 0; i 16 file della lista a 0).
- [x] Nessun `@phpstan-ignore*`, `@var` bugiardo, cast per zittire, `assert` finti; nessun file cancellato/spostato/rinominato.
- [x] Ogni test segnaposto ora asserisce il comportamento del suo titolo.
- [x] Firme degli stub Pest invariate; nessun nuovo errore in altri moduli dovuto a `PestStubs.php`.
- [x] Dev-story con lezioni imparate; `bmad/phpstan-status.md` e indice wiki aggiornati.
- [ ] Pest non eseguito: `laravel/.env.testing` usa MySQL con `APP_ENV=local` (vedi dev-story, elenco dei test da rilanciare su sqlite).

## GitHub

Issue: TODO (gh non installato su questa macchina)
Discussion: TODO

Vedi [dev](./2026-10-06-phpstan-cleanup-xot-rest.dev.md).
