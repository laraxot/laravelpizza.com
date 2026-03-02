# TestCase SQLite to MySQL Fix - Activity Module

## Problema Identificato

Il TestCase del modulo Activity (156 righe) commette lo STESSO errore del modulo Job:

### ❌ Cosa Fa di Sbagliato

```php
protected function setUp(): void
{
    parent::setUp();

    // ❌ SBAGLIATO: Sovrascrive con SQLite
    $this->app['config']->set('database.default', 'testing');
    $this->app['config']->set('database.connections.testing', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);

    // ❌ SBAGLIATO: Sovrascrive TUTTE le connessioni
    $this->app['config']->set('database.connections.user', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
    $this->app['config']->set('database.connections.xot', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
    $this->app['config']->set('database.connections.activity', [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);

    // ❌ SBAGLIATO: Crea tabelle manualmente
    Schema::connection('user')->create('users', function (Blueprint $table) {
        // ... definizione manuale
    });
}
```

### Perché È Sbagliato

1. **Ignora .env.testing** - L'utente ha configurato MySQL, il test lo sovrascrive con SQLite
2. **Problemi di dialetto SQL** - SQLite ≠ MySQL, test falsi positivi
3. **Viola DRY** - Duplica le migration con Schema::create()
4. **Viola KISS** - 156 righe quando bastano 30
5. **Viola indicazioni utente** - Opposto di ciò che richiesto

---

## Soluzione

### Pattern Corretto (come Job Module)

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Activity module.
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

        $this->artisan('migrate', ['--database' => 'activity']);
        $this->artisan('migrate', ['--database' => 'user']);
        $this->artisan('migrate', ['--database' => 'xot']);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ActivityServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
```

### Cosa Cambia

- ✅ Da 156 righe a ~40 righe (-74%)
- ✅ Usa MySQL da .env.testing
- ✅ Usa migration reali (no Schema::create)
- ✅ DatabaseTransactions per isolation
- ✅ Nessun override di configurazione
- ✅ Nessun commento ovvio
- ✅ Rispetta DRY + KISS

---

## Implementazione

### Step 1: Backup Vecchio File

```bash
cp Modules/Activity/tests/TestCase.php Modules/Activity/tests/TestCase.php.old
```

### Step 2: Applicare Nuovo Pattern

Sostituire completamente il contenuto con il pattern corretto.

### Step 3: Verificare

```bash
./vendor/bin/phpstan analyze Modules/Activity/tests/TestCase.php --level=10
./vendor/bin/pint Modules/Activity/tests/TestCase.php
```

### Step 4: Testare

```bash
./vendor/bin/pest Modules/Activity/tests/
```

---

## Dipendenze Migration

Il modulo Activity dipende da:

1. **activity database** - Tabelle event sourcing
2. **user database** - Tabella users (per causedBy)
3. **xot database** - Tabelle base

Tutte queste devono essere migrate prima dei test:

```bash
php artisan migrate --env=testing --database=activity
php artisan migrate --env=testing --database=user
php artisan migrate --env=testing --database=xot
```

O nel TestCase setUp() come fatto sopra.

---

## Note Specifiche Activity Module

### Event Sourcing

Il modulo usa Spatie Event Sourcing. Il binding EventSubscriber può rimanere se necessario:

```php
protected function setUp(): void
{
    parent::setUp();

    // Questo può rimanere se serve
    $this->app->bind(EventSubscriber::class, function (): EventSubscriber {
        return new EventSubscriber(EloquentStoredEventRepository::class);
    });

    $this->artisan('migrate', ['--database' => 'activity']);
    $this->artisan('migrate', ['--database' => 'user']);
    $this->artisan('migrate', ['--database' => 'xot']);
}
```

### User Dependency

Activity dipende da User per `causedBy()`. Assicurarsi che:
- User migration sia eseguita
- UserServiceProvider sia caricato
- Tabella users esista

---

## Riferimenti

- Pattern di riferimento: `Modules/Job/tests/TestCase.php`
- Filosofia: `Modules/Job/docs/testcase-philosophy-analysis.md`
- Documentazione generale: `laravel/docs/test-corrections-complete-[DATE].md`

---

**Data:** [DATE]
**Stato:** Pronto per implementazione
**Righe:** 156 → ~40 (-74%)
**Filosofia:** MySQL Production = MySQL Tests ✅
