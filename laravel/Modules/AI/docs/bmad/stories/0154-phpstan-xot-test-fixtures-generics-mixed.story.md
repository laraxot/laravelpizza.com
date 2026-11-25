---
title: PHPStan Xot test fixtures - generics e mixed
type: story
status: review
module: Xot
qmd: phpstan xot tests HasCommonScopesProbe ModuleRouteEntrypointsExistTest missingType.generics cast.string argument.type Safe glob
---
# PHPStan Xot: fixture generico e test di routing

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

## Scopo dei test
- `HasCommonScopesProbe`: fixture Eloquent senza DB per `HasCommonScopesTest` (scope = SQL ispezionato, helper booleani = PHP puro).
- `ModuleRouteEntrypointsExistTest`: ogni modulo con `RouteServiceProvider` che estende `XotBaseRouteServiceProvider` deve avere `routes/web.php` e `routes/api.php`, sia nel modulo sia nella cartella che il provider carica davvero (`$module_dir`, ereditato da Xot se non ridefinito). Un file mancante e' un fatal al boot.

## Causa radice
1. `HasCommonScopes` dichiara `@template TModel of Model`; il fixture lo usava senza `@use` -> `missingType.generics`.
2. `Safe\glob` e' documentato `@return list` senza tipo degli elementi: `$provider` era `mixed` -> `argument.type` su `dirname()`.
3. `ReflectionClass::getDefaultProperties()` e' `array<string, mixed>`: il `(string)` su `module_dir` era un cast cosmetico (un valore non stringa diventava `''` e `dirname('', 2)` mascherava il problema) -> `cast.string`.

## Fix
- `HasCommonScopesProbe`: `/** @use HasCommonScopes<static> */` sopra `use`, stessa forma di `Ptv\BaseScheda`.
- Test routing: `is_string($provider)` e `is_string($moduleDir)` con fallimento esplicito (la voce finisce in `$missing`, quindi `expect($missing)->toBe([])` rosso con messaggio chiaro). Nessun cast, nessun `assert`, nessun `@var`, nessun ignore.

## File toccati
- `laravel/Modules/Xot/tests/Fixtures/Models/HasCommonScopesProbe.php`
- `laravel/Modules/Xot/tests/Unit/Routing/ModuleRouteEntrypointsExistTest.php`

## Evidenza
- `php -l`: nessun errore di sintassi sui due file.
- `phpstan analyse` mirato sui due file: `[OK] No errors`.
- Pest `Modules/Xot/tests/Unit/Routing/ModuleRouteEntrypointsExistTest.php`: 1 passed (2 assertions).
- Pest `Modules/Xot/tests/Unit/Traits/HasCommonScopesTest.php`: non eseguibile qui, `TestDatabaseGuard` rifiuta il bootstrap (`connection "mysql" -> host "10.100.200.53" is not local`). Skip documentato; la modifica al fixture e' solo PHPDoc.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
