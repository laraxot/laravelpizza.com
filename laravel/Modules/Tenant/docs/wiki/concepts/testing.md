---
title: "Testing in Tenant"
type: concept
tags: [tenant, testing, pest, phpstan, sushi]
created: 2026-06-05
updated: 2026-06-13
qmd: "Tenant testing Pest TestCase sushi JSON PHPStan mockService"
issues:
  - "https://github.com/laraxot/platform/issues/52"
discussions:
  - "https://github.com/laraxot/module_progetto corrente_fila5/discussions/53"
related:
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
  - ../../../Xot/docs/wiki/rules/module-testcase-xotbase-hierarchy.md
---

# Testing in Tenant

## Pest PHP

`uses(\Modules\Tenant\Tests\TestCase::class)`.

## TestCase

- `DatabaseTransactions` su `sqlite`, `tenant`, `user`
- Helper: `tenantModel()`, `secondTenantModel()`, `sushiModel()`, `sushiJsonPath()`, `setCurrentTenant()`
- **Non** ridefinire `mockService()` — usare quello di `XotBaseTestCase`
- **Non** re-dichiarare `$model` / `$baseModel` con tipi stretti: il parent espone `mixed` (PHPStan covarianza)

## PHPStan (2026-06-13)

- `SushiToJsonTraitIntegrationTest`: usare `secondTenantModel()->id` invece di `$this->secondTenant->id`
- Rimosse proprietà duplicate `BaseModel` / `TestSushiModel` sul TestCase

## Quality gate

```bash
cd laravel
./vendor/bin/pest Modules/Tenant/tests
./vendor/bin/phpstan analyse Modules/Tenant
```

## Completamento

- [ ] Test integrazione multi-tenant con Filament panel bound
- [ ] Documentare contratto `TenantService::filePath` per JSON Sushi
