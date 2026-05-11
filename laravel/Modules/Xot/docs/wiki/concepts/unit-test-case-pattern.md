---
title: UnitTestCase Pattern — test puri senza MySQL
module: Xot
type: concept
updated: 2026-04-20
status: active
---

# UnitTestCase Pattern

## Problema

Il `TestCase` base di ogni modulo (es. `Modules\Geo\Tests\TestCase`) estende Laravel con `DatabaseTransactions` e `$connectionsToTransact = ['mysql', 'user']`. Questo causa un `PDOException` su qualsiasi macchina che non abbia MySQL configurato correttamente — anche per test che **non toccano il database**.

```
SQLSTATE[HY000] [1045] Access denied for user 'forge_mysql_25_1'@'localhost' (using password: NO)
```

## Soluzione: UnitTestCase per ogni modulo

Per i test puri (solo logica PHP, `Http::fake()`, nessuna query DB), creare un `UnitTestCase` separato che usa `CreatesApplication` di Xot ma **senza** `DatabaseTransactions` e senza connessioni MySQL.

### Template

```php
<?php

declare(strict_types=1);

namespace Modules\<Name>\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\<Name>\Providers\<Name>ServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

abstract class UnitTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            <Name>ServiceProvider::class,
        ];
    }
}
```

### Uso nei test Pest

```php
use Modules\Geo\Tests\UnitTestCase;

uses(UnitTestCase::class);

test('my pure unit test', function (): void {
    // nessuna connessione DB richiesta
});
```

## Quando usare quale

| TestCase | Quando |
|----------|--------|
| `Modules\<Name>\Tests\TestCase` | Test di integrazione con DB reale (MySQL/SQLite) |
| `Modules\<Name>\Tests\UnitTestCase` | Test puri: classe PHP, Http::fake(), logica business |

## Moduli con UnitTestCase già creato

- `Modules\Geo\Tests\UnitTestCase` — introdotto 2026-04-20 per `MapPickerTest`

## CreatesApplication — fonte Xot

`Modules\Xot\Tests\CreatesApplication` è il trait che bootstrap-a l'applicazione Laravel nei test. È la fonte unica condivisa da tutti i moduli: i `UnitTestCase` di ogni modulo devono usare questo trait, non reimplementarlo.
