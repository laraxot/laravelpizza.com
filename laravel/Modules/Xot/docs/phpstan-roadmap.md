# PHPStan Roadmap - Xot Module

> **Date**: 2026-01-30
> **Status**: 🟡 In progress (app code: OK; tests/migrations: errori residui)
> **Errori totali (analisi Modules/Xot)**: ~103 (principalmente in tests e CreatesApplication)

## Stato attuale

- **app/Actions, app/Database/Migrations (XotBaseMigration + Pulse)**: ✅ 0 errori (correzioni applicate 2026-01-30).
- **tests/ (CreatesApplication, ModuleBusinessLogicTest, ecc.)**: errori residui (mixed, property.notFound, method.notFound).
- **database/migrations (Pulse)**: ✅ risolto con aggiunta di `shouldRun(): bool` in XotBaseMigration.

## Correzioni applicate (2026-01-30)

1. **SafeArrayByModelCastAction**: return type `array<string, mixed>` – variabile annotata con `@var` prima del return.
2. **GetSicureArrayByModelAction**: return type + fix `$this->$key` → `$model->$key`; `@var array<string, mixed>` per `$data` nel catch.
3. **ImportCsvAction**: callback `array_map` – parametro closure da `(string $column)` a `(mixed $column)` con cast `(string) $column`; uso di `array_values(array_diff(...))` per tipizzazione.
4. **XotBaseMigration**: aggiunto metodo `shouldRun(): bool` (default `true`) per migrazioni Pulse che lo invocano.

## Prossimi passi

- [ ] Correggere `tests/CreatesApplication.php`: Safe\realpath, return type Application, mixed da createApplication().
- [ ] Correggere `tests/Feature/ModuleBusinessLogicTest.php`: assertDatabaseHas (Pest), proprietà Module ($slug, $version, $enabled), type narrowing su mixed.
- [ ] Verificare altri file in tests/ con errori residui.

## Maintenance strategy

1. **Strict typing**: `declare(strict_types=1);` in tutto il codice nuovo.
2. **Controlli**: eseguire PHPStan prima di ogni commit su path modificati.
3. **PHPDoc**: mantenere annotazioni per array e return type complessi.

## Collegamenti

- [phpstan-code-quality-guide.md](phpstan-code-quality-guide.md)
- [phpstan-all prompt](../../../bashscripts/tools/prompts/phpstan_all.txt)
