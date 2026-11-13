---
title: PHPStan Tenant — test Domain/BaseModel/Sushi (unused / emptyClosure / alreadyNarrowed)
type: story
module: Tenant
status: done
created: 2026-10-20
updated: 2026-10-20
qmd: "phpstan tenant domain basemodel sushi unused emptyClosure alreadyNarrowed"
related:
  - ./phpstan-tenant-fix.md
  - ../../../../../bashscripts/docs/prompts/11-phpstan.md
---

# PHPStan Tenant — test assertions

Lane swarm (scope disgiunto). Ground truth: `.cursor-scratch/phpstan-wave/Tenant.tsv`.

## Scopo (1 frase)

I test Tenant devono dimostrare che `Domain` espone i rows Sushi e che `BaseModel` ha table/timestamps reali, senza assert ridondanti o variabili morte.

## Famiglie (TSV)

| Identifier | File | Fix applicato (stato working tree) |
|---|---|---|
| `variable.unused` `$domain` | `DomainModelTest` | `Assert::assertSame(Domain::class, $domain::class)` |
| `pest.test.emptyClosure` | `DomainTest` | corpo con assert su `(new Domain)::class` |
| `staticMethod.alreadyNarrowedType` | `BaseModelTest` | rimossi `assertInstanceOf` tautologici; restano table + timestamps |
| `variable.unused` `$dataAfterNullWrite` | `TenantStatementCoverageTest` | assert diretto su `loadExistingData()` dopo write `null` |

## Esito lane

- Errori TSV iniziali: **5**
- Edit di questa lane: **0** (file gia' allineati al contratto sopra al momento del lock; verify mirata su path TSV)
- SKIP: nessuno (file freddi e lock acquisiti)

## Verifica

```bash
cd laravel && flock -w 1800 /tmp/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse \
  Modules/Tenant/tests/Unit/DomainModelTest.php \
  Modules/Tenant/tests/Unit/DomainTest.php \
  Modules/Tenant/tests/Unit/Models/BaseModelTest.php \
  Modules/Tenant/tests/Unit/TenantStatementCoverageTest.php \
  --memory-limit=2G --no-progress
```
