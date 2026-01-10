# TestCase SQLite to MySQL Fix - Gdpr Module

## Problema Identificato

Il TestCase del modulo Gdpr (100 righe) commette lo STESSO errore degli altri moduli.

### ❌ Cosa Fa di Sbagliato

```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO: Forza SQLite
    $this->app['config']->set('database.default', 'testing');
    $this->app['config']->set('database.connections.testing', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);

    // ❌ SBAGLIATO: Sovrascrive connessioni
    $this->app['config']->set('database.connections.user', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
    $this->app['config']->set('database.connections.gdpr', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);

    // ❌ SBAGLIATO: Crea tabelle manualmente
    if (!Schema::connection('user')->hasTable('users')) {
        Schema::connection('user')->create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // ... 15 righe di definizione manuale
        });
    }
}
```

### Perché È Sbagliato

1. **Ignora .env.testing** - MySQL configurato dall'utente viene sovrascritto con SQLite
2. **Problemi di dialetto SQL** - SQLite ≠ MySQL, test falsi positivi
3. **Viola DRY** - Duplica le migration con Schema::create()
4. **Viola KISS** - 100 righe quando bastano ~35
5. **Viola indicazioni utente** - Opposto di ciò che richiesto

---

## Soluzione

### Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Gdpr module.
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

        $this->artisan('migrate', ['--database' => 'gdpr']);
        $this->artisan('migrate', ['--database' => 'user']);
        $this->artisan('migrate', ['--database' => 'xot']);
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            GdprServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
```

### Cosa Cambia

- ✅ Da 100 righe a ~40 righe (-60%)
- ✅ Usa MySQL da .env.testing
- ✅ Usa migration reali (no Schema::create)
- ✅ DatabaseTransactions per isolation
- ✅ Nessun override di configurazione
- ✅ Nessun commento ovvio
- ✅ Rispetta DRY + KISS

---

## Dipendenze Migration

Il modulo Gdpr dipende da:

1. **gdpr database** - Tabelle GDPR (consent, data requests, etc.)
2. **user database** - Tabella users (per relazioni)
3. **xot database** - Tabelle base

Tutte queste devono essere migrate prima dei test nel setUp() come fatto sopra.

---

## Riferimenti

- Pattern: `Modules/Job/tests/TestCase.php`
- Pattern: `Modules/Activity/tests/TestCase.php`
- Pattern: `Modules/User/tests/TestCase.php`
- Filosofia: `Modules/Job/docs/testcase-philosophy-analysis.md`

---

**Data:** 2026-01-09
**Stato:** Pronto per implementazione
**Righe:** 100 → ~40 (-60%)
**Filosofia:** MySQL Production = MySQL Tests ✅
