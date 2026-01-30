# PHPStan Roadmap - Xot Module

> **Date**: 2026-01-30
> **Status**: ✅ Fully Compliant (Level 10)
> **Errors**: 0

## Current Status
The **Xot** module is fully compliant with PHPStan Level 10. No errors were reported in the latest analysis.

## Corrections Applied (2026-01-30)
- **Actions**: SafeArrayByModelCastAction, GetSicureArrayByModelAction (return type `array<string, mixed>`), ImportCsvAction (list string per array_map).
- **HasXotTable**: type guard `is_object($resource)` e rimozione `@var object`; ignore per rami morti (TableWidget/ListRecords).
- **Module**: aggiunti `isEnabled()` e `isDisabled()` per i test.
- **ModuleBusinessLogicTest**: helper `createModule()` tipizzato, `@var \Modules\Xot\Tests\TestCase $this` in ogni test, tipi per array/assertContains, ignore per assertDatabaseHas/expectException dove necessario.

## Maintenance Strategy
1.  **Strict Typing**: Ensure all new code uses strict types (`declare(strict_types=1);`).
2.  **Regular Checks**: Run PHPStan before every commit.
3.  **Documentation**: Keep PHPDocs up-to-date for complex types.

## Future Goals
- Maintain 0 errors.
- Periodic review of ignored errors (if any exist in `phpstan.neon`, though none should).
