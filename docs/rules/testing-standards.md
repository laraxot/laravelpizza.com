# Testing Standards - Laraxot & Super Mucca

## Core Mandates
1.  **100% Coverage**: Every line of code, especially Spatie Actions, must be covered by Pest tests.
2.  **Pest Only**: No PHPUnit tests allowed. Convert existing ones.
3.  **No RefreshDatabase**: The `RefreshDatabase` trait is forbidden. Use `DatabaseTransactions` instead.
4.  **Centralized Transaction Trait**: `DatabaseTransactions` belongs in `Modules\Xot\Tests\XotBaseTestCase` to avoid duplicate trait declarations.
5.  **Multi-Connection Isolation**: For modules using dedicated connections, explicitly list them in module `TestCase` by extending the base list:
    ```php
    protected array $connectionsToTransact = ['mysql', 'activity', 'user'];
    ```
6.  **Environment**: Tests MUST load `.env.testing` and target `_test` databases.
7.  **Migrations Lifecycle**: `Modules\Xot\Tests\XotBaseTestCase` MUST prepare schema with `artisan migrate --env=testing` exactly once per test process in `createApplication()` (before `DatabaseTransactions`), using only required `--path` values for the active suite (es. `Modules/Xot`, `Modules/User`, `Modules/Activity`) to avoid unrelated module migrations. Never use `--force`, `migrate:fresh`, `module:migrate`, or `RefreshDatabase`.
8.  **Trait Signature Compatibility**: when using `DatabaseTransactions`, do not override framework trait methods with stricter signatures (example: no return type added to `connectionsToTransact()`), otherwise Pest fails with fatal declaration mismatch.
9.  **No Constructor Connection Overrides**: Models MUST NOT override the connection in the constructor for testing. This breaks `TenantServiceProvider` dynamic mapping.
10. **Module Coverage Scope**: when running module-focused suites (example `--testsuite=Activity --coverage`), coverage source filtering must be scoped to the module and strict dependencies; avoid whole `Modules/*/app` filters that flatten report quality with unrelated files.
11. **Xot Migration Helpers**: in migrations extending `XotBaseMigration`, do not duplicate helper guards (`tableCreate()` already contains `tableExists()` checks). Keep migrations concise and rely on helper semantics.
12. **Migrate Diagnostics Ladder**: when `php artisan migrate --env=testing` fails, always document a 3-step diagnosis in order: (a) infra connectivity (`mysql` reachability), (b) sqlite path normalization/config behavior, (c) migration structure conflicts (duplicate columns/indexes). Do not jump directly to test fixes before this chain is resolved.
13. **Docs Filename Rule**: markdown documentation files must not include dates in their filename. Use semantic names only (no `YYYY-MM-DD` suffix/prefix).
14. **Coverage Plan as Handoff**: for module-coverage work in multi-agent mode, `Modules/<Module>/docs/coverage-plan.md` must be updated after each batch and treated as shared state with Issue/Discussion claim/release comments.
15. **Coverage Scope Integrity**: if a module coverage command reports files from unrelated modules, mark the report as scope-polluted and do not use that percentage as completion KPI until source scope is fixed.

## Spatie Actions Testing
- Test the `execute()` method directly.
- Ensure all input variations (DTOs, arrays) are covered.
- Mock external APIs, but keep database interactions real (transactional).

## Validation
- After writing tests, run:
  ```bash
  ./vendor/bin/pest --compact --coverage --min=100
  ```
