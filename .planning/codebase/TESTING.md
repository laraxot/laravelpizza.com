# Testing Patterns (Quality Focus)

## Scope and evidence
This document summarizes the observed test stack and patterns with evidence from:
- `laravel/phpunit.xml`
- `laravel/tests/Pest.php`
- `laravel/tests/TestCase.php`
- `laravel/composer.json`
- `laravel/Modules/*/tests/Pest.php`
- `laravel/Modules/*/tests/TestCase.php`
- `laravel/Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php`
- `laravel/Modules/Geo/tests/Unit/Actions/ClusterLocationsActionTest.php`
- `laravel/Modules/Media/tests/Unit/Actions/SaveAttachmentsActionTest.php`
- `laravel/Modules/User/tests/Feature/Actions/RevokeAllUserTokensActionTest.php`
- `docs/testing/coverage-100-plan.md`

## 1) Framework and runtime
### Observed standard
- Primary framework is Pest on top of PHPUnit/Laravel testing stack.
- Root suite is module-centric in `phpunit.xml` (`Modules/*/tests/Feature`, `Modules/*/tests/Unit`).
- Root test case extends module base (`Tests\TestCase` extends `Modules\Xot\Tests\XotBaseTestCase`).

### Evidence
- `laravel/phpunit.xml`
- `laravel/tests/Pest.php`
- `laravel/tests/TestCase.php`
- `laravel/composer.json` (`pestphp/pest-plugin-laravel`)

### Practical guidance
- Prefer Pest syntax (`test`, `it`, `describe`, `expect`) for consistency.
- Bind module tests via each module’s `tests/Pest.php` to local `TestCase`.

## 2) Test structure and organization
### Observed structure
- Per-module `Feature` and `Unit` folders are standard.
- Modules provide dedicated `tests/TestCase.php` and often module-specific helper expectations/functions in `tests/Pest.php`.
- Some modules add specialized folders (`Integration`, `Traits`, `Performance`) that are included by root Pest config.

### Evidence
- `laravel/tests/Pest.php` (includes module `Feature/Unit/Traits/Integration/Performance`)
- `laravel/Modules/Geo/tests/Pest.php`
- `laravel/Modules/User/tests/Pest.php`
- `laravel/Modules/Geo/tests/TestCase.php`
- `laravel/Modules/User/tests/TestCase.php`

### Quality risks
- Duplicate/mixed naming styles exist in tests (same semantic tests with lowercase variants, mixed `Pest.php` and `pest.php`, `.pest.php` plus standard `*Test.php`), which complicates maintenance and discoverability.

### Evidence
- Lowercase duplicates: `laravel/Modules/Cms/tests/Feature/Auth/logintest.php`, `laravel/Modules/Cms/tests/Feature/Auth/LoginTest.php`
- Mixed Pest entry files: `laravel/Modules/Cms/tests/Pest.php`, `laravel/Modules/Cms/tests/pest.php`
- Mixed suffixes: `laravel/Modules/Xot/tests/Feature/FixStructureTest.pest.php`

## 3) Database isolation and multi-connection handling
### Observed pattern
- `DatabaseTransactions` is preferred over `RefreshDatabase` across modules.
- Module TestCases explicitly define multi-connection rollback via `connectionsToTransact`.
- `phpunit.xml` injects test DB env vars and connection overrides.

### Evidence
- `laravel/Modules/Geo/tests/TestCase.php`
- `laravel/Modules/User/tests/TestCase.php`
- `laravel/phpunit.xml`
- Widespread usage: e.g., `laravel/Modules/Meetup/tests/Unit/Models/EventTest.php`

### Practical guidance
- Keep using transaction rollbacks for speed with multi-DB setup.
- For tests touching multiple module DBs, always include all relevant connections in `connectionsToTransact`.

## 4) Mocking and fakes
### Observed techniques
- `Mockery` is heavily used for unit isolation and contract-based behavior.
- Laravel fakes are used where appropriate: `Http::fake`, `Event::fake`, `Storage::fake`.
- Facade expectation style (`shouldReceive`) is common in module tests.

### Evidence
- Mockery-heavy unit tests: `laravel/Modules/Geo/tests/Unit/Actions/ClusterLocationsActionTest.php`
- HTTP fake: `laravel/Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php`
- Storage fake + mocked media pipeline: `laravel/Modules/Media/tests/Unit/Actions/SaveAttachmentsActionTest.php`
- Event fake usage: `laravel/Modules/User/tests/Feature/Actions/LoginUserActionTest.php`
- Facade mocks: `laravel/Modules/Cms/tests/Unit/Actions/View/GetCmsViewActionTest.php`

### Practical guidance
- For pure domain logic, prefer interface/contract mocking over facade mocking.
- For integration boundaries (HTTP/storage/events), prefer framework fakes.
- Keep assertions behavior-focused (state changes/outcomes), not implementation internals.

## 5) Coverage and quality gates
### Observed state
- Coverage scripts exist at root and module level, but configuration and consistency vary by module.
- Root includes only `Modules/*/app` as source in `phpunit.xml`.
- A documented plan exists for 100% line and type coverage.

### Evidence
- Root coverage script: `laravel/composer.json` (`test:coverage:modules`)
- Module scripts:
  - `laravel/Modules/Cms/composer.json` (`test`, `test-coverage`)
  - `laravel/Modules/Xot/composer.json` (`test-coverage`, `pest-plugin-type-coverage`)
- Coverage plan: `docs/testing/coverage-100-plan.md`

### Quality risks
- Inconsistent per-module test script options (`--no-coverage` vs default coverage commands).
- Type coverage plugin present in some modules (not universally aligned).
- Placeholder tests exist in some feature areas and can inflate confidence without validating behavior.

### Evidence
- Placeholder example: `laravel/Modules/Cms/tests/Feature/Auth/LoginTest.php`

## 6) Recommended testing guardrails
1. Standardize test file naming to `*Test.php` (PascalCase) and remove duplicates.
2. Keep one `Pest.php` per module (`tests/Pest.php`) with consistent setup.
3. Enforce explicit DB transaction connections in each module `TestCase`.
4. Use a consistent mocking policy:
   - Unit: contract mocks (`Mockery`, container `mock`).
   - Integration: Laravel fakes (`Http`, `Storage`, `Event`, etc.).
5. Add minimum coverage/type-coverage gates incrementally per module, aligned with `docs/testing/coverage-100-plan.md`.
6. Replace placeholder assertions with behavioral checks tied to real outcomes.
