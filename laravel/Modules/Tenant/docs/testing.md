---
title: "Test del modulo Tenant"
type: reference
module: Tenant
updated: 2026-11-25
qmd: "tenant test pest TestCase binding uses DatabaseTransactions connessione tenant sushi fixture isolamento contenuti coverage"
---

# Test del modulo Tenant

Solo Pest, nel modulo (`laravel/Modules/Tenant/tests/`). Mai PHPUnit diretto, mai `RefreshDatabase`, mai `migrate:fresh` o
`--force`: i dati sono sacri.

## Com'e' fatta la suite (misurata il 2026-11-25)

65 file PHP, 45 `*Test.php`, distribuiti cosi':

| Cartella | Cosa prova |
|---|---|
| `tests/Unit/Actions/{Config,Domains,Ente,Json,Markdown,Models,Translations}` | una Action per file, senza rete e senza web server |
| `tests/Unit/Models`, `tests/Unit/Datas` | modelli e `EnteData` |
| `tests/Unit/Traits` | i cinque trait Sushi (`SushiToJson`, `SushiToJsons`, `SushiToCsv`, `SushiToPhpArray`, `SushiConnectionByName`) |
| `tests/Unit/TenantConfigTrackedTest.php` | guardia: `config/<tenant>` deve essere tracciata da git ([story](bmad/stories/tenant-config-untracked-by-gitignore.story.md)) |
| `tests/Feature` | alias delle connessioni, scope multi-tenant, routing per dominio, risoluzione del modello |
| `tests/Integration`, `tests/Performance` | integrazione dei trait con DB; saltano se il DB di test non e' raggiungibile |
| `tests/Fixtures`, `tests/Unit/Fixtures` | sottoclassi nominate usate dai test dei trait |

Residui noti: `tests/Feature/TenantBusinessLogicTest.php.skip` (file disattivato) e dieci test "coverage"
(`TenantCoverageBoostTest`, `TenantGapsCoverageTest`, `TenantStatementCoverageTest`...) nati per alzare la percentuale: vanno
accorpati nei test di regola ([audit-and-roadmap](audit-and-roadmap.md), TEN-P2-07).

## Binding del TestCase

Ogni file di test che usa l'applicazione o i metodi di `Modules\Tenant\Tests\TestCase` lo lega da solo:

```php
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);
```

Mai `uses(...)->in(...)` in `tests/Pest.php`: il runner di root non lo esegue (i test restano senza
applicazione) e con `--test-directory` raddoppia il binding (`TestCaseAlreadyInUse`). Decisione e guardia:
[ADR Xot 0034](../../Xot/docs/adr/0034-pest-testcase-binding-per-file.md).

## `Modules\Tenant\Tests\TestCase`

- `getPackageProviders()`: Xot, User e Tenant. Usa `Modules\Xot\Tests\CreatesApplication` e `DatabaseTransactions`
  (rollback a fine test, non rigenerazione dello schema).
- Espone `tenant` e `secondTenant` (due `Modules\Tenant\Models\Tenant`) e `sushiModel`, per i test che servono due tenant.
- `tenantDbUnavailable()` prova `select 1` sulla connessione `tenant`; i test che hanno bisogno del DB chiamano
  `skipCurrentTest($motivo)` invece di fallire. E' il modo dichiarato di saltare quando il DB non c'e'; un test saltato non
  prova nulla e va riportato come tale.
- La connessione `tenant` (`BaseModel::$connection`) deve esistere nel setup: un test che usa un modello del modulo senza
  configurarla fallisce con `Database connection [tenant] not configured`. Il pattern corretto e' puntare tutte le
  connessioni modulari allo stesso sqlite in memoria prima di migrare, come fa `Modules\User\Tests\TestCase`.
- Se `DB_DATABASE_USER` e' valorizzata nell'ambiente, la `setUp` puo' fallire con "Unknown database": per i test di modulo la
  si lascia vuota (`DB_DATABASE_USER= vendor/bin/pest ...`).

## Test dei trait Sushi

Le fixture **estendono l'host reale del trait**, non `Model` nudo: `SushiToCsv` -> modello con CSV reale,
`SushiToPhpArray` -> modello con array PHP, `SushiToJsons` -> `Tenant\Models\BaseModelJsons`. I test restano in memoria
(`forceFill`, file temporaneo e mock di `GetTenantFilePathAction`). `setAttribute()` nei trait e' il contratto Eloquent delle
colonne dinamiche. Le fixture non vanno in `app/`: `TestSushiModel` e `TestCommand` oggi vi stanno ancora (TEN-P2-03).

## Isolamento dei contenuti JSON

Sotto Pest, `GetTenantFilePathAction` reindirizza i percorsi `database/content/*` su
`storage/framework/testing/tenant-content/<tenant>/`: i test che scrivono record Sushi non toccano i JSON versionati in
`config/<tenant>/` ([ADR 0002](adr/0002-tenant-json-content-isolated-in-tests.md), [sushi-json-models](sushi-json-models.md)).
Non vale per gli altri file di config, vedi [configuration](configuration.md).

## Lanciare i test

```bash
cd laravel
DB_DATABASE_USER= vendor/bin/pest Modules/Tenant/tests --no-coverage
vendor/bin/pest Modules/Tenant/tests --filter=GetTenantNameActionTest
vendor/bin/pest --group=TENANT-NAME-INV-1        # invarianti dei contratti, quando coperti
vendor/bin/phpstan analyse Modules/Tenant        # livello 10
```

Pest non si esegue sull'host di produzione: i test si scrivono e si lanciano in sviluppo, e la story dichiara dove sono stati
eseguiti. Gli ID `TENANT-*-INV-N` dei [contratti](contracts/index.md) non hanno ancora un `->group('<ID>')` nei test: la
copertura degli invarianti e' "non coperto" finche' non si aggiungono.

## Regole per un test nuovo

1. Nome che dice il comportamento (`it('rifiuta un percorso con ..')`), struttura Arrange-Act-Assert.
2. Una Action = un file in `tests/Unit/Actions/<Area>/`; la logica di un contratto si prova con il suo ID come `group`.
3. Niente `@codeCoverageIgnore`, niente test svuotati per far tacere PHPStan: se l'input e' impossibile si toglie dal test,
   non si allarga il contratto applicativo.
4. Se il test ha bisogno del DB e non c'e', `skipCurrentTest()`, mai un `try/catch` che ingoia.
5. Una story PHPStan di riferimento per le fixture: [0008-phpstan-test-harness-contracts](stories/0008-phpstan-test-harness-contracts.story.md)
   e [0007-phpstan-sushi-boundaries](stories/0007-phpstan-sushi-boundaries.story.md).
