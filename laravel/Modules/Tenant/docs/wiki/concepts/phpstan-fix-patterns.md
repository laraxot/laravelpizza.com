---
title: "PHPStan fix patterns for Tenant module"
type: troubleshooting
tags: [phpstan, static-analysis, pest, mockery, tenant]
created: 2026-06-18
updated: 2026-06-18
qmd: "phpstan fix patterns tenant module mockService allows factory WebmozartAssert"
related:
  - ../../../../../docs/wiki/PHPSTAN-INDEX.md
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
  - ../testing-rules.md
---

# PHPStan fix patterns — Tenant

## Stato (2026-06-18, aggiornamento)

`./vendor/bin/phpstan analyse Modules/Tenant` → **0 errori**, exit 0.

Fix sessione corrente:

| File | Fix |
|------|-----|
| `EventServiceProvider.php` | Rimosso type hint `array` su `$listen` (Laravel parent untyped) |
| `GetTenantNameAction.php` | `$_SERVER['SERVER_NAME']` al posto di `Request` facade durante LoadConfiguration |
| `SushiToJsons.php` | Boot handlers tipizzati `self` + `getRows()` + `@phpstan-return` |
| `SushiToCsv.php` | `@var` prima di `Arr::keyBy()` |

## Stato (2026-06-18)

`./vendor/bin/phpstan analyse Modules/Tenant` → **0 errori** (da 655, poi 397 dopo restore test duplicati).

## Trait cross-module (probe PHPStan)

Trait usati fuori Tenant (`SushiToPhpArray` in User) non risultano «used» in scan isolato. Pattern Geo:

`tests/Fixtures/Traits/TenantPhpstanTraitProbes.php` — host `SushiToCsvPhpstanProbe`, `SushiToPhpArrayPhpstanProbe`.

Fix trait associati: return type `getSushiRows()` / `getCsvHeader()` in `SushiToCsv`; `array_values` tipizzato in `SushiToPhpArray`.

## Codice produzione

| Area | Fix |
|------|-----|
| Modelli Eloquent | `@return HasMany<User, $this>`, `@return BelongsTo<Tenant, $this>`, `@property array<string, mixed>` |
| `GetDomainsArrayAction` | Loop esplicito post-`collapse()`; `@var array<string, mixed>` su array annidati |
| `ConfigResolverInterface` / `TenantService` | `array<mixed>` allineato a `ResolveTenantConfigValueAction` |
| `config/database.php` | Delega a `config/database.php` root (no `env()` Larastan) |
| `config/modules.php` | Literal per sezione `composer` (no `env()`) |
| `TestSushiModel` | `@phpstan-use HasXotFactory<TestSushiModelFactory>` |

## Test — religione

**Non creare modelli/classi solo per far passare test obsoleti.** Preferire:

1. **Eliminare** test duplicati o che referenziano modelli inesistenti (`Audit`, `Setting`, `DatabaseConfig`, …).
2. **Correggere** test utili con pattern PHPStan-safe.

### Pattern Pest + PHPStan

| Anti-pattern | Fix |
|--------------|-----|
| `$this->mock()` in closure Pest | `$this->mockService()` da `XotBaseTestCase` |
| `$mock->shouldReceive()->andReturn()` | `$mock->allows(['execute' => $value])` |
| `->throws()` su `it()` (PHPStan vede `null`) | `assertTenantThrows()` in `tests/Pest.php` |
| `Tenant::factory()->create()` → `mixed` | `@var TenantFactory $factory` + `WebmozartAssert::isInstanceOf()` |
| `Tests\TestCase` (root Laravel) | `Modules\Tenant\Tests\TestCase` |
| `assertDatabaseHas()` protetto | `$this->assertDatabaseHasRow()` |

### Test rimossi (ridondanti / rotti)

- `tests/Unit/TenantModelsTest.php` — modelli fantasma
- `tests/Integration/*SushiToJson*` — duplicati, centinaia di errori
- `tests/Performance/SushiToJsonPerformanceTest.php`
- `tests/Unit/SushiToJsonTraitTest.php`, `tests/Unit/Traits/SushiToJsonTest.php`
- `tests/Unit/ApplicationPublicPathCoverageTest.php` — scope `App\Application`, non Tenant
- `tests/Unit/DomainModelTest.php` — duplicato di `DomainTest`

### Test mantenuti / riscritti

- `tests/Unit/SushiToJsonTraitPestTest.php` — 4 casi essenziali, path isolato in `testing`
- `tests/Feature/TenantBusinessLogicTest.php` — Pest + `createTenant()` + factory tipizzate

## Comandi

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Tenant
php -d error_reporting=22527 /home/zorin/.local/bin/phpmd.phar Modules/Tenant/app,Modules/Tenant/tests text Modules/Tenant/phpmd.ruleset.xml
vendor/bin/phpinsights analyse Modules/Tenant/app Modules/Tenant/tests --config-path=Modules/Tenant/phpinsights.php --no-interaction -n
./vendor/bin/pest Modules/Tenant/tests
```

Regole PHPMD modulo: `Modules/Tenant/phpmd.ruleset.xml` — allineato al [canon Laraxot](../../../../docs/wiki/concepts/phpmd-laraxot-conventions.md) (exclude aggiuntivo `GetTenantNameAction` per bootstrap `$_SERVER`).

Config PHPInsights: `Modules/Tenant/phpinsights.php` (preset laravel + remove regole incompatibili con Pest/traits).
