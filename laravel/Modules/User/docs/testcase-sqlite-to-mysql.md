# TestCase SQLite to MySQL Fix - User Module

## Problema Identificato

Il TestCase del modulo User (102 righe) forza SQLite su TUTTE le connessioni, ignorando .env.testing.

### ❌ Cosa Fa di Sbagliato

```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO: Crea database SQLite shared
    $dbName = 'file:memdb_'.Str::random(10).'?mode=memory&cache=shared';

    $connections = [
        'sqlite', 'mysql', 'mariadb', 'pgsql',
        'user', 'xot', 'activity', 'geo', 'cms',
        'notify', 'lang', 'tenant', 'blog', 'media',
    ];

    // ❌ SBAGLIATO: Forza TUTTE le connessioni a usare SQLite
    foreach ($connections as $conn) {
        $this->app['config']->set("database.connections.{$conn}.database", $dbName);
        $this->app['config']->set("database.connections.{$conn}.driver", 'sqlite');
    }

    // ❌ SBAGLIATO: Crea funzioni custom SQLite (md5, unhex)
    foreach ($connections as $conn) {
        $pdo = DB::connection($conn)->getPdo();
        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('md5', ...);
            $pdo->sqliteCreateFunction('unhex', ...);
        }
    }
}
```

### Perché È Sbagliato

1. **Ignora .env.testing** - MySQL configurato dall'utente viene sovrascritto
2. **Funzioni Custom SQLite** - `md5()` e `unhex()` esistono già in MySQL!
3. **Shared In-Memory** - Complica setup invece di semplificare
4. **Viola indicazioni utente** - Opposto di MySQL richiesto

### MySQL Ha Già Queste Funzioni!

```sql
-- MySQL nativo:
SELECT MD5('test');        -- ✅ Funziona in MySQL
SELECT UNHEX('48656c6c6f'); -- ✅ Funziona in MySQL

-- SQLite invece le deve creare manualmente
```

---

## Soluzione

### Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);

        $this->artisan('migrate', ['--database' => 'user']);
        $this->artisan('migrate', ['--database' => 'xot']);
    }
}
```

### Cosa Cambia

- ✅ Da 102 righe a ~35 righe (-66%)
- ✅ Usa MySQL da .env.testing
- ✅ Nessuna funzione custom (MySQL le ha già!)
- ✅ Nessun shared in-memory
- ✅ DatabaseTransactions per isolation
- ✅ Mantiene config XotData necessaria
- ✅ Rispetta DRY + KISS

---

## Note su XotData

Il setup di XotData sembra necessario per il modulo User:

```php
config(['xra.pub_theme' => 'Meetup']);
config(['xra.main_module' => 'User']);

\Modules\Xot\Datas\XotData::make()->update([
    'pub_theme' => 'Meetup',
    'main_module' => 'User',
]);
```

Questo viene mantenuto perché è specifico del modulo User e non è un override di database.

---

## Funzioni SQL: MySQL vs SQLite

### SQLite (MANCANTI)
```php
// ❌ SQLite non ha md5() e unhex() built-in
$pdo->sqliteCreateFunction('md5', fn($v) => md5($v));
$pdo->sqliteCreateFunction('unhex', fn($v) => $v);
```

### MySQL (BUILT-IN)
```sql
-- ✅ MySQL ha già queste funzioni!
SELECT MD5('test');
SELECT UNHEX('48656c6c6f');
SELECT HEX('hello');
```

**Conclusione:** Usare MySQL elimina la necessità di queste workaround!

---

## Implementazione

### Step 1: Documentare (Fatto)

Questo file documenta il problema e la soluzione.

### Step 2: Applicare Fix

Sostituire il contenuto con il pattern corretto.

### Step 3: Verificare

```bash
./vendor/bin/phpstan analyze Modules/User/tests/TestCase.php --level=10
./vendor/bin/pint Modules/User/tests/TestCase.php
```

### Step 4: Testare

```bash
./vendor/bin/pest Modules/User/tests/
```

---

## Riferimenti

- Pattern: `Modules/Job/tests/TestCase.php`
- Pattern: `Modules/Activity/tests/TestCase.php`
- Filosofia: `Modules/Job/docs/testcase-philosophy-analysis.md`

---

**Data:** 2026-01-09
**Stato:** Pronto per implementazione
**Righe:** 102 → ~35 (-66%)
**Funzioni Custom:** Non più necessarie con MySQL ✅
