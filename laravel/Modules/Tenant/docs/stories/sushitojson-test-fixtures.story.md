# Story: SushiToJson test fixtures

## Scopo

SushiToJson persiste dati in file JSON isolati per tenant. `TestSushiModelForPath` + `makeTestSushiModelForPath($jsonPath)` creano un modello con percorso JSON esplicito per verificare l'isolamento (tenant1 ≠ tenant2 ≠ custom).

## Contratto

- `makeTestSushiModelForPath(string $jsonPath)`: path obbligatorio.
- `TestSushiModelForPath::setJsonPath()` + override `getJsonFile()`: il trait legge solo `getJsonFile()`.

## Causa errore PHPStan (arguments.count)

Helper richiesta con 1 parametro; i call site in `SushiToJsonIntegrationTest` la invocavano con 0.

## Fix

Passare `$tenantPath` / `tenantJsonPath(...)` / path custom a ogni call site. Non usare default vuoto.

## SSoT path

- Autoload PSR-4: `Modules\Tenant\Tests\` → `tests/` (minuscolo).
- Fixture: `tests/Fixtures/TestSushiModelForPath.php` estende `TestSushiModel`, espone `setJsonPath()` + override `getJsonFile()`.
- Vietato ricreare `Tests/` (maiuscolo): PHPStan analizza tutto `Modules/` e le collisioni case rompono macOS/Windows.

